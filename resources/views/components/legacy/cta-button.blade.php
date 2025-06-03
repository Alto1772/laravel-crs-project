<a
    {{ $attributes->merge(["class" => "relative w-52 overflow-hidden rounded-full border-2 py-3.5 font-bold duration-300 hover:border-transparent before:absolute before:h-full before:w-0 before:inset-0 before:-z-10 before:rounded-full before:duration-500 hover:before:w-full"]) }}
>
    {{ $slot }}
</a>
