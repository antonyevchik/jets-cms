<div class="divide-y divide-gray-800">
    <nav class="flex items-center bg-gray-900 px-3 py-2 shadow-lg">
        <div>
            <button class="block h-8 mr-3 text-gray-400 items-center hover:text-gray-200 focus:text-gray-200 focus:outline-none sm:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><rect width="18" height="2" x="3" y="11" fill="currentColor" rx=".95" ry=".95"/><rect width="18" height="2" x="3" y="16" fill="currentColor" rx=".95" ry=".95"/><rect width="18" height="2" x="3" y="6" fill="currentColor" rx=".95" ry=".95"/></svg>
            </button>
        </div>
        <div class="flex items-center h-12 w-full">
            <a href="{{ url('/') }}" class="w-full">
                <img class="h-8" src="{{ url('/img/laravel-logo.png') }}"/>
            </a>
        </div>
        <div class="flex justify-end sm:w-8/12">
            {{-- Top Navigation --}}
            <ul class="hidden sm:block sm:text-left text-gray-200 text-xs">
                <a href="{{ url('/login') }}">
                    <li class="cursor-pointer px-4 py-2 hover:underline">Login</li>
                </a>
            </ul>
        </div>
    </nav>
    <div class="sm:flex sm:min-h-screen">
        <aside class="bg-gray-900 text-gray-700 divide-y divide-gray-700 divide-dashed sm:w-4/12 md:w-4/12 lg:w-2/12">
            {{-- Desktop Web View --}}
            <ul class="hidden text-gray-200 text-xs sm:block sm:text-left">
                <a href="{{ url('/home') }}">
                    <li class="cursor-pointer px-4 py-2 hover:bg-gray-800">Home</li>
                </a>
                <a href="{{ url('/about') }}">
                    <li class="cursor-pointer px-4 py-2 hover:bg-gray-800">About</li>
                </a>
                <a href="{{ url('/contact') }}">
                    <li class="cursor-pointer px-4 py-2 hover:bg-gray-800">Contact</li>
                </a>
            </ul>
            {{-- Mobile Web View --}}
            <div class="pb-3 divide-y divide-gray-800 block sm:hidden">
                <ul class="text-gray-200 text-xs">
                    <a href="{{ url('/home') }}">
                        <li class="cursor-pointer px-4 py-2 hover:bg-gray-800">Home</li>
                    </a>
                    <a href="{{ url('/about') }}">
                        <li class="cursor-pointer px-4 py-2 hover:bg-gray-800">About</li>
                    </a>
                    <a href="{{ url('/contact') }}">
                        <li class="cursor-pointer px-4 py-2 hover:bg-gray-800">Contact</li>
                    </a>
                </ul>
                {{-- Top Navigation Mobile Web View --}}
                <ul class="text-gray-200 text-xs">
                    <a href="{{ url('/login') }}">
                        <li class="cursor-pointer px-4 py-2 hover:bg-gray-800">Login</li>
                    </a>
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


{{--    <div class="border p-5 text-gray-100 bg-gray-500 text-3xl sm:bg-blue-500 md:bg-red-500 lg:bg-yellow-400 xl:bg-green-500">{{ $title }}</div>--}}
{{--    <div class="lg:flex">--}}
{{--        <div class="border p-5 text-center sm:text-left lg:w-1/2">--}}
{{--            {!! $content !!}--}}
{{--        </div>--}}
{{--        <div class="border bg-gray-400 lg:w-1/2">--}}
{{--            <img class="w-full h-full object-cover object-center" src="{{ 'img/laravel.svg' }}" alt=""/>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>
