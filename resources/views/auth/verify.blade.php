@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16">
                                <path d="M16 8a8 8 0 1 0-16 0 8 8 0 0 0 16 0zM6.97 10.97a.75.75 0 0 1-1.08-.02L3.324 8.383a.75.75 0 1 1 1.06-1.06L6 8.939l4.47-4.47a.75.75 0 1 1 1.06 1.06l-5 5a.75.75 0 0 1-1.06-.02z"/>
                            </svg>
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                    <p>{{ __('If you did not receive the email') }},</p>

                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}" id="resend-form">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline" id="resend-button">
                            {{ __('click here to request another') }}
                        </button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('resend-form').addEventListener('submit', function () {
        const button = document.getElementById('resend-button');
        button.textContent = 'Sending...';
        button.disabled = true;
    });
</script>
@endsection
