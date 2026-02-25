@extends('layouts.guest')

@section('content')
    <main class="authentication-content mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-4 mx-auto">
                    <div class="card shadow rounded-4 overflow-hidden">
                        <div class="card-body p-4 p-sm-5">
                            <h5 class="card-title">{{ __('Verify Your Email Address') }}</h5>

                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif

                            <p class="mb-4">{{ __('Before proceeding, please check your email for a verification link.') }}
                            </p>

                            <p class="mb-0">{{ __('If you did not receive the email') }},</p>
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <div class="d-grid gap-2 mt-3">
                                    <button type="submit"
                                        class="btn btn-primary radius-30">{{ __('Click here to request another') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection