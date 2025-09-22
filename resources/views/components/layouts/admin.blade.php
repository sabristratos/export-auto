<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Admin - ' . setting('site_name', 'Elite Car Export') }}</title>

    <!-- Meta Description -->
    <meta name="description" content="Admin panel for {{ setting('site_name', 'Elite Car Export') }}">

    <!-- Favicon -->
    @php
        $faviconUrl = setting_file('site_favicon');
        $defaultFavicon = asset('favicon.ico');
    @endphp

    @if($faviconUrl)
        <link rel="icon" type="image/x-icon" href="{{ $faviconUrl }}">
        <link rel="shortcut icon" href="{{ $faviconUrl }}">
        <link rel="apple-touch-icon" href="{{ $faviconUrl }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ $defaultFavicon }}">
        <link rel="shortcut icon" href="{{ $defaultFavicon }}">
    @endif

    <!-- Apple Touch Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $faviconUrl ?: $defaultFavicon }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $faviconUrl ?: $defaultFavicon }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $faviconUrl ?: $defaultFavicon }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-neutral-50 font-helvetica antialiased"
      data-locale="{{ app()->getLocale() }}"
      data-direction="{{ in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr' }}">

        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>

@livewireScripts
<x-keys::scripts />
</body>
</html>
