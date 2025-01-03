<?php

namespace Briefley\SearchResultsPage\Traits;

use Briefley\SearchResultsPage\Livewire\SearchResultsPage;
use Filament\GlobalSearch\GlobalSearchResult;

trait RedirectsToSearchResultsPage
{
    public function redirectToSearchResultsPage()
    {
        if (! blank($this->search)) {
            return redirect()->to(SearchResultsPage::getUrl(['search' => $this->search]));
        }
    }
}
