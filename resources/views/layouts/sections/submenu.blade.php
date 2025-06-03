<ul
    id="{{ $parentMenuId }}-collapse"
    class="collapse hidden w-auto overflow-hidden transition-[height] duration-300"
    aria-labelledby="{{ $parentMenuId }}"
>
    @foreach ($parentMenu->submenus as $menu)
        @php
            $isSubmenu = isset($menu->submenus) && count($menu->submenus) > 0;

            $slug = Str::slug($menu->name, "-");
            $menuId = "{$parentMenuId}--{$slug}";
        @endphp

        @if ($isSubmenu)
            <li class="nested-collapse-wrapper">
                <a
                    class="collapse-toggle collapse-open:bg-base-content/10"
                    id="{{ $menuId }}"
                    data-collapse="#{{ $menuId }}-collapse"
                >
                    <span class="{{ $menu->icon }} size-5"></span>
                    {{ $menu->name }}
                    <span
                        class="icon-[tabler--chevron-down] collapse-open:rotate-180 size-4 transition-all duration-300"
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
