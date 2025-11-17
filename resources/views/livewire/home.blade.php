<div class="bg-white py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:mx-0">
            <h2 class="text-4xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-5xl">From the blog</h2>
            <p class="mt-2 text-lg/8 text-gray-600">Learn how to grow your business with our expert advice.</p>
        </div>

        <div class="mx-auto mt-10 max-w-2xl lg:mx-0">
            <div class="relative">
                <div class="w-full">
                    <div class="relative flex items-center">
                        <div class="absolute left-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.35-4.35" />
                            </svg>
                        </div>

                        <input
                            type="text"
                            wire:model.live.debounce.300ms="searchQuery"
                            placeholder="Search articles, topics, or authors..."
                            class="w-full pl-12 pr-32 py-4 text-gray-900 bg-white border border-gray-300 rounded-xl shadow-sm placeholder:text-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out hover:border-gray-400" />

                        @if($searchQuery)
                        <button
                            type="button"
                            wire:click="clearSearch"
                            class="absolute right-16 text-gray-400 hover:text-gray-600 transition duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        @endif

                        <button
                            type="button"
                            wire:click="search"
                            class="absolute right-2 px-6 py-2.5 bg-blue-600 text-white font-medium text-sm rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 ease-in-out transform hover:scale-105">
                            <span wire:loading.remove wire:target="search">Search</span>
                            <span wire:loading wire:target="search">Searching...</span>
                        </button>
                    </div>
                </div>
            </div>

            @if($searchQuery || $selectedCategory)
            <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        @if($searchQuery)
                        <span class="text-sm text-blue-800">
                            <strong>Search:</strong> "{{ $searchQuery }}"
                        </span>
                        @endif

                        @if($selectedCategory)
                        <span class="text-sm text-blue-800">
                            <strong>Category:</strong> {{ $selectedCategory }}
                        </span>
                        @endif

                        <span class="text-sm text-blue-600">
                            ({{ $posts->total() }} {{ Str::plural('result', $posts->total()) }})
                        </span>
                    </div>

                    <button
                        wire:click="clearSearch"
                        class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        Clear All
                    </button>
                </div>
            </div>
            @endif

            <div class="mt-4 flex flex-wrap gap-2">
                <span class="text-sm text-gray-500">Quick filters:</span>

                @foreach($popularCategories as $category)
                <button
                    wire:click="selectCategory('{{ $category }}')"
                    class="px-3 py-1 text-xs font-medium rounded-full transition duration-200 {{ $selectedCategory === $category ? 'bg-blue-600 text-white' : 'text-blue-600 bg-blue-50 hover:bg-blue-100' }}">
                    {{ $category }}
                </button>
                @endforeach

                @if($selectedCategory)
                <button
                    wire:click="$set('selectedCategory', '')"
                    class="px-3 py-1 text-xs font-medium text-red-600 bg-red-50 rounded-full hover:bg-red-100 transition duration-200">
                    Clear Filter
                </button>
                @endif
            </div>
        </div>

        <div class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 border-t border-gray-200 pt-10 sm:mt-16 sm:pt-16 lg:mx-0 lg:max-w-none lg:grid-cols-3">
            <div wire:loading wire:target="searchQuery, selectedCategory" class="col-span-full flex justify-center items-center py-12">
                <div class="text-center">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
                    <p class="text-gray-600">Searching articles...</p>
                </div>
            </div>

            <div wire:loading.remove wire:target="searchQuery, selectedCategory" class="col-span-full">
                @if($posts->count() > 0)
                <div class="grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                    @foreach($posts as $post)
                    <article class="flex max-w-xl flex-col items-start justify-between transform transition duration-200 hover:scale-105">
                        <div class="flex items-center gap-x-4 text-xs">
                            <time datetime="{{ $post->published_at }}" class="text-gray-500">
                                {{ date('F j, Y', strtotime($post->published_at)) }}
                            </time>
                            <button
                                wire:click="selectCategory('{{ $post->category->name }}')"
                                class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100 transition duration-200">
                                {{ $post->category->name }}
                            </button>
                        </div>
                        <div class="group relative grow">
                            <h3 class="mt-3 text-lg/6 font-semibold text-gray-900 group-hover:text-gray-600">
                                <a href="{{ route('article', $post->slug) }}">
                                    <span class="absolute inset-0"></span>
                                    @if($searchQuery)
                                    {!! str_ireplace($searchQuery, '<mark class="bg-yellow-200 px-1 rounded">' . $searchQuery . '</mark>', $post->title) !!}
                                    @else
                                    {{ $post->title }}
                                    @endif
                                </a>
                            </h3>
                            <p class="mt-5 line-clamp-3 text-sm/6 text-gray-600">
                                @if($searchQuery)
                                {!! str_ireplace($searchQuery, '<mark class="bg-yellow-200 px-1 rounded">' . $searchQuery . '</mark>', Str::limit(strip_tags($post->content), 100)) !!}
                                @else
                                {{ Str::limit(strip_tags($post->content), 100) }}
                                @endif
                            </p>

                            @if($post->tags->count() > 0)
                            <div class="mt-3 flex flex-wrap gap-1">
                                @foreach($post->tags->take(3) as $tag)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $tag->name }}
                                </span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        <div class="relative mt-8 flex items-center gap-x-4 justify-self-end">
                            <img src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-10 rounded-full bg-gray-50" />
                            <div class="text-sm/6">
                                <p class="font-semibold text-gray-900">
                                    <a href="#">
                                        <span class="absolute inset-0"></span>
                                        {{ $post->author->name }}
                                    </a>
                                </p>
                                <p class="text-gray-600">Writer</p>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 20.5a7.962 7.962 0 01-5.207-1.909l-3.678 3.678a.75.75 0 01-1.06-1.06l3.678-3.678A7.962 7.962 0 014.5 12a8 8 0 0116 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No articles found</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @if($searchQuery || $selectedCategory)
                        Try adjusting your search criteria or
                        <button wire:click="clearSearch" class="text-blue-600 hover:text-blue-500">clear all filters</button>.
                        @else
                        No articles have been published yet.
                        @endif
                    </p>

                    @if($searchQuery)
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Search suggestions:</h4>
                        <div class="flex justify-center space-x-2">
                            <button wire:click="$set('searchQuery', 'technology')" class="px-3 py-1 text-xs text-blue-600 bg-blue-50 rounded-full hover:bg-blue-100">Technology</button>
                            <button wire:click="$set('searchQuery', 'business')" class="px-3 py-1 text-xs text-blue-600 bg-blue-50 rounded-full hover:bg-blue-100">Business</button>
                            <button wire:click="$set('searchQuery', 'design')" class="px-3 py-1 text-xs text-blue-600 bg-blue-50 rounded-full hover:bg-blue-100">Design</button>
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>

        @if($posts->hasPages())
        <div class="mx-auto mt-16 max-w-2xl lg:mx-0 lg:max-w-none">
            <div class="border-t border-gray-200 pt-10">
                {{ $posts->links() }}
            </div>
        </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    const searchInput = document.querySelector('input[wire\\:model\\.live\\.debounce\\.300ms="searchQuery"]');
                    if (searchInput) {
                        searchInput.focus();
                        searchInput.select();
                    }
                }

                if (e.key === 'Escape') {
                    const searchInput = document.querySelector('input[wire\\:model\\.live\\.debounce\\.300ms="searchQuery"]');
                    if (document.activeElement === searchInput) {
                        Livewire.first().call('clearSearch');
                        searchInput.blur();
                    }
                }
            });

            const searchInput = document.querySelector('input[wire\\:model\\.live\\.debounce\\.300ms="searchQuery"]');
            if (searchInput && !searchInput.parentElement.querySelector('.shortcut-hint')) {
                const shortcutHint = document.createElement('div');
                shortcutHint.className = 'shortcut-hint absolute right-20 top-1/2 transform -translate-y-1/2 text-xs text-gray-400 hidden sm:block pointer-events-none';
                shortcutHint.innerHTML = 'Ctrl+K';
                searchInput.parentElement.appendChild(shortcutHint);
            }

            window.addEventListener('livewire:navigated', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });

        document.addEventListener('livewire:initialized', () => {
            Livewire.on('searchUpdated', () => {
                setTimeout(() => {
                    const resultsSection = document.querySelector('.grid.max-w-2xl');
                    if (resultsSection) {
                        resultsSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }, 100);
            });
        });
    </script>
</div>