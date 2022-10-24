@extends('admin.layouts.master')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">کاربران</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm">افزودن</a>
    </div>

    <div class="row">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th scope="col">ایدی</th>
                <th scope="col">نام</th>
                <th scope="col">شماره تلفن</th>
                <th scope="col">سکه</th>
                <th scope="col">امتیاز</th>
                <th scope="col">ادمین</th>
                <th scope="col">عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->coin }}</td>
                    <td>{{ $user->score }}</td>
                    <td>
                        @if($user->superuser)
                            <p class="badge badge-success badge-pill">بله</p>
                        @else
                            <p class="badge badge-danger badge-pill">خیر</p>
                        @endif
                    </td>
                    <td>
                        <div class="w-50 d-flex justify-content-around">
                            <a href="{{ route('admin.users.edit', $user->id) }}"
                               class="btn btn-primary btn-sm">ویرایش</a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">حذف</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">{{ $users->links() }}</div>
@endsection
