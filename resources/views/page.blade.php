<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $page->title ?? config('app.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gray-100">
        <nav class="bg-white border-b border-gray-100 p-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div class="flex items-center">
                    @if($globalSettings['logo'])
                        <img src="{{ asset('storage/' . $globalSettings['logo']) }}" alt="Logo" class="h-10 w-auto mr-4">
                    @else
                        <span class="font-bold text-xl">{{ config('app.name') }}</span>
                    @endif

                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        @foreach($globalMenu as $item)
                            <a href="{{ $item->url }}" class="text-gray-900 hover:text-gray-700">{{ $item->label }}</a>
                        @endforeach
                    </div>
                </div>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-3xl font-bold mb-4">{{ $page->title }}</h1>
                <div class="prose max-w-none">
                    {!! nl2br(e($page->content)) !!}
                </div>
            </div>
        </main>
    </body>
</html>
