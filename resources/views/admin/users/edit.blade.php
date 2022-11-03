@extends('admin.layouts.master')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('titles.edit_user') }}</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">{{ __('titles.back') }}</a>
    </div>

    <div class="row">
        <div class="w-100 d-flex justify-content-center align-items-center mb-3">
            <img src="{{ $user->avatar == '' ? '/storage/avatars/default-avatar.png' : '/storage/'.$user->avatar }}"
                 alt="user avatar"
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
        <form action="{{ route('admin.users.update', $user->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-6">
                    <label for="name" class="form-label">{{ __('titles.name') }}:</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                           value="{{ old('name', $user->name) }}" autofocus required>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="avatar" class="form-label">{{ __('titles.avatar') }}:</label>
                    <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar"
                           name="avatar" autofocus>
                    @error('avatar')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-6">
                    <label for="phone" class="form-label">{{ __('titles.phone') }}:</label>
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone"
                           name="phone" value="{{ old('phone', $user->phone) }}" autofocus required>
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="superuser" class="form-label">{{ __('titles.is_admin') }}؟</label>
                    <select name="superuser" id="superuser"
                            class="form-select @error('superuser') is-invalid @enderror">
                        <option value="0" @if(!$user->superuser) selected @endif>{{ __('titles.no') }}</option>
                        <option value="1" @if($user->superuser) selected @endif>{{ __('titles.yes') }}</option>
                    </select>
                    @error('superuser')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-6">
                    <label for="coin" class="form-label">{{ __('titles.coin') }}:</label>
                    <input type="number" class="form-control @error('coin') is-invalid @enderror" id="coin" name="coin"
                           value="{{ old('coin', $user->coin) }}" autofocus required>
                    @error('coin')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="score" class="form-label">{{ __('titles.score') }}:</label>
                    <input type="number" class="form-control @error('score') is-invalid @enderror" id="score" name="score"
                           value="{{ old('score', $user->score) }}" autofocus required>
                    @error('score')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-success mt-4">{{ __('titles.edit_user') }}</button>
        </form>
    </div>
@endsection
