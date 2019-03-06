<?php

/**
 * Module configuration container
 */

return array(
    'name' => 'Reviews',
    'description' => 'Reviews module allows you to make a guest book on your site',
    'menu' => array(
        'name' => 'Reviews',
        'icon' => 'fas fa-frown-open',
        'items' => array(
            array(
                'route' => 'Reviews:Admin:Review@gridAction',
                'name' => 'View all reviews'
            ),
            array(
                'route' => 'Reviews:Admin:Review@addAction',
                'name' => 'Add new review'
            ),
            array(
                'route' => 'Reviews:Admin:Config@indexAction',
                'name' => 'Configuration'
            )
        )
    )
);