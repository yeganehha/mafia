@extends('admin.layouts.master')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-900">{{ __('titles.rooms') }}</h1>
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
                <th scope="col">{{ __('titles.room_name') }}</th>
                <th scope="col">{{ __('titles.room_creator') }}</th>
                <th scope="col">{{ __('titles.room_type') }}</th>
                <th scope="col">{{ __('titles.room_model') }}</th>
                <th scope="col">{{ __('titles.exists') }}</th>
                <th scope="col">{{ __('titles.action') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($rooms as $room)
                <tr>
                    <th scope="row">{{ $room->id }}</th>
                    <td>{{ $room->name }}</td>
                    <td>{{ $room->user->name }}</td>
                    <td>
                        @switch($room->type)
                            @case('classic')
                                {{ __('titles.classic_room') }}
                                @break
                        @endswitch
                    </td>
                    <td>
                        @if($room->is_private == 1)
                            {{ __('titles.private_room') }}
                        @else
                            {{ __('titles.public_room') }}
                        @endif
                    </td>
                    <td>
                        @if($room->exist)
                            <h4 class="fas fa-check-circle text-success"></h4>
                        @else
                            <h4 class="fas fa-times-circle text-danger"></h4>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('admin.rooms.details', $room->id) }}"
                               class="btn btn-primary btn-sm">{{ __('titles.details') }}</a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">{{ $rooms->links() }}</div>
@endsection
