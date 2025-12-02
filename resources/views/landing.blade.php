@extends('layouts.public')

@section('content')
    <!-- Hero Section -->
    <header class="hero">
        <div class="hero-content">
            <i class="fa-brands fa-playstation hero-logo"></i>
            <h1>{{ __('landing.hero_title') }}</h1>
            <p>{{ __('landing.hero_subtitle') }}</p>
            <div class="hero-buttons">
                <a href="{{ route('register.show') }}" class="btn-hero btn-primary">
                    {{ __('landing.start_renting') }} <i class="fas fa-arrow-right"></i>
                </a>
                <a href="#features" class="btn-hero btn-secondary">
                    {{ __('landing.learn_more') }}
                </a>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="features-grid">
            <div class="feature-card">
                <i class="fas fa-gamepad feature-icon"></i>
                <h3>{{ __('landing.features_title_1') }}</h3>
                <p>{{ __('landing.features_desc_1') }}</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-clock feature-icon"></i>
                <h3>{{ __('landing.features_title_2') }}</h3>
                <p>{{ __('landing.features_desc_2') }}</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-headset feature-icon"></i>
                <h3>{{ __('landing.features_title_3') }}</h3>
                <p>{{ __('landing.features_desc_3') }}</p>
            </div>
        </div>
    </section>
@endsection