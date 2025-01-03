@props([
    'results',
])

<div
    x-data="{
        isOpen: false,

        open: function (event) {
            this.isOpen = !!(new URLSearchParams(window.location.search).get('search'))
        },

        close: function (event) {
            this.isOpen = false
        },
    }"
    x-on:click.away="close()"
    x-on:keydown.escape.window="close()"
    x-on:keydown.up.prevent="$focus.wrap().previous()"
    x-on:keydown.down.prevent="$focus.wrap().next()"
    x-on:open-global-search-results.window="$nextTick(() => open())"
    x-show="isOpen"
    x-transition:enter-start="opacity-0"
    x-transition:leave-end="opacity-0"
    {{
        $attributes->class([
            'fi-global-search-results-ctn absolute inset-x-4 z-10 mt-3 overflow-hidden !rounded-t-md !rounded-b-xl bg-white shadow-lg border border-black/5 transition dark:bg-gray-900 dark:ring-white/10 sm:inset-x-auto sm:end-0 sm:w-screen sm:max-w-sm md:max-w-full',
            // This zero translation along the z-axis fixes a Safari bug
            // where the results container is incorrectly placed in the stacking context
            // due to the overflow-x value of clip on the topbar element.
            //
            // https://github.com/filamentphp/filament/issues/8215
            '[transform:translateZ(0)]',
        ])
    }}
    style="background-color: white"
>
    @if ($results->getCategories()->isEmpty())
        <x-search-results-page::no-results-message />
    @else
        <ul class="px-2 py-3 max-h-153.5 space-y-4 overflow-auto">
            @foreach ($results->getCategories() as $group => $groupedResults)
                <x-search-results-page::result-group
                    :label="$group"
                    :results="$groupedResults->take(5)"
                />
            @endforeach
        </ul>
        <button x-on:click="handleEnter()" class="w-full h-12.5 bg-white text-xs text-custom-gray-70 font-medium hover:underline border-t border-black/5 shadow-lg">
            {{ __('searchresults.view_more_results') }}
        </button>
    @endif
</div>
