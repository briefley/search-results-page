@props([
    'results' => [],
])

@php
    use Filament\GlobalSearch\GlobalSearchResult;

    $totalResults = collect($results)->flatten(1)->count();
@endphp

<x-filament::page>
    <header class="fi-header">
        <x-filament::breadcrumbs class="!mb-2" :breadcrumbs="[
                url()->previous() => __('search-results-page::searchresults.back'),
                __('search-results-page::searchresults.search_results'),
            ]" />
        <div class="flex justify-between items-end">
            <h1 class="fi-header-heading">
                {{ __('search-results-page::searchresults.search_results') }}
            </h1>
            <p class="text-xs tex-custom-black">
                {{__('search-results-page::searchresults.total_results', ['count' => $totalResults, 'keyword' => '"'.$search.'"'])}}
            </p>
        </div>
    </header>
    <main>
        @if ($results->isEmpty())
            <p class="text-center">{{ __('search-results-page::searchresults.no_results_found', ['keyword' => '"' . $search .'"'])  }}</p>
        @else
            <ul class="space-y-4">
                @foreach ($results as $label => $data)
                    @php
                        $hasPagination = true;
                        $categoryTotalRecords = $data->first()['details']['totalRecords'];
                    @endphp

                    <div wire:key="{{ $label }}">
                        <x-search-results-page::result-group
                            :label="ucwords(str_replace('_', ' ', $label))"
                            :results="$data"
                            @class([
                                'border-b-0 rounded-b-none' => $hasPagination,
                            ])
                        />
                        @if($hasPagination)
                            <div class="px-5 h-11 flex justify-between items-center text-xs text-custom-gray-70 font-medium bg-table-layout-gray border border-custom-gray-border rounded-b-xl">
                                <p>
                                    {{ ($page[$label] - 1) * $perPage + 1 }}-
                                    {{ min($page[$label] * $perPage, $categoryTotalRecords) }}
                                    {{ __('search-results-page::searchresults.of.label') }}
                                    {{ $categoryTotalRecords }}
                                </p>
                                <div class="flex items-center gap-2.5">
                                    <x-filament::icon-button
                                        icon="chevron-left"
                                        class="pagination-button "
                                        wire:click="previousPage('{{$label}}')"
                                        :disabled="$page[$label] == 1"
                                    />
                                    <p>
                                        <span class="text-custom-black">{{ $page[$label]  }}</span>/{{ ceil($categoryTotalRecords / $perPage) }}
                                    </p>
                                    <x-filament::icon-button
                                        icon="chevron-right"
                                        class="pagination-button"
                                        wire:click="nextPage('{{$label}}')"
                                        :disabled="$page[$label] == ceil($categoryTotalRecords / $perPage)"
                                    />
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </ul>
        @endif
    </main>
</x-filament::page>
