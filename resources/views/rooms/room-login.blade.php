@extends('layouts.app')

@section('content')
    <div class="w-50">
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    <ul class="list-group">
                        <li>{{ $error }}</li>
                    </ul>
                </div>
            @endforeach
        @endif
    </div>
    <form action="{{ route('rooms.checkRoomPass', request()->link) }}" method="POST" class="w-75">
        @csrf
        <div class="row">
            <div class="col mb-3">
                <label for="password" class="text-muted">{{ __('titles.password') }}:</label>
                <input id="password" type="password"
                       class="border-secondary bg-dark text-light form-control @error('password') is-invalid @enderror mt-2"
                       name="password" value="{{ old('password') }}" required autocomplete="password" autofocus>
                @error('password')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-success">{{ __('titles.join_room') }}</button>
    </form>
@endsection
