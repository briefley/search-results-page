<?php

namespace Briefley\SearchResultsPage;

use App\Filament\Pages\SearchResultsPage;
use Filament\Contracts\Plugin;
use Filament\Panel;

class SearchResultsPagePlugin implements Plugin
{
    public function getId(): string
    {
        return 'search-results-page';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->pages([
                SearchResultsPage::class,
            ]);
    }
}
