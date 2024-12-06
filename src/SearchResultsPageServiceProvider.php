<?php

namespace Briefley\SearchResultsPage;

use Briefley\SearchResultsPage\Livewire\SearchResultsPage;
use Filament\Facades\Filament;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SearchResultsPageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('search-results-page')
            ->hasTranslations()
            ->hasViews();
    }

    public function packageBooted()
    {
        Livewire::component(
            name: 'search-results-page',
            class: SearchResultsPage::class
        );

        Filament::registerPages([
            SearchResultsPage::class,
        ]);
    }
}
