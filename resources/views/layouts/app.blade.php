<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>
    <body class="font-sans antialiased">
    <!-- resources/views/layouts/app.blade.php -->
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        
        <!-- Button to open Sidebar (Only visible when sidebar is closed) -->
        <button class="openbtn" id="toggleSidebarBtn" onclick="toggleSidebar()"></button>

        <!-- Sidebar -->
        @include('layouts.sidebar') <!-- Menyertakan sidebar dari file terpisah -->

        <!-- Page Content -->
        <div class="main-content" id="mainContent">
            <!-- Navigation Bar -->
            <div class="sticky-nav">
                @include('layouts.navigation')
            </div>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>
    </div>


        <script>
            function toggleSidebar() {
                let sidebar = document.getElementById('sidebar');
                let mainContent = document.getElementById('mainContent');
                let toggleButton = document.getElementById('toggleSidebarBtn');
                
                sidebar.classList.toggle('closed');
                mainContent.classList.toggle('expanded');  // Add 'expanded' class

                // Toggle the visibility of the button
                if (sidebar.classList.contains('closed')) {
                    toggleButton.style.display = 'block'; // Show the button when sidebar is closed
                    toggleButton.innerHTML = "→"; // Show right arrow when sidebar is closed
                } else {
                    toggleButton.style.display = 'none'; // Hide the button when sidebar is open
                    toggleButton.innerHTML = "←"; // Show left arrow when sidebar is open
                }
            }

            // Show the toggle button when the page loads if the sidebar is closed
            document.addEventListener("DOMContentLoaded", function() {
                let sidebar = document.getElementById('sidebar');
                let toggleButton = document.getElementById('toggleSidebarBtn');
                if (sidebar.classList.contains('closed')) {
                    toggleButton.style.display = 'block'; // Show the button if sidebar is closed
                }
            });
        </script>
    </body>
</html>
