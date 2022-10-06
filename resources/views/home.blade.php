@extends('layouts.app')

@section('css')
    <style>
        .cd-9 .card-img {
            width: 70px;
            height: 70px;
        }

        .cd-9 .list-style-circle li {
            position: relative;
            padding-left: 20px;
            margin-bottom: 10px;
        }

        .cd-9 .list-style-circle li::before {
            content: "";
            width: 12px;
            height: 12px;
            background: #ccc;
            display: inline-block;
            border-radius: 100px;
            position: absolute;
            top: 50%;
            left: 0;
            transform: translate(0%, -50%);
        }
    </style>
@endsection

@section('content')
    <h5 class="text-light mb-3 mt-1">{{ __('titles.user_rooms') }}</h5>
    <div class="row">
        @foreach($rooms as $room)
            @if(auth()->check())
                @if($room->user_id == auth()->user()->id)
                    <div class="col-4">
                        <div class="card rounded-10 border-0 shadow-lg cd-9 mx-auto mb-5 overflow-hidden text-light"
                             style="width: 18rem; background: #1f1c26;">
                            <div class="card-head d-flex flex-md-row align-items-center p-3">
                                <div class="card-title mb-0">
                                    <h5>{{ __('titles.room_name') .": ". $room->name }}</h5>
                                    <small
                                        class="text-muted">{{ __('titles.room_created') .": ". \Carbon\Carbon::parse($room->created_at)->diffForHumans() }}</small>
                                </div>
                            </div>
                            <div class="card-body py-2">
                                <div class="d-flex align-items-center mb-3">
                                    <img class="card-img rounded-circle ms-2 me-2"
                                         src="{{ '/storage/' . $room->user->avatar }}"
                                         alt="Card image cap" style="width: 40px; height: 40px; border-radius: 100px">
                                    <div class="d-flex flex-column">
                                        <p class="m-0">{{ __('titles.room_creator') . ": " . $room->user->name }}</p>
                                        <p class="text-muted m-0">{{ __('titles.creator_score') . ": " . $room->user->score }}</p>
                                    </div>
                                </div>
                                <div class="w-100 d-flex justify-content-center mb-3">
                                    <button class="btn btn-primary btn-sm">{{ __('titles.join_room') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning">
                        {{ __('messages.no_room_for_user') }}
                    </div>
                @endif
            @endif
        @endforeach
    </div>
    @if(auth()->check())
        <a href="{{ route('rooms.create') }}" class="btn btn-success btn-sm w-25">{{ __('titles.create_room') }}</a>
    @else
        <div class="alert alert-warning">
            {{ __('messages.login_for_create_room') }}
        </div>
    @endif
    <hr class="w-75 text-light">

    <h5 class="text-light mb-2 mt-3">{{ __('titles.all_rooms') }}</h5>
    <div class="row">
        @foreach($rooms as $room)
            <div class="col-4">
                <div class="card rounded-10 border-0 shadow-lg cd-9 mx-auto mb-5 overflow-hidden text-light"
                     style="width: 18rem; background: #1f1c26;">
                    <div class="card-head d-flex flex-md-row align-items-center p-3">
                        <div class="card-title mb-0">
                            <h5>{{ __('titles.room_name') .": ". $room->name }}</h5>
                            <small
                                class="text-muted">{{ __('titles.room_created') .": ". \Carbon\Carbon::parse($room->created_at)->diffForHumans() }}</small>
                        </div>
                    </div>
                    <div class="card-body py-2">
                        <div class="d-flex align-items-center mb-3">
                            <img class="card-img rounded-circle ms-2 me-2"
                                 src="{{ '/storage/' . $room->user->avatar }}"
                                 alt="Card image cap" style="width: 40px; height: 40px; border-radius: 100px">
                            <div class="d-flex flex-column">
                                <p class="m-0">{{ __('titles.room_creator') . ": " . $room->user->name }}</p>
                                <p class="text-muted m-0">{{ __('titles.creator_score') . ": " . $room->user->score }}</p>
                            </div>
                        </div>
                        @if(auth()->check())
                            <div class="w-100 d-flex justify-content-center mb-3">
                                <button class="btn btn-primary btn-sm">{{ __('titles.join_room') }}</button>
                            </div>
                        @else
                            <div class="text-center">
                                <small class="text-warning">
                                    {{ __('messages.login_for_join') }}
                                </small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
