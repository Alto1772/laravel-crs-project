@extends('layouts.app-legacy')

@section('title', 'Course Recommendation System')

@section('content')
    <main class="min-h-screen bg-banner bg-auto bg-center bg-no-repeat px-3 sm:px-0">
        <header class="mx-auto flex h-24 w-11/12 items-center justify-between py-9">
            <span class="cursor-pointer font-logo text-3xl text-[#936fdb]">
                CRS
            </span>
            <nav>
                <ul class="flex space-x-10">
                    <li>
                        <x-legacy.nav-link :href="url('/')" :active="request()->is('/')" class="uppercase text-fuchsia-700">
                            {{ _('Home') }}
                        </x-legacy.nav-link>
                    </li>
                    <li>
                        <x-legacy.nav-link :href="route('about')" class="uppercase text-fuchsia-700">
                            {{ _('About') }}
                        </x-legacy.nav-link>
                    </li>
                    <li>
                        <x-legacy.nav-link :href="route('admin.colleges')" class="uppercase text-fuchsia-700">
                            {{ _('Admin') }}
                        </x-legacy.nav-link>
                    </li>
                </ul>
            </nav>
        </header>
        <section class="absolute left-0 top-[60%] w-full -translate-y-1/2 space-y-5 overflow-x-hidden text-center">
            <h1 class="mt-20 text-3xl font-bold">
                Course Recommendation System (CRS)
            </h1>
            <p class="mx-2.5 mb-0 font-light leading-10">
                Welcome to our CRS! Where we Recommend Based on Your Expertise.
            </p>
            <div class="flex flex-wrap justify-center gap-5">
                <x-legacy.cta-button href="{{ route('questionnaire.input-name') }}"
                    class="border-indigo-600 before:bg-fuchsia-300">
                    {{ _('Start Answering') }}
                </x-legacy.cta-button>
                <x-legacy.cta-button href="{{ route('colleges') }}" class="border-indigo-600 before:bg-fuchsia-300">
                    {{ _('College Overview') }}
                </x-legacy.cta-button>
            </div>
        </section>
    </main>
@endsection
