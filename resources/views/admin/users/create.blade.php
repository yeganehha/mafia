@extends('admin.layouts.master')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('titles.add_user') }}</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">{{ __('titles.back') }}</a>
    </div>

    <div class="row">
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    <ul class="list-group">
                        <li>{{ $error }}</li>
                    </ul>
                </div>
            @endforeach
        @endif
        <form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-6">
                    <label for="name" class="form-label">{{ __('titles.name') }}:</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                           autofocus required>
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
                           name="phone" autofocus required>
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
                        <option value="0">{{ __('titles.no') }}</option>
                        <option value="1">{{ __('titles.yes') }}</option>
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
                           autofocus>
                    @error('coin')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="score" class="form-label">{{ __('titles.score') }}:</label>
                    <input type="number" class="form-control @error('score') is-invalid @enderror" id="score"
                           name="score" autofocus>
                    @error('score')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-success mt-4">{{ __('titles.add_user') }}</button>
        </form>
    </div>
@endsection
