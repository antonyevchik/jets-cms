<div class="divide-y divide-gray-800" x-data="{ show: false }">
    <nav class="flex items-center bg-gray-900 px-3 py-2 shadow-lg">
        <div>
            <button @click="show = !show" class="block h-8 mr-3 text-gray-400 items-center hover:text-gray-200 focus:text-gray-200 focus:outline-none sm:hidden">
                <svg x-show="!show" width="2em" height="2em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                    <rect width="18" height="2" x="3" y="11" fill="currentColor" rx=".95" ry=".95"/>
                    <rect width="18" height="2" x="3" y="16" fill="currentColor" rx=".95" ry=".95"/>
                    <rect width="18" height="2" x="3" y="6" fill="currentColor" rx=".95" ry=".95"/>
                </svg>
                <svg x-show="show" width="1.5em" height="1.5em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M20 20L4 4m16 0L4 20"/>
                </svg>
            </button>
        </div>
        <div class="flex items-center h-12 w-full">
            <a href="{{ url('/') }}" class="w-full">
                <img class="h-8" src="{{ url('/img/laravel-logo.png') }}"/>
            </a>
        </div>
        <div class="flex justify-end sm:w-8/12">
            {{-- Top Navigation --}}
            <ul class="hidden sm:flex sm:text-left text-gray-200 text-xs">
                @foreach($topNavLinks as $item)
                    <a href="{{ url('/'.$item->slug) }}">
                        <li class="cursor-pointer px-4 py-2 hover:bg-gray-800">{{ $item->label }}</li>
                    </a>
                @endforeach
            </ul>
        </div>
    </nav>
    <div class="sm:flex sm:min-h-screen">
        <aside class="bg-gray-900 text-gray-700 divide-y divide-gray-700 divide-dashed sm:w-4/12 md:w-4/12 lg:w-2/12">
            {{-- Desktop Web View --}}
            <ul class="hidden text-gray-200 text-xs sm:block sm:text-left">
                @foreach($sideBarLinks as $item)
                    <a href="{{ url('/'.$item->slug) }}">
                        <li class="cursor-pointer px-4 py-2 hover:bg-gray-800">{{ $item->label }}</li>
                    </a>
                @endforeach
            </ul>
            {{-- Mobile Web View --}}
            <div :class="show ? 'block' : 'hidden'" class="pb-3 divide-y divide-gray-800 block sm:hidden">
                <ul class="text-gray-200 text-xs">
                    @foreach($sideBarLinks as $item)
                        <a href="{{ url('/'.$item->slug) }}">
                            <li class="cursor-pointer px-4 py-2 hover:bg-gray-800">{{ $item->label }}</li>
                        </a>
                    @endforeach
                </ul>
                {{-- Top Navigation Mobile Web View --}}
                <ul class="text-gray-200 text-xs">
                    @foreach($topNavLinks as $item)
                        <a href="{{ url('/'.$item->slug) }}">
                            <li class="cursor-pointer px-4 py-2 hover:bg-gray-800">{{ $item->label }}</li>
                        </a>
                    @endforeach
                </ul>
            </div>
        </aside>
        <main class="bg-gray-100 p-12 min-h-screen sm:w-8/12 md:w-9/12 lg:w-10/12">
            <section class="divide-y text-gray-900">
                <h1 class="text-3xl font-bold">{{ $title }}</h1>
                <article>
                    <div class="mt-5 text-sm">
                        {!! $content !!}
                    </div>
                </article>
            </section>
        </main>
    </div>
</div>
