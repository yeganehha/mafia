@extends('admin.layouts.master')

@section('css')
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endsection

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('titles.setting') }}</h1>
    </div>

    <div class="row">
        <form action="{{ route('admin.setting') }}" method="post">
            @csrf
            <div class="row">
                @foreach($settings as $setting)
                    @if($setting->name == 'can_buy_coin')
                        <div class="custom-control custom-switch col-6 mb-4">
                            <input type="checkbox" class="custom-control-input" id="customSwitch1"
                                   name="{{ $setting->name }}" @if($setting->value) checked @endif>
                            <label class="custom-control-label"
                                   for="customSwitch1">{{ __("titles.$setting->name") }}</label>
                        </div>
                    @else
                        <div class="col-6 mb-4">
                            <label for="{{ $setting->name }}" class="form-label">{{ __("titles.$setting->name") }}
                                :</label>
                            <input type="number" class="form-control @error("$setting->name") is-invalid @enderror"
                                   id="{{ $setting->name }}"
                                   name="{{ $setting->name }}"
                                   value="{{ $setting->value }}" required>
                            @error("$setting->name")
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    @endif
                @endforeach
            </div>
            <button type="submit" class="btn btn-success">{{ __('titles.edit') }}</button>
        </form>
    </div>
@endsection
