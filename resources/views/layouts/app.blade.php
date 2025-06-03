@php
    // By default, use the admin layout type if you are logged in
    // If not, use the user layout.
    $layoutType ??= auth()->check() ? "admin" : "user";

    $hasNavbar ??= true;
    $hasSidebar ??= true;
    $navbarColor ??= "bg-base-100";
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link
            rel="icon"
            href="{{ Vite::asset("resources/images/crs-logo.png") }}"
            type="image/x-icon"
        />

        <title>{{ config("app.name", "Laravel") }}</title>

        <!-- Fonts -->
        @include("layouts.sections.fonts")

        <!-- Styles -->
        @include("layouts.sections.styles")

        <!-- Application Style and Script -->
        @vite(["resources/css/app.css", "resources/js/app.js"])
    </head>

    @php
        switch ($layoutType) {
            case "user":
                $hasNavbar = true;
                $hasSidebar = true;
                $navbarColor = "bg-amber-200 dark:bg-amber-950";
                break;
            case "admin":
                $hasNavbar = true;
                $hasSidebar = true;
                $navbarColor = "bg-fuchsia-200 dark:bg-fuchsia-950";
                break;
        }
    @endphp

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-base-200">
            @if ($hasSidebar)
                <!-- Sidebar -->
                @include("layouts.sections.sidebar", compact("hasNavbar", "layoutType"))
            @endif

            @if ($hasNavbar)
                <!-- Navigation Bar -->
                @include("layouts.sections.navbar", compact("hasSidebar", "navbarColor", "layoutType"))
            @endif

            <!-- Page Content -->
            <div
                @class([
                    "pt-16" => $hasNavbar,
                    "lg:ms-64" => $hasSidebar,
                    "relative flex min-h-screen flex-col items-stretch [&_main]:flex-1",
                ])
            >
                @hasSection("content")
                    @yield("content")
                @else
                    <x-main-container>
                        {{ $slot }}
                    </x-main-container>
                @endif

                @hasSection("footer")
                    <!-- Page Footer -->
                    <footer class="pt-4">
                        @yield("footer")
                    </footer>
                @endif
            </div>

            @if ($hasSidebar && ! $hasNavbar)
                <!-- Sidebar Expand Button -->
                <button
                    type="button"
                    class="btn btn-square btn-primary btn-soft fixed bottom-6 left-6 flex-grow-0 lg:hidden"
                    aria-haspopup="dialog"
                    aria-expanded="false"
                    aria-controls="default-sidebar"
                    data-overlay="#default-sidebar"
                >
                    <span
                        class="icon-[tabler--layout-sidebar-left-expand] size-5"
                    ></span>
                </button>
            @endif
        </div>

        <!-- Scripts -->
        @include("layouts.sections.scripts")
    </body>
</html>
