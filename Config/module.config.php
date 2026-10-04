<?php

/**
 * Module configuration container
 */

return [
    'name' => 'Reviews',
    'description' => 'Reviews module allows you to make a guest book on your site',
    'menu' => [
        'name' => 'Reviews',
        'icon' => 'fas fa-frown-open',
        'items' => [
            [
                'route' => 'Reviews:Admin:Review@indexAction',
                'name' => 'View all reviews'
            ],
            [
                'route' => 'Reviews:Admin:Review@addAction',
                'name' => 'Add new review'
            ],
            [
                'route' => 'Reviews:Admin:Config@indexAction',
                'name' => 'Configuration'
            ]
        ]
    ]
];