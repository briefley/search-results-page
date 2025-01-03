@php
    $debounce = filament()->getGlobalSearchDebounce();
    $keyBindings = filament()->getGlobalSearchKeyBindings();
@endphp

<div
    x-id="['input']"
    x-data="{
        search: new URLSearchParams(window.location.search).get('search') || ''
    }"
    {{ $attributes->class(['fi-global-search-field']) }}
>
    <label x-bind:for="$id('input')" class="sr-only">
        {{ __('filament-panels::global-search.field.label') }}
    </label>


        <div class="h-5 flex items-center gap-2">
            <div class="flex items-center">
                <div x-show="search === ''">
                    <x-icon-top-bar.search wire:loading.remove class="size-4" />
                </div>
                <x-filament::loading-indicator class="size-4 text-custom-gray-70" wire:loading/>
            </div>

            <x-filament::input
                autocomplete="off"
                inline-prefix
                placeholder="Search..."
                type="search"
                wire:key="global-search.field.input"
                x-bind:id="$id('input')"
                x-on:keydown.down.prevent.stop="$dispatch('focus-first-global-search-result')"
                x-data="{}"
                x-model="search"
                :attributes="
                    \Filament\Support\prepare_inherited_attributes(
                        new \Illuminate\View\ComponentAttributeBag([
                            'wire:model.live.debounce.' . $debounce => 'search',
                            'x-mousetrap.global.' . collect($keyBindings)->map(fn (string $keyBinding): string => str_replace('+', '-', $keyBinding))->implode('.') => $keyBindings ? 'document.getElementById($id(\'input\')).focus()' : null,
                        ])
                    )
                "
                class="pb-0.5 h-full text-sm text-custom-black placeholder:text-custom-gray-30 placeholder:pl-1"
            />

            <div x-show="search" x-transition class="flex gap-6" >
                <button x-on:click="search = ''">
                    <x-filament::icon
                        icon="icon-x-custom"
                        class="size-4 text-custom-gray-70"
                    />
                </button>

                <button x-on:click="handleEnter()" class="px-2 h-6 flex items-center gap-2 text-custom-black hover:text-white bg-white hover:bg-custom-green border border-custom-gray-10 hover:border-custom-green-90 hover:ring-1 ring-custom-green-90 rounded-md shadow-sm transition">
                    <x-filament::icon
                        icon="icon-enter"
                        class="size-3.5"
                    />
                    <p class="text-sm font-medium">{{ __('searchresults.enter.label') }}</p>
                </button>
            </div>
        </div>

</div>
