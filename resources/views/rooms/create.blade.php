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
    <form action="{{ route('rooms.create') }}" method="POST" class="w-75">
        @csrf
        <div class="row mb-3">
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

        <div class="col mb-3 d-flex flex-column">
            <div class="d-flex">
                <input id="createPrivate" type="checkbox"
                       class="form-check-input @error('type') is-invalid @enderror mt-2"
                       name="createPrivate">&nbsp;
                <label for="createPrivate" class="text-light form-check-label mt-1">
                    {{ __('titles.create_private_room') }} ({{ __('titles.private_cost') }})
                </label>
                @error('createPrivate')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>
        </div>

        <div id="privateBox">
            <div class="row mb-3">
                <div class="col mb-3 d-flex flex-column">
                    <label for="show-link-input" class="text-muted form-label">{{ __('titles.link_input') }}:</label>
                    <div class="d-flex">
                        <input id="show-link-input" type="checkbox"
                               class="form-check-input @error('type') is-invalid @enderror mt-2"
                               name="showLinkInput">&nbsp;
                        <label for="show-link-input" class="text-light form-check-label mt-1">
                            {{ __('messages.custom_link') }}
                        </label>
                        @error('show-link-input')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col mb-3" id="custom-link-box">
                    <label for="custom-link" class="text-muted">{{ __('titles.custom_link') }}:</label>
                    <input id="custom-link" type="text" dir="ltr"
                           class="border-secondary bg-dark text-light form-control @error('custom-link') is-invalid @enderror mt-2"
                           name="customLink" value="{{ old('custom-link') }}" autocomplete="custom-link">
                    <p class="text-warning mt-2" dir="ltr" id="resultURL"></p>
                    @error('custom-link')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col mb-3 d-flex flex-column">
                    <label for="show-pass-input" class="text-muted form-label">{{ __('titles.pass_input') }}:</label>
                    <div class="d-flex">
                        <input id="show-pass-input" type="checkbox"
                               class="form-check-input @error('type') is-invalid @enderror mt-2"
                               name="showPassInput">&nbsp;
                        <label for="show-pass-input" class="text-light form-check-label mt-1">
                            {{ __('messages.custom_pass') }}
                        </label>
                        @error('show-pass-input')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col mb-3" id="pass-box">
                    <label for="pass-input" class="text-muted">{{ __('titles.custom_pass') }}:</label>
                    <input id="pass-input" type="text" dir="ltr"
                           class="border-secondary bg-dark text-light form-control @error('pass-input') is-invalid @enderror mt-2"
                           name="passInput" value="{{ old('pass-input','') }}" autocomplete="pass-input">
                    @error('pass-input')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col mb-3 d-flex flex-column">
                    <label for="join-request" class="text-muted form-label">{{ __('titles.join_request') }}:</label>
                    <div class="d-flex">
                        <input id="join-request" type="checkbox"
                               class="form-check-input @error('type') is-invalid @enderror mt-2"
                               name="joinRequest" value="1">&nbsp;
                        <label for="join-request" class="text-light form-check-label mt-1">
                            {{ __('messages.join_request') }}
                        </label>
                        @error('join-request')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success">{{ __('titles.create_room') }}</button>
    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#custom-link-box').hide();
            $('#pass-box').hide();
            $('#privateBox').hide();

            // Custom link input
            $('#show-link-input').click(function () {
                if ($(this).prop('checked')) {
                    $('#custom-link-box').fadeIn();
                } else {
                    $('#custom-link-box').fadeOut();
                    $('#custom-link').val('');
                    $('#resultURL').text('');
                }
            });

            $('#custom-link').on('input', function () {
                $('#resultURL').text('https://' + document.domain + '/room/private/' + $(this).val())
            });

            // password input
            $('#show-pass-input').click(function () {
                if ($(this).prop('checked')) {
                    $('#pass-box').fadeIn();
                } else {
                    $('#pass-box').fadeOut();
                    $('#pass-input').val('');
                }
            });

            $('#createPrivate').click(function () {
                if ($(this).prop('checked')) {
                    $('#privateBox').fadeIn();
                } else {
                    $('#privateBox').fadeOut();
                }
            });
        });
    </script>
@endsection
