<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Package\CreateRequest;
use App\Http\Requests\Admin\Package\EditRequest;
use App\Models\Package;
use App\Services\Admin\Packages\PackageService;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $packages = Package::query();

        if ($keyword = request('search')) {
            $packages->where('name', 'LIKE', "%{$keyword}%");
        }

        $packages = $packages->paginate(10);

        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(CreateRequest $request, PackageService $packageService)
    {
        $validData = $request->all();

        if (isset($validData['image']))
            $validData['image'] = $packageService->saveImage($validData['image']);

        $packageService->createPackage($validData);

        return redirect(route('admin.package.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $package = Package::findById($id);

        return view('admin.packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Routing\Redirector
     */
    public function update(EditRequest $request, $id, PackageService $packageService)
    {
        $validData = $request->all();

        $package = Package::findById($id);

        if (isset($validData['image']))
            $validData['image'] = $packageService->saveImage($validData['image']);

        $packageService->updatePackage($package, $validData);

        return redirect(route('admin.package.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Package::findById($id)->delete();

        return redirect(route('admin.package.index'));
    }
}
