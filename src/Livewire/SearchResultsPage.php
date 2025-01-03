<?php

namespace Briefley\SearchResultsPage\Livewire;

use Filament\Facades\Filament;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Livewire\Attributes\Url;
use Str;

class SearchResultsPage extends Page
{
    protected static string $view = 'search-results-page::components.search-results';

    protected static ?string $title = '';

    #[Url]
    public string $search = '';

    public array $page = [];

    #[Url]
    public string $categoryPage = '';

    public Collection $results;

    public int $perPage = 10;

    public function mount(): void
    {
        $this->performSearch();
        $this->initializePages();
    }

    public function nextPage(string $category): void
    {
        $maxPageAmount = ceil($this->results[$category][0]['details']['totalRecords'] / $this->perPage);

        if ($this->page[$category] < $maxPageAmount) {
            $this->page[$category]++;
        } else {
            $this->page[$category] = $maxPageAmount;
        }

        $this->updateQueryString($category);
        $this->performSearch();
    }

    public function previousPage(string $category): void
    {
        $this->page[$category] = $this->page[$category] > 1
            ? $this->page[$category] - 1
            : $this->page[$category];

        $this->updateQueryString($category);
        $this->performSearch();
    }

    protected function performSearch(): void
    {
        app('request')->merge([
            'categoryPage' => $this->categoryPage,
        ]);

        $results = Filament::getGlobalSearchProvider()->getResults($this->search);
        if ($results) {
            $categories = $results->getCategories();
            $this->results = collect($categories)
                ->mapWithKeys(function ($items, $category) {
                    return [
                        \Str::slug($category, '_') => collect($items)->map(function ($item) {
                            return [
                                'title' => $item->title,
                                'url' => $item->url,
                                'details' => $item->details,
                                'actions' => $item->actions,
                            ];
                        }),
                    ];
                });
        }
    }

    private function initializePages(): void
    {
        if ($this->categoryPage && ! $this->page) {
            parse_str($this->categoryPage, $this->page);
        }

        foreach ($this->results as $categoryName => $resultsInCategory) {
            if (! isset($this->page[$categoryName])) {
                $this->page[$categoryName] = 1;
            }
        }
    }

    private function updateQueryString(string $category): void
    {
        parse_str($this->categoryPage, $queryArray);

        $queryArray[$category] = $this->page[$category];

        $this->categoryPage = http_build_query($queryArray);
    }
}
