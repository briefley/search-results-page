<x-filament::page>
    <div class="space-y-6">
        <div class="flex justify-end items-center">
            <p class="text-sm text-gray-500">
                {{__('lunarpanel::searchresults.total_results')}}
                <span class="font-semibold">
                    {{ collect($results)->flatten(1)->count() }}
                </span>
            </p>
        </div>

        @if (empty($results))
            <p>No results found for your search.</p>
        @else
            @foreach ($results as $category => $items)
                <div x-data="{ open: true }" class="border-b pb-4 mb-6">
                    <button
                        @click="open = !open"
                        class="w-full text-left flex justify-between items-center p-4 rounded-md focus:outline-none"
                    >
                        <h2 class="text-xl font-semibold">{{ $category }}</h2>
                        <svg
                            :class="open ? 'rotate-180' : 'rotate-0'"
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 transform transition-transform duration-200 ease-in-out"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <ul
                        x-show="open"
                        x-collapse
                        class="mt-4 space-y-3"
                    >
                        @forelse ($items as $item)
                            <li>
                                <a
                                    href="{{ $item['url'] ?? '#' }}"
                                    class="block p-4 shadow-sm rounded-md focus:ring"
                                >
                                    <h3 class="text-lg font-medium">{{ $item['title'] ?? 'Untitled' }}</h3>

                                    @if (!empty($item['details']))
                                        <p class="text-sm">
                                            {{ implode(', ', $item['details']) }}
                                        </p>
                                    @endif
                                </a>
                            </li>
                        @empty
                            <p class="text-gray-500">No items found in {{ $category }}.</p>
                        @endforelse
                    </ul>
                </div>
            @endforeach
        @endif
    </div>
</x-filament::page>
