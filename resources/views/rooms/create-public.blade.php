@extends('layouts.app')

@section('content')
    <form action="{{ route('rooms.create.public') }}" method="POST" class="w-75">
        @csrf
        <div class="row">
            <div class="col mb-3">
                <label for="name" class="text-muted">{{ __('titles.name') }}:</label>
                <input id="name" type="text"
                       class="border-secondary bg-dark text-light form-control @error('name') is-invalid @enderror mt-2"
                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>
            <div class="col mb-3 d-flex flex-column">
                <label for="type" class="text-muted form-label">{{ __('titles.room_type') }}:</label>
                @foreach(config('roomType.types') as $key => $value)
                    <div class="d-flex">
                        <input id="{{ $key }}" type="radio"
                               class="form-check-input @error('type') is-invalid @enderror mt-2"
                               name="type" value="{{ $value }}" required checked>&nbsp;
                        <label for="{{ $key }}" class="text-light form-check-label mt-1">
                            {{ __('titles.classic_room') }}
                        </label>
                        @error('type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                @endforeach
            </div>
        </div>
        <button type="submit" class="btn btn-success">{{ __('titles.create_room') }}&nbsp;({{ __('titles.public_cost') }})</button>
    </form>
@endsection