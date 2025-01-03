@props([
    'label',
    'results',
])

<li
    x-data="{ open: true }"
    {{ $attributes->class(['fi-global-search-result-group border border-custom-gray-border rounded-xl overflow-hidden']) }}
>
    @php
        $id = str_replace(' ', '-', strtolower($label));
        $validIds = array_flip(['brands', 'categories', 'customers', 'orders', 'products', 'shipping-options', 'dynamic-forms', 'discounts']);
        $isValidId = isset($validIds[$id]);
    @endphp

    <button @click="open = !open" class="px-6 w-full h-8.5 flex justify-between items-center bg-custom-gray-background border-b border-custom-gray-border transition-all" :class="{ 'border-transparent': !open }">
        <div class="flex items-center gap-2">
            @if ($isValidId)
                <x-filament::icon
                    icon="icon-search.{{ $id }}"
                    class="size-3"
                />
            @endif
            <h3 class="text-sm !text-custom-black font-medium">{{ $label }} ({{ count($results) }})</h3>
        </div>
        <a href="/admin/{{ \Illuminate\Support\Str::slug($label) }}?tableSearch={{ $this->search }}" class="text-xxs text-custom-gray-90 font-medium hover:underline">
            {{ __('::searchresults.view_more_results') }}
        </a>
    </button>

    <ul
        x-show="open"
        x-collapse
        @class([
            '!divide-custom-gray-border',
            'divide-none px-8 py-3 w-full flex flex-wrap gap-2.5' => isset(array_flip(['brands', 'shipping-options', 'dynamic-forms', 'discounts'])[$id]),
        ])
    >
        @php
            $component =  'filament-panels::global-search.result';

            if($isValidId) {
                $component = 'filament-panels::global-search.results.' . $id;
            }
        @endphp

        @foreach ($results as $result)
            @php
                $isArray = is_array($result);
            @endphp
            <x-dynamic-component
                :component="$component"
                :actions="$isArray ? $result['actions'] : $result->actions"
                :details="$isArray ? $result['details'] : $result->details"
                :title="$isArray ?$result['title'] : $result->title"
                :url="$isArray ? $result['url'] : $result->url"
            />
        @endforeach
    </ul>
</li>
