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
    <h5 class="text-light mb-2 mt-3">{{ __('titles.all_rooms') }}</h5>
    <div class="row w-100 justify-content-center align-items-center">
        @if($rooms->count())
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
                                @if(auth()->user()->id == $room->user_id)
                                    <div class="w-100 d-flex justify-content-center mb-3">
                                        <form
                                            action="{{ route('rooms.enter', ['link'=>$room->link]) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-warning btn-sm">{{ __('titles.enter_room') }}</button>
                                        </form>
                                    </div>
                                @else
                                    <div class="w-100 d-flex justify-content-center mb-3">
                                        <a href="{{ route('rooms.join', ['link'=>$room->link]) }}"
                                           class="btn btn-primary btn-sm">{{ __('titles.join_room') }}</a>
                                    </div>
                                @endif
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
        @else
            <div class="alert alert-warning w-auto">
                {{ __('messages.no_room') }}
            </div>
            <div class="d-flex w-100 justify-content-center align-items-center">
                <a href="{{ route('rooms.create') }}"
                   class="btn btn-success w-auto ms-2 me-2 btn-sm">{{ __('titles.create_room') }}</a>
            </div>
        @endif
    </div>

@endsection
