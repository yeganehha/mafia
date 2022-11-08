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
                <th scope="col">{{ __('titles.name') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($packages as $package)
                <tr>
                    <th scope="row">{{ $package->id }}</th>
                    <td>{{ $package->name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">{{ $packages->links() }}</div>
@endsection
