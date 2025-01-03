<?php

namespace Briefley\SearchResultsPage;

use Briefley\SearchResultsPage\Livewire\SearchResultsPage;
use Filament\Facades\Filament;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SearchResultsPageServiceProvider extends PackageServiceProvider
{
    public static string $name = 'search-results-page';

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

    public function boot(): void
    {
        parent::boot();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'search-results-page');
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/search-results-page'),
        ], 'search-results-page-views');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'search-results-page');
        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/search-results-page'),
        ], 'search-results-translations');
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
