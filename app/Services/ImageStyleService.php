<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

// https://image.intervention.io/ - v3
class ImageStyleService
{
    public function getStyledImage(string $path, string $style): string
    {
        $styles = config('image_styles');

        if (!isset($styles[$style])) {
            throw new \Exception("Style {$style} not found");
        }

        $styledPath = "styles/{$style}/{$path}";

        // если derivative уже существует
        if (Storage::disk('public')->exists($styledPath)) {
            return Storage::url($styledPath);
        }

        // если оригинала нет
        if (!Storage::disk('public')->exists($path)) {
            throw new \Exception("Original image not found");
        }

        $manager = new ImageManager(new Driver());

        $image = $manager->read(
            Storage::disk('public')->path($path)
        );

        $config = $styles[$style];

        /*
        |--------------------------------------------------------------------------
        | Canvas mode
        |--------------------------------------------------------------------------
        */
        if (
            isset($config['mode']) &&
            $config['mode'] === 'canvas'
        ) {
            // уменьшаем изображение пропорционально
            $image->scale(
                $config['inner_width'],
                $config['inner_height']
            );

            // внутренний белый холст
            $innerCanvas = $manager->create(
                $config['inner_width'],
                $config['inner_height']
            );

            $innerCanvas->fill(
                $config['background'] ?? 'ffffff'
            );

            // картинка по центру
            $innerCanvas->place($image, 'center');

            // внешний холст = рамка
            $outerCanvas = $manager->create(
                $config['width'],
                $config['height']
            );

            $outerCanvas->fill(
                $config['border_color'] ?? 'c5c5c5'
            );

            // вставляем белый холст в центр
            $outerCanvas->place($innerCanvas, 'center');

            $image = $outerCanvas;
        }

        /*
        |--------------------------------------------------------------------------
        | Cover mode
        |--------------------------------------------------------------------------
        */
        elseif (!empty($config['fit'])) {
            $image->cover(
                $config['width'],
                $config['height']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Resize mode
        |--------------------------------------------------------------------------
        */
        else {
            $image->resize(
                $config['width'],
                $config['height']
            );
        }

        Storage::disk('public')->put(
            $styledPath,
            $image->toJpeg(90)
        );

        return Storage::url($styledPath);
    }
}
