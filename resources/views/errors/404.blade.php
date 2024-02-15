@extends('_minimal')

@section('title', __('common.page_not_found'))

@section('content')
<main class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
    <div class="text-center">
        <p class="text-base font-semibold text-indigo-600">404</p>
        <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">{{ __('common.page_not_found') }}</h1>
        <div class="mt-10 flex items-center justify-center gap-x-6">
            <a href="{{ route('web.index') }}" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{ __('common.go_to_home') }}</a>
        </div>
    </div>
</main>
@endsection
