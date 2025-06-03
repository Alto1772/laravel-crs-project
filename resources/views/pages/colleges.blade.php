@extends('layouts.app', ['layoutType' => 'user'])

@section('header')
    <h2 class="text-xl font-semibold leading-tight">
        {{ __('College Overview') }}
    </h2>
@endsection

@section('content')
    <x-main-container>
        <section id="colleges-analysis">
            <h2 class="text-center text-2xl font-bold">Statistical Analysis</h2>
            <div class="mt-4 flex flex-col gap-4">
                <livewire:programs-pie-chart />
                <livewire:programs-bar-chart />
            </div>
        </section>

        <section id="colleges-list" class="mt-8">
            <h2 class="text-center text-2xl font-bold">Colleges</h2>
            <livewire:user-colleges-list />
        </section>

        <section id="announcement" class="mb-6 mt-8">
            <div class="alert alert-info alert-soft max-sm:text-sm" role="alert">
                <b>NOTE:</b>
                Agriculture is open for all
            </div>
        </section>

        <!-- Start Answering Button -->
        <section class="fixed bottom-6 right-6 z-20">
            <x-dynamic-link class="btn btn-success" route="questionnaire.input-name">
                <span class="icon-[tabler--list-details]"></span>
                Start Answering
            </x-dynamic-link>
        </section>

        <!-- Modal -->
        <x-modal id="college-desc-modal" class="modal-middle">
            <x-slot:title>
                <span x-text="selectedCollege" id="selected-college"></span>
                description
            </x-slot>

            <p>
                Lorem ipsum dolor sit amet consectetur, adipisicing
                elit. Facere, adipisci pariatur voluptate beatae sint
                expedita.
            </p>

            <x-slot:footer>
                <button type="button" class="btn btn-secondary max-sm:btn-sm" data-overlay="#college-desc-modal">
                    Close
                </button>
                {{--
                            <button type="button" class="btn btn-accent">
                            Start Answering
                            </button>
                        --}}
            </x-slot>
        </x-modal>
    </x-main-container>
@endsection

{{--
    @section('footer')
    <div class="px-4 py-3">
    <span class="text-lg uppercase">
    <b>Note:</b>
    Agriculture is open for all
    </span>
    </div>
    @endsection
--}}
