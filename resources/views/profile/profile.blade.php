@extends('profile.app')

@section('css')
    <style>
        .list-unstyled:hover {
            background: #101113;
        }

        .nav-link.active {
            background: #101113;
        }

        .cd-35 .card-header {
            background: linear-gradient(
                135deg,
                rgba(82, 11, 173, 1) 0%,
                rgba(71, 205, 238, 1) 100%
            );
            min-height: 60px;
        }
    </style>
@endsection

@section('card')
    <div class="row mx-auto">
        <div class="card p-0 rounded-5 border-0 shadow-lg cd-35 mx-auto mb-5" style="width: 18rem;">
            <div class="card-header border-0 p-0 d-flex align-items-center justify-content-center bg-dark">
                <i class="fas fa-sack-dollar text-warning display-6"></i>
            </div>
            <div class="card-body text-center bg-dark pb-0">
                <h5 class="pb-2">{{ __('titles.coin') }}</h5>
                <p>{{ $user->coin }}</p>
            </div>
        </div>
        <div class="card p-0 rounded-5 border-0 shadow-lg cd-35 mx-auto mb-5" style="width: 18rem;">
            <div class="card-header border-0 p-0 d-flex align-items-center justify-content-center bg-dark">
                <i class="fas fa-star text-warning display-6"></i>
            </div>
            <div class="card-body text-center bg-dark pb-0">
                <h5 class="pb-2">{{ __('titles.score') }}</h5>
                <p>{{ $user->score }}</p>
            </div>
        </div>
    </div>
@endsection