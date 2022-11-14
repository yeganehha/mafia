@extends('admin.layouts.master')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('titles.add_user') }}</h1>
        <a href="{{ route('admin.package.index') }}" class="btn btn-secondary btn-sm">{{ __('titles.back') }}</a>
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
        <form action="{{ route('admin.package.store') }}" method="post" enctype="multipart/form-data" class="mb-5">
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
                    <label for="image" class="form-label">{{ __('titles.image') }}:</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                           name="image" autofocus>
                    @error('image')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <label for="description" class="form-label">{{ __('titles.description') }}:</label>
                    <textarea name="description" id="description" rows="5"
                              class="form-control @error('description') is-invalid @enderror"></textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-6">
                    <label for="activation" class="form-label">{{ __('titles.activation') }}:</label>
                    <input type="datetime-local" class="form-control @error('activation') is-invalid @enderror"
                           id="activation" name="activation"
                           autofocus required>
                    @error('activation')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="deactivation" class="form-label">{{ __('titles.deactivation') }}:</label>
                    <input type="datetime-local" class="form-control @error('deactivation') is-invalid @enderror"
                           id="deactivation"
                           name="deactivation" autofocus required>
                    @error('deactivation')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-6">
                    <label for="coins" class="form-label">{{ __('titles.coins') }}:</label>
                    <input type="number" class="form-control @error('coins') is-invalid @enderror" id="coins"
                           name="coins"
                           autofocus required>
                    @error('coins')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="count" class="form-label">{{ __('titles.count') }}:</label>
                    <input type="number" class="form-control @error('count') is-invalid @enderror" id="count"
                           name="count" autofocus required>
                    @error('count')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-6">
                    <label for="price" class="form-label">{{ __('titles.price') }}:</label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                           name="price"
                           autofocus required>
                    @error('price')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="counted_price" class="form-label">{{ __('titles.counted_price') }}:</label>
                    <input type="number" class="form-control @error('counted_price') is-invalid @enderror"
                           id="counted_price"
                           name="counted_price" autofocus required>
                    @error('counted_price')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-success mt-4 mb-5">{{ __('titles.add_package') }}</button>
        </form>
    </div>
@endsection
