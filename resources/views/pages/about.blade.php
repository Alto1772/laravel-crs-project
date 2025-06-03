@extends('layouts.app', ['layoutType' => 'user'])

{{-- @section('header')
    <h2 class="text-xl font-semibold leading-tight">
        {{ __('About CRS') }}
    </h2>
@endsection --}}

@section('content')
    <x-main-container class="max-w-screen-md">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title text-center">About CRS</h2>
            </div>
            <div class="card-body">
                <p class="text-justify">The Course Recommendation System (CRS) is a web-based platform designed to assist
                    incoming college
                    students at Catanduanes State University in identifying the most suitable board programs aligned with
                    their strengths and current knowledge. By answering a set of curated multiple-choice questions derived
                    from various college departments, users receive data-driven recommendations based on the K-Nearest
                    Neighbors (KNN) algorithm. The system promotes informed decision-making, enhances self-awareness among
                    students, and supports academic institutions in guiding enrollees toward appropriate educational paths.
                    CRS is built with usability, adaptability, and user-centered design in mind.</p>
            </div>
        </div>
    </x-main-container>
@endsection
