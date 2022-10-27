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
        <table class="table table-dark table-hover">
            <thead>
            <tr>
                <th scope="col">ردیف</th>
                <th scope="col">کد پیگیری</th>
                <th scope="col">محصول</th>
                <th scope="col">تعداد</th>
                <th scope="col">قیمت کل</th>
                <th scope="col">وضعیت</th>
                <th scope="col">عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                @if($order->user_id == auth()->user()->id)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $order->id }}</td>
                        <td>
                            @switch($order->items[0]->item)
                                @case('coin')
                                    <div class="text-warning">سکه</div>
                                    @break
                            @endswitch
                        </td>
                        <td>{{ $order->items[0]->value }}</td>
                        <td>{{ $order->price }} تومان</td>

                        <td>
                            @switch($order->status)
                                @case(\App\Enum\OrderStatusEnum::UNPAID)
                                    <div class="badge badge-warning badge-pill">پرداخت نشده</div>
                                    @break
                                @case(\App\Enum\OrderStatusEnum::PAID)
                                    <div class="badge badge-success badge-pill">پرداخت شده</div>
                                    @break
                                @case(\App\Enum\OrderStatusEnum::CANCELED)
                                    <div class="badge badge-dark badge-pill">لغو شده</div>
                                    @break
                            @endswitch
                        </td>
                        <td>
                            @if($order->status == \App\Enum\OrderStatusEnum::UNPAID)
                                <form action="{{ route('order.repay', $order->uuid) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-info btn-sm">{{ __('titles.pay') }}</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endif
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
