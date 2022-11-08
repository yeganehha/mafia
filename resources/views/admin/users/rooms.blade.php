@extends('admin.layouts.master')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-900">{{ __('titles.history') }}</h1>
    </div>

    <div class="row">
        <table class="table table-striped table-hover text-center">
            <thead>
            <tr>
                <th scope="col">{{ __('titles.id') }}</th>
                <th scope="col">{{ __('titles.room_name') }}</th>
                <th scope="col">{{ __('titles.user_name') }}</th>
                <th scope="col">{{ __('titles.time_joined') }}</th>
                <th scope="col">{{ __('titles.time_exited') }}</th>
                <th scope="col">{{ __('titles.action') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($histories as $history)
                <tr>
                    <th scope="row">{{ $history->id }}</th>
                    <td>{{ $history->room->name }}</td>
                    <td>{{ $history->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($history->joined)->diffForHumans() }}</td>
                    <td>
                        @if($history->exited)
                            {{ \Carbon\Carbon::parse($history->exited)->diffForHumans() }}
                        @else
                            {{ __('messages.still_member') }}
                        @endif
                    </td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('admin.users.edit', $history->room->id) }}"
                               class="btn btn-primary btn-sm">{{ __('titles.edit') }}</a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">{{ $histories->links() }}</div>
@endsection
