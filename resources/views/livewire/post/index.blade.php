<div>
    <script src="https://unpkg.com/smoothscroll-polyfill@0.4.4/dist/smoothscroll.js"></script>
    @foreach($posts as $post)
    <div class="pt-4 sm:pt-6 w-full" wire:key="{{$post->id}}">
        <div
            x-data="{
                skip: 3,
                atBeginning: false,
                atEnd: false,
                next() {
                    this.to((current, offset) => current + (offset * this.skip))
                },
                prev() {
                    this.to((current, offset) => current - (offset * this.skip))
                },
                to(strategy) {
                    let slider = this.$refs.slider
                    let current = slider.scrollLeft
                    let offset = slider.firstElementChild.getBoundingClientRect().width
                    slider.scrollTo({ left: strategy(current, offset), behavior: 'smooth' })
                },
                focusableWhenVisible: {
                    'x-intersect:enter'() {
                        this.$el.removeAttribute('tabindex')
                    },
                    'x-intersect:leave'() {
                        this.$el.setAttribute('tabindex', '-1')
                    },
                },
                disableNextAndPreviousButtons: {
                    'x-intersect:enter.threshold.05'() {
                        let slideEls = this.$el.parentElement.children
                        if (slideEls[0] === this.$el) {
                            this.atBeginning = true
                        } else if (slideEls[slideEls.length-1] === this.$el) {
                            this.atEnd = true
                        }
                    },
                    'x-intersect:leave.threshold.05'() {
                        let slideEls = this.$el.parentElement.children
                        if (slideEls[0] === this.$el) {
                            this.atBeginning = false
                        } else if (slideEls[slideEls.length-1] === this.$el) {
                            this.atEnd = false
                        }
                    },
                },
            }"
            class="flex w-full flex-col"
        >
            <div
                x-on:keydown.right="next"
                x-on:keydown.left="prev"
                tabindex="0"
                role="region"
                aria-labelledby="carousel-label"
                class="relative"
            >
                <h2 id="carousel-label" class="sr-only" hidden>Carousel</h2>

                <ul
                    x-ref="slider"
                    tabindex="0"
                    role="listbox"
                    aria-labelledby="carousel-content-label"
                    class="flex w-full snap-x snap-mandatory overflow-x-hidden h-[300px] sm:h-[400px] md:h-[500px] lg:h-[600px]"
                >
                    @foreach($post->images as $index => $image)
                    <li x-bind="disableNextAndPreviousButtons" class="flex w-full h-[300px] sm:h-[400px] md:h-[500px] lg:h-[600px] shrink-0 snap-start" role="option">
                        <div class="w-full h-full bg-gray-200">
                            <img class="w-full h-full object-cover rounded-md" loading="lazy" src="{{ asset($image) }}" alt="Post image {{ $index + 1 }}">
                        </div>
                    </li>
                    @endforeach
                </ul>

                @if(count($post->images) > 1)
                <!-- Navigation buttons overlaid on image -->
                <div class="absolute inset-0 flex items-center justify-between px-2 sm:px-4">
                    <!-- Prev Button -->
                    <button
                        x-on:click="prev"
                        class="rounded-full bg-white/80 p-1 sm:p-2 hover:bg-white"
                        :aria-disabled="atBeginning"
                        :tabindex="atEnd ? -1 : 0"
                        :class="{ 'opacity-50 cursor-not-allowed': atBeginning }"
                    >
                        <span aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 sm:size-6 text-gray-800">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                            </svg>
                        </span>
                        <span class="sr-only">Skip to previous slide page</span>
                    </button>

                    <!-- Next Button -->
                    <button
                        x-on:click="next"
                        class="rounded-full bg-white/80 p-1 sm:p-2 hover:bg-white"
                        :aria-disabled="atEnd"
                        :tabindex="atEnd ? -1 : 0"
                        :class="{ 'opacity-50 cursor-not-allowed': atEnd }"
                    >
                        <span aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 sm:size-6 text-gray-800">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </span>
                        <span class="sr-only">Skip to next slide page</span>
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach

    <div class="mt-5">
        {{ $posts->links() }}
    </div>
</div>

@script
<script>
    // Initialize on first load
    HSCarousel.autoInit();

    // Handle Livewire navigation and updates
    $wire.on('navigated', () => {
        setTimeout(() => {
            HSCarousel.autoInit();
        }, 100);
    });

    $wire.on('render', () => {
        setTimeout(() => {
            HSCarousel.autoInit();
        }, 100);
    });
</script>
@endscript
