@extends('admin.layouts.master')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-900">{{ __('titles.orders') }}</h1>
        <div class="d-flex justify-content-between align-items-center">
            <form action="" dir="ltr">
                <div class="input-group input-group-sm" style="width: 200px;">
                    <input type="text" name="search" class="form-control float-right"
                           placeholder="{{ __('titles.search') }}"
                           value="{{ request('search') }}">

                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <table class="table table-striped table-hover text-center">
            <thead>
            <tr>
                <th scope="col">{{ __('titles.id') }}</th>
                <th scope="col">{{ __('titles.uuid') }}</th>
                <th scope="col">{{ __('titles.product') }}</th>
                <th scope="col">{{ __('titles.quantity') }}</th>
                <th scope="col">{{ __('titles.pay_status') }}</th>
                <th scope="col">{{ __('titles.user') }}</th>
                <th scope="col">{{ __('titles.action') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <th scope="row">{{ $order->id }}</th>
                    <td><small><small><b>{{ $order->uuid }}</b></small></small></td>
                    <td>
                        @switch($order->items[0]->item)
                            @case('coin')
                                <div class="text-danger">{{ __('titles.coin') }}</div>
                                @break
                        @endswitch
                    </td>
                    <td>{{ $order->items[0]->value }}</td>
                    <td>
                        @switch($order->status)
                            @case(\App\Enum\OrderStatusEnum::UNPAID)
                                <div class="badge badge-warning badge-pill">{{ __('titles.unpaid') }}</div>
                                @break
                            @case(\App\Enum\OrderStatusEnum::PAID)
                                <div class="badge badge-success badge-pill">{{ __('titles.paid') }}</div>
                                @break
                            @case(\App\Enum\OrderStatusEnum::CANCELED)
                                <div class="badge badge-dark badge-pill">{{ __('titles.canceled') }}</div>
                                @break
                        @endswitch
                    </td>
                    <td>
                        <a href="{{ route('admin.users.index',['search'=>$order->user->phone]) }}">{{ $order->user->name }}</a>
                    </td>
                    <td>
                        <div class="d-flex justify-content-evenly">
                            <a href="{{ route('admin.transactions', $order->id) }}"
                               class="btn btn-primary btn-sm">{{ __('titles.transactions') }}</a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center" dir="ltr">{{ $orders->links() }}</div>
@endsection
