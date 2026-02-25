@extends('layouts.frontend')

@section('title', $post->title . ' | Stay Smart Apartments')

@section('content')
    <div class="blog-single-area sp1">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 m-auto">
                    <div class="heading10">
                        <h2 class="text-anime-style-3 mb-4">{{ $post->title }}</h2>
                        <div class="d-flex align-items-center gap-3 mb-4 text-muted">
                            <div>
                                <img src="{{ asset('assets/img/icons/user.svg') }}" alt="" class="me-1">
                                {{ $post->user->first_name ?? 'Admin' }}
                            </div>
                            <div>|</div>
                            <div>
                                <img src="{{ asset('assets/img/icons/calender.svg') }}" alt="" class="me-1">
                                {{ $post->published_at->format('d M, Y') }}
                            </div>
                        </div>
                    </div>

                    @if($post->image_path)
                        <div class="image-anime mb-5 rounded-4 overflow-hidden">
                            <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}"
                                class="w-100 object-fit-cover">
                        </div>
                    @endif

                    <div class="blog-content heading10" data-aos="fade-up" data-aos-duration="1000">
                        <div style="font-size: 18px; line-height: 1.8;">
                            {!! nl2br(e($post->content)) !!}
                        </div>
                    </div>

                    <div class="space60"></div>

                    <div class="mt-5 pt-4 border-top">
                        <a href="{{ route('welcome') }}" class="header-btn11">
                            <i class="fa-solid fa-arrow-left me-2"></i> Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection