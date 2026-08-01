@extends('layouts.app')

@section('content')

    <x-landing.navbar />

    <main>
        <x-landing.hero />
        <x-landing.features />
        <x-landing.testimonials />
        <x-landing.faq />
        <x-landing.download-app />
    </main>

    <x-landing.footer />

@endsection
