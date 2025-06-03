@extends('layouts.app-legacy')

@php
    $loginErrors = $page == 'login' ? $errors : collect();
    $registerErrors = $page == 'register' ? $errors : collect();
@endphp

@section('title', 'Login Form')

@section('content')
    <main class="flex items-center justify-center bg-banner bg-auto bg-fixed bg-center bg-no-repeat px-5 py-6">
        <div class="w-full rounded-2xl border-4 border-fuchsia-950 px-8 py-5 backdrop-blur-sm sm:max-w-md"
            data-current-tab="{{ $page }}">
            <x-legacy.auth-session-status class="mt-4 sm:mt-6" :status="session('status')" />
            <x-legacy.auth-session-status class="mt-4 sm:mt-6" type="warning" :status="session('warning')" />
            <header class="mt-4 sm:mt-6">
                <nav class="flex justify-between gap-5 px-[10%] sm:gap-0 sm:space-x-10">
                    <button data-tab="login" @class([
                        'max-w-[200px] flex-1 cursor-pointer rounded-full px-5 py-3 font-semibold text-white duration-200 hover:bg-fuchsia-900',
                        $page == 'login' ? 'bg-fuchsia-900' : 'bg-gray-800',
                    ])>
                        Sign In
                    </button>
                    <button data-tab="register" @class([
                        'max-w-[200px] flex-1 cursor-pointer rounded-full px-5 py-3 font-semibold text-white duration-200 hover:bg-fuchsia-900',
                        $page == 'register' ? 'bg-fuchsia-900' : 'bg-gray-800',
                    ])>
                        Sign Up
                    </button>
                </nav>
            </header>

            <section class="overflow-hidden pb-4 pt-8">
                <div id="login-container" class="grid auto-cols-[100%] grid-flow-col duration-500" @style(['transform: translateX(-100%)' => $page == 'register'])>
                    {{-- Login Form --}}
                    <form action="{{ route('login') }}" method="POST"
                        class="flex w-full flex-col items-stretch px-2 pt-2 duration-500" id="loginForm">
                        @csrf
                        <h1 class="text-center text-3xl font-bold text-black">
                            Sign In
                        </h1>
                        {{-- Username --}}
                        <div class="relative mt-5">
                            <x-legacy.text-input class="w-full" type="text" name="name" id="name"
                                placeholder="Username" :value="old('name')" required />
                            <label for="name" class="absolute right-4 top-1/2 size-4 -translate-y-1/2 sm:size-5">
                                <span class="icon-[ion--person-outline] size-full text-fuchsia-700"></span>
                            </label>
                        </div>
                        <x-legacy.input-error class="mt-2" :messages="$loginErrors->get('name')" />
                        {{-- Password --}}
                        <x-legacy.input-password class="mt-5 w-full" id="password" placeholder="Password" name="password"
                            required />
                        <x-legacy.input-error :messages="$loginErrors->get('password')" class="mt-2" />
                        {{-- Remember Me --}}
                        <div class="mt-5 flex items-center justify-center sm:justify-start">
                            <x-legacy.checkbox type="checkbox" id="remember_me" name="remember" />
                            <label for="remember_me" class="ms-2 text-sm">
                                {{ _('Remember Me') }}
                            </label>
                        </div>
                        {{-- Forgot Password --}}
                        <div class="mt-3 text-center sm:text-right">
                            <a href="{{ route('password.request') }}" class="text-sm hover:underline">
                                {{ _('Forgot Password') }}
                            </a>
                        </div>
                        {{-- Sign in --}}
                        <div class="mt-5">
                            <button type="submit"
                                class="group flex w-full items-center justify-center rounded-full bg-gray-800 py-3 text-white duration-300 hover:bg-fuchsia-900">
                                <span class="text-base font-bold sm:text-lg">
                                    Sign In
                                </span>
                                <span
                                    class="icon-[ion--arrow-forward-circle-outline] ms-1 size-5 duration-200 group-hover:translate-x-3"></span>
                            </button>
                        </div>
                        <hr class="mt-4 border-gray-500" />
                        {{-- Social Buttons --}}
                        <div class="mt-4 flex items-center justify-center">
                            <a href="#" class="box-content p-2">
                                <span class="icon-[ion--logo-google] size-6"></span>
                            </a>
                        </div>
                    </form>
                    {{-- Register Form --}}
                    <form action="{{ route('register') }}" method="POST"
                        class="flex w-full flex-col items-stretch px-2 pt-2 duration-500" id="registerForm">
                        @csrf
                        <h1 class="text-center text-3xl font-bold text-black">
                            Sign Up
                        </h1>
                        {{-- Email --}}
                        <div class="relative mt-5">
                            <x-legacy.text-input class="w-full" type="email" name="email" id="reg_email"
                                placeholder="Email" :value="old('email')" required />
                            <label for="reg_email" class="absolute right-4 top-1/2 size-4 -translate-y-1/2 sm:size-5">
                                <span class="icon-[ion--mail-outline] size-full text-fuchsia-700"></span>
                            </label>
                        </div>
                        <x-legacy.input-error class="mt-2" :messages="$registerErrors->get('email')" />
                        {{-- Username --}}
                        <div class="relative mt-5">
                            <x-legacy.text-input class="w-full" type="text" name="name" id="reg_name"
                                placeholder="Username" :value="old('name')" required />
                            <label for="reg_name" class="absolute right-4 top-1/2 size-4 -translate-y-1/2 sm:size-5">
                                <span class="icon-[ion--person-outline] size-full text-fuchsia-700"></span>
                            </label>
                        </div>
                        <x-legacy.input-error class="mt-2" :messages="$registerErrors->get('name')" />
                        {{-- Password --}}
                        <x-legacy.input-password class="mt-5 w-full" id="reg_password" placeholder="Password"
                            name="password" required />
                        <x-legacy.input-error :messages="$registerErrors->get('password')" class="mt-2" />
                        {{-- Confirm Password --}}
                        <x-legacy.input-password class="mt-5 w-full" id="confirm_password" placeholder="Confirm Password"
                            name="password_confirmation" required />
                        {{-- Remember Me --}}
                        <div class="mt-5 flex items-center justify-center sm:justify-start">
                            <x-legacy.checkbox type="checkbox" id="reg_remember_me" name="remember" />
                            <label for="reg_remember_me" class="ms-2 text-sm">
                                {{ _('Remember Me') }}
                            </label>
                        </div>
                        {{-- Forgot Password --}}
                        <div class="mt-3 text-center sm:text-right">
                            <a href="{{ route('password.request') }}" class="text-sm hover:underline">
                                {{ _('Forgot Password') }}
                            </a>
                        </div>
                        {{-- Sign Up --}}
                        <div class="mt-5">
                            <button type="submit"
                                class="group flex w-full items-center justify-center rounded-full bg-gray-800 py-3 text-white duration-300 hover:bg-fuchsia-900">
                                <span class="text-base font-bold sm:text-lg">
                                    Sign Up
                                </span>
                                <span
                                    class="icon-[ion--arrow-forward-circle-outline] ms-1 size-5 duration-200 group-hover:translate-x-3"></span>
                            </button>
                        </div>
                        <hr class="mt-4 border-gray-500" />
                        {{-- Social Buttons --}}
                        <div class="mt-4 flex items-center justify-center">
                            <div class="mt-4 flex items-center justify-center">
                                <a href="#" class="box-content p-2">
                                    <span class="icon-[ion--logo-google] size-6"></span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>
@endsection

@push('page-scripts')
    @vite('resources/js/pages/login.js')
@endpush
