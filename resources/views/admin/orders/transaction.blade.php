@extends('admin.layouts.master')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-900">{{ __('titles.transactions') }}</h1>
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.orders') }}" class="btn btn-secondary btn-sm">{{ __('titles.back') }}</a>
        </div>
    </div>

    <div class="row">
        <table class="table table-striped table-hover text-center">
            <thead>
            <tr>
                <th scope="col">{{ __('titles.id') }}</th>
                <th scope="col">{{ __('titles.tracking_code') }}</th>
                <th scope="col">{{ __('titles.price') }}</th>
                <th scope="col">{{ __('titles.payment_gateway') }}</th>
                <th scope="col">{{ __('titles.transaction_created') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <th scope="row">{{ $transaction->id }}</th>
                    <td>{{ ltrim($transaction->tracking_code1, '0') }}</td>
                    <td>{{ $transaction->order->price }}</td>
                    <td>{{ $transaction->gateway }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->diffForHumans() }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center" dir="ltr">{{ $transactions->links() }}</div>
@endsection
