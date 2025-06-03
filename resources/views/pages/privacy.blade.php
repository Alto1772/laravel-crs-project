@extends('layouts.app', ['layoutType' => 'admin'])

{{-- @section('header')
    <h2 class="text-xl font-semibold leading-tight">
        {{ __('Privacy') }}
    </h2>
@endsection --}}

@section('content')
    <x-main-container class="max-w-screen-md">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title text-center">Privacy</h2>
            </div>
            <div class="card-body text-justify">
                <p class="mb-4">The Course Recommendation System (CRS) is committed to protecting the privacy and personal
                    information of its users. All responses submitted through the questionnaire are stored securely and used
                    solely for the purpose of generating academic program recommendations.
                </p>
                <p>Data is anonymized during processing and is not shared with third parties. Access to administrative
                    functions is strictly controlled. By using the CRS, users agree to the responsible handling and
                    safeguarding of their information.</p>
            </div>
        </div>
    </x-main-container>
@endsection
