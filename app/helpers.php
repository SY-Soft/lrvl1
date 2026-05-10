<?php

use App\Services\ImageStyleService;

if (!function_exists('image_style')) {
    function image_style($path, $style)
    {
        return app(ImageStyleService::class)
            ->getStyledImage($path, $style);
    }
}
