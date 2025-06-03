<div {{ $attributes->class('card relative overflow-hidden') }}>
    <figure {{ $bgimage->attributes->class('absolute inset-0') }}>
        {{ $bgimage }}
    </figure>
    <div {{ $body->attributes->class('card-body relative z-10 flex items-center justify-center') }}>
        {{ $body }}
    </div>
</div>
