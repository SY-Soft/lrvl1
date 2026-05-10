<?php

return [

    'small' => [
        'width' => 300,
        'height' => 200,
        'fit' => true,
    ],

    'medium' => [
        'width' => 800,
        'height' => 600,
        'fit' => false,
    ],

    'square_center' => [
        'width' => 300,
        'height' => 300,

        // внутренняя зона под изображение
        'inner_width' => 296,
        'inner_height' => 296,

        'mode' => 'canvas',
        'background' => 'ffffff',

        // рамка
        'border_color' => 'c5c5c5',
    ],

];
