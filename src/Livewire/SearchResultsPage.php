<?php

namespace App\Filament\Pages;

use Filament\Facades\Filament;
use Filament\Pages\Page;
use Livewire\Attributes\Url;

class SearchResultsPage extends Page
{
    protected static string $view = 'search-results-page::components.search-results';

    #[Url]
    public string $search = '';

    public $results;

    public function mount()
    {
        $this->results = $this->performSearch();
    }

    protected function performSearch()
    {
        $results = Filament::getGlobalSearchProvider()->getResults($this->search);
        if (! $results) {
            return [];
        }
        $categories = $results->getCategories();

        // Convert the results into an array
        return collect($categories)
            ->mapWithKeys(function ($items, $category) {
                return [
                    $category => collect($items)->map(function ($item) {
                        return [
                            'title' => $item->title,
                            'url' => $item->url,
                            'details' => $item->details,
                            'actions' => $item->actions,
                        ];
                    })->toArray(),
                ];
            })->toArray();
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-search';
    }

    public static function getNavigationLabel(): string
    {
        return 'Search Results';
    }
}
