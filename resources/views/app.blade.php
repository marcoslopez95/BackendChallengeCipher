<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite([
            'resources/css/app.css',
            'resources/js/app.js',
            "resources/js/Pages/{$page['component']}.vue",
            ])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
      <x-multiselect-component
      :items="[
        ['id' => 1, 'name' => 'Python'],
        ['id' => 2, 'name' => 'Java'],
        ['id' => 3, 'name' => 'Django'],
        ['id' => 4, 'name' => 'Ruby'],
        ['id' => 5, 'name' => 'HTML']]"
    :multiselect="true"

      >

      </x-multiselect-component>
        @inertia
    </body>
</html>
