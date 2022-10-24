<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        $users = User::paginate(10);
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
    public function store(Request $request)
    {
        $validDate = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'superuser' => ['required', 'in:1,0'],
        ]);

        if ($request->avatar) {
            $imgValidated = $request->validate([
                'avatar' => 'file|max:512'
            ]);
            $validDate['avatar'] = "/storage/" . Storage::disk('public')->putFile('avatars', $imgValidated['avatar']);
        } else {
            $validDate['avatar'] = '';
        }

        if ($request->password) {
            $validDate = array_merge($validDate, $request->validate(['password' => 'string']));
        } else {
            $validDate['password'] = Str::random(6);
        }

        User::create($validDate);

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
    public function update(Request $request, $id)
    {
        $validDate = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'superuser' => ['required', 'in:1,0'],
        ]);

        if ($request->avatar) {
            $imgValidated = $request->validate([
                'avatar' => 'file|max:512'
            ]);
            $validDate['avatar'] = "/storage/" . Storage::disk('public')->putFile('avatars', $imgValidated['avatar']);
        }

        if ($request->password) {
            $validDate = array_merge($validDate, $request->validate(['password' => 'string']));
        }

        User::find($id)->update($validDate);

        return redirect(route('admin.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->back();
    }
}
