@extends('admin.layouts.master')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-900">{{ __('titles.users') }}</h1>
        <div class="w-25 d-flex justify-content-between align-items-center">
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
            <a href="{{ route('admin.users.create') }}"
               class="btn btn-success btn-sm w-auto">{{ __('titles.add_user') }}</a>
        </div>
    </div>

    <div class="row">
        <table class="table table-striped table-hover text-center">
            <thead>
            <tr>
                <th scope="col">{{ __('titles.id') }}</th>
                <th scope="col">{{ __('titles.name') }}</th>
                <th scope="col">{{ __('titles.phone') }}</th>
                <th scope="col">{{ __('titles.coin') }}</th>
                <th scope="col">{{ __('titles.score') }}</th>
                <th scope="col">{{ __('titles.admin') }}</th>
                <th scope="col">{{ __('titles.action') }}</th>
                <th scope="col">{{ __('titles.others') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->coin }}</td>
                    <td>{{ $user->score }}</td>
                    <td>
                        @if($user->superuser)
                            <h4 class="fas fa-check-circle text-success"></h4>
                        @else
                            <h4 class="fas fa-times-circle text-danger"></h4>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('admin.users.edit', $user->id) }}"
                               class="btn btn-primary btn-sm">{{ __('titles.edit') }}</a>

                            @if($user->active)
                                <form action="{{ route('admin.users.deactivate', $user->id) }}" method="post">
                                    @csrf
                                    <button
                                        class="btn btn-danger btn-sm me-2 ms-2">{{ __('titles.deactivate') }}</button>
                                </form>
                            @else
                                <form action="{{ route('admin.users.activate', $user->id) }}" method="post">
                                    @csrf
                                    <button
                                        class="btn btn-success btn-sm me-2 ms-2">{{ __('titles.activate') }}</button>
                                </form>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('admin.orders', ['user' => $user->id]) }}"
                               class="btn btn-info btn-sm me-2 ms-2">{{ __('titles.orders') }}</a>
                            <a href="{{ route('admin.users.history', $user->id) }}"
                               class="btn btn-secondary btn-sm me-2 ms-2">{{ __('titles.history') }}</a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">{{ $users->links() }}</div>
@endsection
