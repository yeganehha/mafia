@extends('admin.layouts.master')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-900">{{ __('titles.rooms') }}</h1>
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
            <a href="{{ route('admin.package.create') }}"
               class="btn btn-success btn-sm w-auto">{{ __('titles.add_package') }}</a>
        </div>
    </div>

    <div class="row">
        <table class="table table-striped table-hover text-center">
            <thead>
            <tr>
                <th scope="col">{{ __('titles.id') }}</th>
                <th scope="col">{{ __('titles.name') }}</th>
                <th scope="col">{{ __('titles.activation') }}</th>
                <th scope="col">{{ __('titles.deactivation') }}</th>
                <th scope="col">{{ __('titles.count') }}</th>
                <th scope="col">{{ __('titles.counted_price') }}</th>
                <th scope="col">{{ __('titles.coins') }}</th>
                <th scope="col">{{ __('titles.action') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($packages as $package)
                <tr>
                    <th scope="row">{{ $package->id }}</th>
                    <td>{{ $package->name }}</td>
                    <td>{{ \Illuminate\Support\Carbon::parse($package->activation)->diffForHumans() }}</td>
                    <td>{{ \Illuminate\Support\Carbon::parse($package->deactivation)->diffForHumans() }}</td>
                    <td>{{ $package->count }}</td>
                    <td>{{ $package->counted_price }}</td>
                    <td>{{ $package->coins }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('admin.package.edit', $package->id) }}"
                               class="btn btn-primary btn-sm me-2 ms-2">{{ __('titles.edit') }}</a>
                            <form action="{{ route('admin.package.destroy', $package->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="btn btn-danger btn-sm me-2 ms-2">{{ __('titles.delete') }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">{{ $packages->links() }}</div>
@endsection
