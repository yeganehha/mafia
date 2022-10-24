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
    <div class="row w-100 text-center d-flex justify-content-center align-items-center m-0">
        @if($room)
            <x-room-info :member="$member" :room="$room"></x-room-info>
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
