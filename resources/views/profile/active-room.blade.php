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
    <div class="row w-100 text-center d-flex justify-content-center align-items-center">
        @if($room)
            <div class="col text-light">
                <p>{{ __('titles.room_name') }}</p>
                <p>{{ __('titles.room_type') }}</p>
                <p>{{ __('titles.room_model') }}</p>
                <p>{{ __('titles.room_link') }}</p>
                @if($member->is_creator)
                    <p>{{ __('titles.room_pass') }}</p>
                    <p>{{ __('titles.join_request') }}</p>
                @endif
            </div>
            <div class="col text-light">
                <p>{{ $room->name }}</p>
                <p>
                    @switch($room->type)
                        @case('classic')
                            {{ __('titles.classic_room') }}
                            @break
                    @endswitch
                </p>
                <p>
                    @if($room->is_private == 1)
                        {{ __('titles.private_room') }}
                    @else
                        {{ __('titles.public_room') }}
                    @endif
                </p>
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <button onclick="copyContent()" class="far fa-copy ms-4 bg-dark border-0 text-warning"
                            id="copyRoomLink" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="{{ __('titles.copy_link') }}"></button>
                    <small id="roomLink">{{ url(route('rooms.join', ['link'=>$room->link])) }}</small>
                </div>
                @if($member->is_creator)
                    <p>
                        @if($room->password)
                            {{ $room->password }}
                        @else
                            {{ __('titles.no_pass') }}
                        @endif
                    </p>
                    <p>
                        @if($room->join_request)
                            <a href="" class="btn btn-primary">{{ __('titles.show_join_requests') }}</a>
                        @else
                            {{ __('titles.in_active') }}
                        @endif
                    </p>
                @endif
            </div>
            <div class="row">
                <div class="col d-flex justify-content-center align-items-center">
                    <form
                        action="{{ route('rooms.enter', ['link'=>$room->link]) }}"
                        method="POST" class="ms-2 me-2">
                        @csrf
                        <button type="submit"
                                class="btn btn-warning btn-sm">{{ __('titles.enter_room') }}</button>
                    </form>
                    @if($member->is_creator)
                        <form
                            action="{{ route('rooms.delete', ['link'=>$room->link]) }}"
                            method="POST" class="ms-2 me-2">
                            @csrf
                            <button type="submit"
                                    class="btn btn-danger btn-sm">{{ __('titles.delete_room') }}</button>
                        </form>
                    @else
                        <form
                            action="{{ route('rooms.exit', ['link'=>$room->link]) }}"
                            method="POST" class="ms-2 me-2">
                            @csrf
                            <button type="submit"
                                    class="btn btn-danger btn-sm">{{ __('titles.exit_room') }}</button>
                        </form>
                    @endif
                </div>
            </div>
        @else
            <div class="alert alert-warning w-auto">
                {{ __('messages.no_room_for_user') }}
            </div>
            <div class="d-flex w-100 justify-content-center align-items-center">
                <a href="{{ route('rooms.create') }}"
                   class="btn btn-success w-auto ms-2 me-2 btn-sm">{{ __('titles.create_room') }}</a>
            </div>
        @endif
    </div>
@endsection

@section('script')
    <script>
        var tooltipTriggerEl = document.querySelector('[data-bs-toggle="tooltip"]')
        var tooltip = new bootstrap.Tooltip(tooltipTriggerEl)

        let text = document.getElementById('roomLink').innerHTML;

        const copyContent = async () => {
            try {
                await navigator.clipboard.writeText(text);
                toastr.success('کپی شد');
            } catch (err) {
                toastr.error(err)
            }
        }
    </script>
@endsection
