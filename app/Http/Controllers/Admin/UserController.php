<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\CreateRequest;
use App\Models\User;
use App\Services\Admin\Users\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = User::query();

        if ($keyword = request('search')) {
            $users->where('phone', 'LIKE', "%{$keyword}%")->orWhere('name', 'LIKE', "%{$keyword}%");
        }

        $users = $users->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(CreateRequest $request, UserService $userService)
    {
        $validDate = $request->all();

        $userService->createUser($validDate);

        return redirect(route('admin.users.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Routing\Redirector
     */
    public function update(CreateRequest $request, $id, UserService $userService)
    {
        $validDate = $request->all();

        $user = User::find($id);

        $userService->updateUser($user, $validDate);

        return redirect(route('admin.users.index'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function activate($id)
    {
        User::find($id)->updateUser(['active' => 1]);
        return redirect()->back();
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function deactivate($id)
    {
        User::find($id)->updateUser(['active' => 0]);
        return redirect()->back();
    }
}
