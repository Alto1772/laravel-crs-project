@props(['route', 'link'])

@php
    if (!empty($route)) {
        $link = route($route);
        $active = request()->routeIs($route);
    } elseif (!empty($link)) {
        $link = url($link);
        $active = request()->is($link);
    } else {
        $link = '#';
        $active = false;
    }
@endphp

<a {{ $attributes->class(['active' => $active])->merge(['href' => $link]) }}>
    {{ $slot }}
</a>
