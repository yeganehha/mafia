<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $packages = Package::findActivePackage();
        return view('packages.index', compact('packages'));
    }
}
