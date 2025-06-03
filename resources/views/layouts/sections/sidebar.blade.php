@php
    $menuData = match ($layoutType) {
        "admin" => $adminMenuData,
        "user" => $userMenuData,
        default => $adminMenuData,
    };
@endphp

<aside
    id="default-sidebar"
    @class([
        "overlay drawer drawer-start z-50 hidden max-w-64 flex-col shadow overlay-open:translate-x-0 overlay-open:duration-150 lg:flex lg:translate-x-0",
        "pt-16" => $hasNavbar,
    ])
    role="dialog"
    tabindex="-1"
>
    <div class="drawer-body px-2 pt-4">
        <ul
            class="menu space-y-0.5 p-0 [&_.nested-collapse-wrapper]:space-y-0.5 [&_ul]:space-y-0.5"
        >
            @foreach ($menuData->menus as $menu)
                @php
                    $isSubmenu = isset($menu->submenus) && count($menu->submenus) > 0;
                    $isHeader = isset($menu->menuHeader);

                    $slug = Str::slug($menu->menuHeader ?? $menu->name, "-");
                    $menuId = "menu-{$slug}";
                @endphp

                @if ($isHeader)
                    <div
                        class="divider py-6 text-base-content/50 after:border-0"
                    >
                        {{ $menu->menuHeader }}
                    </div>
                @elseif ($isSubmenu)
                    <li class="space-y-0.5">
                        <a
                            class="collapse-toggle collapse-open:bg-base-content/10"
                            id="{{ $menuId }}"
                            data-collapse="#{{ $menuId }}-collapse"
                        >
                            <span class="{{ $menu->icon }} size-5"></span>
                            {{ $menu->name }}
                            <span
                                class="icon-[tabler--chevron-down] size-4 transition-all duration-300 collapse-open:rotate-180"
                            ></span>
                        </a>
                        @include("layouts.sections.submenu", ["parentMenu" => $menu, "parentMenuId" => $menuId, "index" => $loop->index + 1])
                    </li>
                @else
                    <li>
                        <x-dynamic-link
                            :route="$menu->route ?? ''"
                            :link="$menu->url ?? ''"
                        >
                            <span class="{{ $menu->icon }} size-5"></span>
                            {{ $menu->name }}
                        </x-dynamic-link>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
    @if ($layoutType == "admin")
        <div class="flex flex-initial items-center justify-center px-2 py-4">
            <form action="{{ route("logout") }}" method="post" class="w-full">
                @csrf
                <button type="submit" class="btn btn-error btn-soft btn-block">
                    <span class="icon-[tabler--logout-2]"></span>
                    Log out
                </button>
            </form>
        </div>
    @endif
</aside>
