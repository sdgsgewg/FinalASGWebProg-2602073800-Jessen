{{-- resources/views/payment.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __('payment.title.payment_page') }}</h1>
        <p>{{ __('payment.your_regis_fee') . ' ' . session('registration_price') }}</p>

        <form method="POST" action="{{ route('payments.submit') }}">
            @csrf
            <div class="mb-3">
                <label for="amount" class="form-label">{{ __('payment.enter_amount') }}</label>
                <input type="number" id="amount" name="amount" value="{{ old('amount') }}" class="form-control @error('amount') is-invalid @enderror"
                    required>
                @error('amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">{{ __('payment.pay') }}</button>
        </form>
    </div>
@endsection
