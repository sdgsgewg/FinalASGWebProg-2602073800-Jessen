@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __('payment.title.overpayment') }}</h1>
        <p>{{ __('payment.you_have_overpaid') . ' ' . $overpaid . '. ' . __('payment.add_balance_confirmation') }}</p>
        <form method="POST" action="{{ route('payments.confirmOverpayment') }}">
            @csrf
            <input type="hidden" name="overpaid" value="{{ $overpaid }}">
            <button type="submit" name="decision" value="no" class="btn btn-danger">{{ __('payment.no') }}</button>
            <button type="submit" name="decision" value="yes" class="btn btn-success">{{ __('payment.yes') }}</button>
        </form>
    </div>
@endsection
