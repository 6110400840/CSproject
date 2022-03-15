<?php

namespace App\Traits;

trait ImageTrait {

    public function uploads($image, $name)
    {
        if($image) {
            
            $image_name  = $image->getClientOriginalName();
            $image_path  = $image->storeAs('challenges/'.$name, $image_name, 'public');
            $image_size  = $this->imageSize($image);

            return $image = [
                'imageName' => $image_name,
                'imageType' => $image_type,
                'imagePath' => $image_path,
                'imageSize' => $image_size
            ];
        }
    }

    public function imageSize($image, $precision = 2)
    {
        $size = $image->getSize();

        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        }

        return $size;
    }
}