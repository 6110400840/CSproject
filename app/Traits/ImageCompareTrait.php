<?php

namespace App\Traits;

trait ImageCompareTrait {

    public function compareImage($localImageName, $localImagePath, $requestImage)
    {
        // $name = $request->file('image')->getClientOriginalName();
        // $path = storage_path().'/app/public/images/cat.png';
        
        $localImage = file_get_contents($localImagePath);
        $requestImage = file_get_contents($requestImage);
        $localImage_base64 = base64_encode($localImage);
        $requestImage_base64 = base64_encode($requestImage);

        return $localImage_base64 == $requestImage_base64;
    }
}