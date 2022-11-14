@extends('profile.app')

@section('css')
    <style>
        .list-unstyled:hover {
            background: #101113;
        }

        .nav-link.active {
            background: #101113;
        }

        .pagination {
            --bs-pagination-color: #ffffff;
            --bs-pagination-bg: #212529;
            --bs-pagination-hover-bg: #e9ecef;
            --bs-pagination-active-bg: #0d6efd;
            --bs-pagination-active-border-color: #dfdfdf;
            --bs-pagination-disabled-color: #9d9e9f;
            --bs-pagination-disabled-bg: #212529;
            --bs-pagination-disabled-border-color: #dee2e6;
        }
    </style>
@endsection

@section('card')
    <div class="row w-100 text-center d-flex justify-content-center align-items-center m-0">
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    <ul class="list-group">
                        <li>{{ $error }}</li>
                    </ul>
                </div>
            @endforeach
        @endif
        <table class="table table-dark table-hover">
            <thead>
            <tr>
                <th scope="col">{{ __('titles.row') }}</th>
                <th scope="col">{{ __('titles.uuid') }}</th>
                <th scope="col">{{ __('titles.product') }}</th>
                <th scope="col">{{ __('titles.quantity') }}</th>
                <th scope="col">{{ __('titles.price') }}</th>
                <th scope="col">{{ __('titles.pay_status') }}</th>
                <th scope="col">{{ __('titles.action') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $order->id }}</td>
                    <td>
                        @switch($order->items[0]->item)
                            @case('coin')
                                <div class="text-warning">{{ __('titles.coin') }}</div>
                                @break
                            @case('package')
                                <div class="text-info">{{ __('titles.package') }}</div>
                                @break
                        @endswitch
                    </td>
                    <td>{{ $order->items[0]->value }}</td>
                    <td>{{ $order->price }} {{ __('titles.toman') }}</td>

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
                        @if($order->status == \App\Enum\OrderStatusEnum::UNPAID)
                            <a href="{{ route('order.repay', $order->uuid) }}" type="submit"
                               class="btn btn-info btn-sm">{{ __('titles.pay') }}</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @php
            $userOrders = \App\Models\Order::where('user_id', auth()->user()->id)->get();
        @endphp
        @if(!$userOrders->count())
            <div class="alert alert-warning w-auto">
                {{ __('messages.no_order_for_user') }}
            </div>
        @endif
    </div>
    <div class="d-flex justify-content-center" dir="ltr">{{ $orders->links() }}</div>
@endsection
