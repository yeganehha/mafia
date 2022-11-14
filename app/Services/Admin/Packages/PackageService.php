<?php

namespace App\Services\Admin\Packages;

use App\Models\Package;
use Illuminate\Support\Facades\Storage;

class PackageService
{

    public function saveImage($image)
    {
        $imageName = Storage::disk('public')->putFile('packages', $image);
        return $imageName;
    }

    public function createPackage($data)
    {
        $package = new Package();
        return $package->createPackage($data);
    }

    public function updatePackage($package, $data)
    {
        $package->updatePackage($data);
    }
}
