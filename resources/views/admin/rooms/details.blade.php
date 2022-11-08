@extends('admin.layouts.master')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-900">{{ __('titles.details') }}</h1>
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary btn-sm">{{ __('titles.back') }}</a>
    </div>

    <div class="row text-center">
        <div class="col">
            <p class="border-bottom pb-3">{{ __('titles.room_name') }}</p>
            <p class="border-bottom pb-3">{{ __('titles.room_type') }}</p>
            <p class="border-bottom pb-3">{{ __('titles.room_model') }}</p>
            <p class="border-bottom pb-3">{{ __('titles.room_link') }}</p>
            <p class="border-bottom pb-3">{{ __('titles.room_pass') }}</p>
            <p class="border-bottom pb-3">{{ __('titles.join_request') }}</p>
            <p class="border-bottom pb-3">{{ __('titles.exists') }}</p>
            @if($room->deleted_at)
                <p class="border-bottom pb-3">{{ __('titles.room_deleted') }}</p>
            @endif
        </div>
        <div class="col">
            <p class="border-bottom pb-3">{{ $room->name }}</p>
            <p class="border-bottom pb-3">
                @switch($room->type)
                    @case('classic')
                        {{ __('titles.classic_room') }}
                        @break
                @endswitch
            </p>
            <p class="border-bottom pb-3">
                @if($room->is_private == 1)
                    {{ __('titles.private_room') }}
                @else
                    {{ __('titles.public_room') }}
                @endif
            </p>
            <p class="border-bottom pb-3">{{ url(route('rooms.join', ['link'=>$room->link])) }}</p>
            <p class="border-bottom pb-3">
                @if($room->password)
                    {{ $room->password }}
                @else
                    {{ __('titles.no_pass') }}
                @endif
            </p>
            <p class="border-bottom pb-3">
                @if($room->join_request)
                    <a href="" class="btn btn-primary">{{ __('titles.show_join_requests') }}</a>
                @else
                    {{ __('titles.in_active') }}
                @endif
            </p>
            <div class="border-bottom pb-3">
                @if($room->exist)
                    <h4 class="fas fa-check-circle text-success m-0"></h4>
                @else
                    <h4 class="fas fa-times-circle text-danger m-0"></h4>
                @endif
            </div>
            @if($room->deleted_at)
                <p class="border-bottom pb-3 mt-3">{{ \Carbon\Carbon::parse($room->deleted_at)->diffForHumans() }}</p>
            @endif
        </div>
    </div>
    <hr class="bg-dark">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-900">{{ __('titles.members') }}</h1>
    </div>

    <div class="row mb-5">
        <table class="table table-striped table-hover text-center">
            <thead>
            <tr>
                <th scope="col">{{ __('titles.id') }}</th>
                <th scope="col">{{ __('titles.name') }}</th>
                <th scope="col">{{ __('titles.time_joined') }}</th>
                <th scope="col">{{ __('titles.time_exited') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($room->histories as $history)
                @if(in_array($history->description, ['Create a room', 'Joined room']))
                    @php
                        $user = \App\Models\User::find($history->user_id)
                    @endphp
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td><a href="{{ route('admin.users.index',['search'=>$user->phone]) }}">{{ $user->name }}</a>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($history->time)->diffForHumans() }}</td>
                        <td>
                            @php
                                $exitTime = \App\Models\History::findExitedLog($history->room_id, $history->user_id)
                            @endphp

                            @if($exitTime)
                                {{ \Carbon\Carbon::parse($exitTime->time)->diffForHumans() }}
                            @else
                                {{ __('messages.still_member') }}
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
