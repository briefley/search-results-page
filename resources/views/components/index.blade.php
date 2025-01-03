<div
    x-data="{ handleEnter() {
        if ($wire.search.trim() !== '') {
            $wire.call('redirectToSearchResultsPage');
        }
    }}"
    x-on:focus-first-global-search-result.stop="$el.querySelector('.fi-global-search-result-link')?.focus()"
    class="fi-global-search flex items-center"
>
    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::GLOBAL_SEARCH_START) }}

    <div class="py-2.5 w-186.5 sm:relative">
        <x-filament-panels::global-search.field
            x-on:keydown.enter.prevent="handleEnter()"
        />

        <x-filament-panels::global-search.results-container
            :results="$results"
        />
    </div>

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::GLOBAL_SEARCH_END) }}
</div>
