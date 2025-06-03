<nav class="{{ $navbarColor }} navbar fixed inset-x-0 top-0 z-50 shadow">
    @if ($hasSidebar)
        <button type="button" class="btn btn-text me-2 flex-grow-0 max-lg:btn-square lg:hidden" aria-haspopup="dialog"
            aria-expanded="false" aria-controls="default-sidebar" data-overlay="#default-sidebar">
            <span class="icon-[tabler--menu-2] size-5"></span>
        </button>
    @endif

    <div class="navbar-start flex items-center">
        <a class="link flex h-10 items-center space-x-1.5 font-logo text-3xl font-semibold text-[#936fdb] no-underline"
            href="{{ url('/') }}">
            <img src="{{ Vite::asset('resources/images/crs-logo.png') }}" alt="crs logo" class="inline h-[inherit]" />
            <span class="max-sm:hidden">CRS</span>
        </a>
    </div>
    <div class="navbar-center flex items-center max-sm:hidden">
        @hasSection('header')
            @yield('header')
        @elseif (isset($title))
            <h2 class="text-xl font-semibold leading-tight">
                {{ $title }}
            </h2>
        @endif
    </div>
    <div class="navbar-end flex items-center gap-4">
        @if ($layoutType == 'admin')
            {{-- <!-- Notifications -->
            <x-dropdown class="[--auto-close:inside] [--offset:8] [--placement:bottom-end]">
                <x-slot:toggle>
                    <x-dropdown.nav-icon>
                        <div class="indicator">
                            <span class="indicator-item size-2 rounded-full bg-error"></span>
                            <span class="icon-[tabler--bell] size-[1.375rem] text-base-content"></span>
                        </div>
                    </x-dropdown.nav-icon>
                </x-slot:toggle>

                <x-dropdown.item.menu-header class="justify-center">
                    <h6 class="text-base text-base-content">
                        Admin Notifications
                    </h6>
                </x-dropdown.item.menu-header>

                <!-- Notification items -->
                <li
                    class="vertical-scrollbar horizontal-scrollbar rounded-scrollbar max-h-56 overflow-auto text-base-content/80 max-md:max-w-60">
                    @include('layouts.sections.nav.notifications')
                </li>

                <x-dropdown.item.menu-footer class="justify-center">
                    <a href="#" class="flex items-center gap-1">
                        <span class="icon-[tabler--eye] size-4"></span>
                        View all
                    </a>
                </x-dropdown.item.menu-footer>
            </x-dropdown> --}}


            <!-- User Profile -->
            <x-dropdown class="[--auto-close:inside] [--offset:8] [--placement:bottom-end]">
                <x-slot:toggle>
                    <x-dropdown.nav-icon>
                        <div class="avatar">
                            <div class="size-9.5 rounded-full bg-neutral p-1 text-neutral-content">
                                <span class="icon-[tabler--user] size-full"></span>
                            </div>
                        </div>
                    </x-dropdown.nav-icon>
                </x-slot:toggle>

                <x-dropdown.item.menu-header class="gap-2">
                    <div class="avatar">
                        <div class="w-10 rounded-full">
                            <span class="icon-[tabler--user] size-full"></span>
                        </div>
                    </div>
                    <div>
                        <h6 class="text-base font-semibold text-base-content">
                            {{ auth()->user()->name }}
                        </h6>
                        <small class="text-base-content/50">Admin</small>
                    </div>
                </x-dropdown.item.menu-header>

                <x-dropdown.item.link route="profile.edit">
                    <span class="icon-[tabler--user]"></span>
                    My Profile
                </x-dropdown.item.link>
                <x-dropdown.item.link href="#">
                    <span class="icon-[tabler--settings]"></span>
                    Settings
                </x-dropdown.item.link>

                <x-dropdown.item.menu-footer class="gap-2">
                    <form action="{{ route('logout') }}" method="post" class="w-full">
                        @csrf
                        <button type="submit" class="btn btn-error btn-soft btn-block">
                            <span class="icon-[tabler--logout-2]"></span>
                            Log out
                        </button>
                    </form>
                </x-dropdown.item.menu-footer>
            </x-dropdown>
        @else
            {{-- <!------------ TODO Remove this section ------------>
            @auth
                <p>
                    You're logged in as
                    <b>{{ auth()->user()->name }}.</b>
                    <a class="btn btn-info btn-sm ms-2 font-bold" href="{{ route('admin.colleges') }}">
                        Go to Admin
                        <span class="icon-[tabler--arrow-right]"></span>
                    </a>
                </p>
            @endauth --}}
        @endif
    </div>
</nav>
