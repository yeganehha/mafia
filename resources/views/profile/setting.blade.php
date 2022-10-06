@extends('profile.app')

@section('css')
    <style>
        .list-unstyled:hover {
            background: #101113;
        }

        .nav-link.active {
            background: #101113;
        }
    </style>
@endsection

@section('card')
    <div class="row mx-auto">
        <div class="w-100 d-flex justify-content-center align-items-center mb-3">
            <img src="{{ '/storage/' . $user->avatar }}" alt="{{ __('titles.avatar') }}"
                 style="width: 100px; height: 100px; border-radius: 100px">
        </div>
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    <ul class="list-group">
                        <li>{{ $error }}</li>
                    </ul>
                </div>
            @endforeach
        @endif
        <form action="{{ route('profile.edit') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="name" class="text-muted">{{ __('titles.name') }}:</label>
                    <input id="name" type="text"
                           class="border-secondary bg-dark text-light form-control @error('name') is-invalid @enderror mt-2"
                           name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-6 mb-3">
                    <label for="avatar" class="text-muted">{{ __('titles.avatar') }}:</label>
                    <input id="avatar" type="file"
                           class="border-secondary bg-dark text-light form-control @error('avatar') is-invalid @enderror mt-2"
                           name="avatar" value="{{ old('avatar', $user->avatar) }}" autocomplete="avatar"
                           autofocus>
                    @error('avatar')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('titles.edit') }}</button>
        </form>
    </div>
@endsection
