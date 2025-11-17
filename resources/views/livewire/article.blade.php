<div>
    <main class="pt-8 pb-16 lg:pt-16 lg:pb-24 bg-white dark:bg-gray-900 antialiased">
        <div class="flex justify-between px-4 mx-auto max-w-screen-xl ">
            <article class="mx-auto w-full max-w-2xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">

                <div class="mb-8">
                    <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                        <a href="{{ url('/') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 focus:z-10 focus:ring-2 focus:ring-blue-500 focus:text-blue-600 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 transition duration-200 ease-in-out group">
                            <svg class="w-4 h-4 mr-2 transition-transform duration-200 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Back to Home
                        </a>

                        <span class="mx-2">/</span>
                        <span class="text-gray-400 dark:text-gray-500">Article</span>
                        <span class="mx-2">/</span>
                        <span class="text-gray-600 dark:text-gray-300 font-medium truncate max-w-xs">{{ Str::limit($article->title, 30) }}</span>
                    </nav>
                </div>

                <header class="mb-4 lg:mb-6 not-format">
                    <address class="flex items-center mb-6 not-italic">
                        <div class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
                            <img class="mr-4 w-16 h-16 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-2.jpg" alt="Jese Leos">
                            <div>
                                <a href="#" rel="author" class="text-xl font-bold text-gray-900 dark:text-white">{{ $article->author->name }}</a>
                                <p class="text-base text-gray-500 dark:text-gray-400">{{ implode(', ', $article->tags->pluck('tag.name')->toArray()) }}</p>
                                <p class="text-base text-gray-500 dark:text-gray-400"><time pubdate datetime="2022-02-08" title="February 8th, 2022">{{ date('F d, Y', strtotime($article->published_at)) }}</time></p>
                            </div>
                        </div>
                    </address>
                    <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">{{ $article->title }}</h1>
                </header>

                {!! $article->content !!}

                <section class="not-format">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">Discussion ({{ $article->comments->count() }})</h2>
                    </div>

                    <form wire:submit.prevent="submitComment" class="mb-8 bg-gray-50 dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Leave a Comment</h3>

                        @if (session()->has('success'))
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <p class="text-green-700 font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                        @endif

                        @if (session()->has('error'))
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <p class="text-red-700 font-medium">{{ session('error') }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="commentName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Name <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="commentName"
                                    wire:model="commentName"
                                    placeholder="Your full name"
                                    class="w-full px-4 py-3 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 transition duration-200"
                                    required />
                                @error('commentName')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="commentEmail" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="email"
                                    id="commentEmail"
                                    wire:model="commentEmail"
                                    placeholder="your@email.com"
                                    class="w-full px-4 py-3 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 transition duration-200"
                                    required />
                                @error('commentEmail')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="commentMessage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Comment <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <textarea
                                    id="commentMessage"
                                    rows="5"
                                    wire:model="commentMessage"
                                    class="w-full px-4 py-3 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 transition duration-200 resize-none"
                                    placeholder="Share your thoughts about this article..."
                                    required></textarea>
                                <div class="absolute bottom-3 right-3 text-xs text-gray-400" x-data="{ count: 0 }" x-text="count + '/500'">
                                    <span wire:ignore x-init="$watch('$wire.commentMessage', value => count = (value || '').length)">0/500</span>
                                </div>
                            </div>
                            @error('commentMessage')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4 flex items-start">
                            <input
                                type="checkbox"
                                id="privacyConsent"
                                wire:model="privacyConsent"
                                class="mt-1 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600"
                                required />
                            <label for="privacyConsent" class="ml-3 text-sm text-gray-600 dark:text-gray-300">
                                I agree that my submitted data is being collected and stored.
                                <a href="#" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 underline">Privacy Policy</a>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <button
                                type="submit"
                                wire:loading.attr="disabled"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium text-sm rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition duration-200 ease-in-out">
                                <svg wire:loading class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span wire:loading.remove>Post Comment</span>
                                <span wire:loading>Posting...</span>
                            </button>

                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                Comments are moderated and will appear after review.
                            </div>
                        </div>
                    </form>

                    <div wire:poll.5s="refreshComments">
                        @if($article->comments->count() > 0)
                        <div class="space-y-6">
                            @foreach ($article->comments->sortByDesc('created_at') as $comment)
                            <article class="p-6 bg-white rounded-xl border border-gray-200 dark:bg-gray-900 dark:border-gray-700 transition duration-200 hover:shadow-md">
                                <footer class="flex justify-between items-start mb-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                                {{ strtoupper(substr($comment->name, 0, 1)) }}
                                            </div>
                                        </div>

                                        <div>
                                            <div class="flex items-center space-x-2">
                                                <span class="font-semibold text-gray-900 dark:text-white">{{ $comment->name }}</span>

                                                @if($comment->created_at->diffInMinutes(now()) < 5)
                                                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">New</span>
                                                    @endif
                                            </div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                <time datetime="{{ $comment->created_at->format('c') }}" title="{{ $comment->created_at->format('F j, Y \a\t g:i A') }}">
                                                    {{ $comment->created_at->diffForHumans() }}
                                                </time>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition duration-200">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition duration-200">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </footer>

                                <div class="text-gray-900 dark:text-white leading-relaxed">
                                    {{ $comment->message }}
                                </div>
                            </article>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No comments yet</h3>
                            <p class="text-gray-600 dark:text-gray-400">Be the first to share your thoughts about this article!</p>
                        </div>
                        @endif
                    </div>

                </section>

                <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
                        <a href="{{ url('/') }}"
                            class="inline-flex items-center px-6 py-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 focus:z-10 focus:ring-2 focus:ring-blue-500 focus:text-blue-600 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 transition duration-200 ease-in-out group">
                            <svg class="w-5 h-5 mr-2 transition-transform duration-200 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Back to Home
                        </a>

                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Share:</span>
                            <div class="flex space-x-2">
                                <button class="inline-flex items-center justify-center w-8 h-8 text-gray-500 bg-gray-100 rounded-full hover:bg-gray-200 hover:text-gray-700 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-gray-300 transition duration-200">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                    </svg>
                                </button>
                                <button class="inline-flex items-center justify-center w-8 h-8 text-gray-500 bg-gray-100 rounded-full hover:bg-gray-200 hover:text-gray-700 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-gray-300 transition duration-200">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                </button>
                                <button class="inline-flex items-center justify-center w-8 h-8 text-gray-500 bg-gray-100 rounded-full hover:bg-gray-200 hover:text-gray-700 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-gray-300 transition duration-200">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-800">
                        <div class="flex justify-between items-center">
                            @if(false) {{-- Replace with actual previous article logic --}}
                            <a href="#" class="group flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                                <div class="text-left">
                                    <div class="text-xs text-gray-400">Previous</div>
                                    <div class="font-medium">Previous Article Title</div>
                                </div>
                            </a>
                            @else
                            <div></div>
                            @endif

                            @if(false) {{-- Replace with actual next article logic --}}
                            <a href="#" class="group flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                <div class="text-right">
                                    <div class="text-xs text-gray-400">Next</div>
                                    <div class="font-medium">Next Article Title</div>
                                </div>
                                <svg class="w-4 h-4 ml-2 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                            @else
                            <div></div>
                            @endif
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const commentTextarea = document.getElementById('commentMessage');
            if (commentTextarea) {
                commentTextarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = this.scrollHeight + 'px';
                });
            }

            if (commentTextarea) {
                commentTextarea.addEventListener('input', function() {
                    const maxLength = 500;
                    const currentLength = this.value.length;
                    const counter = this.parentElement.querySelector('.absolute .text-xs');
                    if (counter) {
                        counter.textContent = `${currentLength}/${maxLength}`;

                        if (currentLength > maxLength * 0.9) {
                            counter.classList.add('text-red-500');
                            counter.classList.remove('text-gray-400');
                        } else {
                            counter.classList.remove('text-red-500');
                            counter.classList.add('text-gray-400');
                        }
                    }
                });
            }

            const form = document.querySelector('form[wire\\:submit\\.prevent="submitComment"]');
            if (form) {
                const inputs = form.querySelectorAll('input[required], textarea[required]');

                inputs.forEach(input => {
                    input.addEventListener('blur', function() {
                        if (this.value.trim() === '') {
                            this.classList.add('border-red-300', 'ring-red-500');
                            this.classList.remove('border-gray-300');
                        } else {
                            this.classList.remove('border-red-300', 'ring-red-500');
                            this.classList.add('border-gray-300');
                        }
                    });

                    input.addEventListener('input', function() {
                        if (this.value.trim() !== '') {
                            this.classList.remove('border-red-300', 'ring-red-500');
                            this.classList.add('border-gray-300');
                        }
                    });
                });
            }

            window.addEventListener('commentPosted', () => {
                setTimeout(() => {
                    const commentsSection = document.querySelector('.space-y-6');
                    if (commentsSection) {
                        commentsSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }, 500);
            });

            setInterval(() => {
                if (typeof Livewire !== 'undefined') {
                    Livewire.first().call('refreshComments');
                }
            }, 30000);

            document.addEventListener('click', function(e) {
                if (e.target.closest('button svg')?.closest('button')) {
                    const button = e.target.closest('button');
                    const svg = button.querySelector('svg');

                    if (svg && svg.getAttribute('fill') === 'currentColor') {
                        if (button.classList.contains('text-red-500')) {
                            button.classList.remove('text-red-500');
                            button.classList.add('text-gray-400');
                        } else {
                            button.classList.add('text-red-500');
                            button.classList.remove('text-gray-400');
                        }

                        svg.classList.add('animate-pulse');
                        setTimeout(() => {
                            svg.classList.remove('animate-pulse');
                        }, 300);
                    }
                }
            });

            const privacyLink = document.querySelector('a[href="#"]');
            if (privacyLink && privacyLink.textContent.includes('Privacy Policy')) {
                privacyLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    alert('Privacy Policy: Your data is collected solely for the purpose of displaying your comment. We do not share your information with third parties.');
                });
            }

            const submitButton = form?.querySelector('button[type="submit"]');
            if (submitButton) {
                form.addEventListener('submit', function() {
                    submitButton.classList.add('bg-blue-700');

                    setTimeout(() => {
                        submitButton.classList.remove('bg-blue-700');
                    }, 2000);
                });
            }
        });

        document.addEventListener('livewire:initialized', () => {
            Livewire.on('commentPosted', () => {
                const form = document.querySelector('form[wire\\:submit\\.prevent="submitComment"]');
                if (form) {
                    form.classList.add('ring-2', 'ring-green-500');
                    setTimeout(() => {
                        form.classList.remove('ring-2', 'ring-green-500');
                    }, 2000);
                }
            });
        });
    </script>
</div>