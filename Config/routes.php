<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

return [
    '/module/reviews' => [
        'controller' => 'Reviews@indexAction'
    ],

    '/%s/module/reviews/config' => [
        'controller' => 'Admin:Config@indexAction'
    ],

    '/%s/module/reviews/config.ajax' => [
        'controller' => 'Admin:Config@saveAction',
        'disallow' => ['guest']
    ],

    '/%s/module/reviews' => [
        'controller' => 'Admin:Review@indexAction'
    ],

    '/%s/module/reviews/tweak' => [
        'controller' => 'Admin:Review@tweakAction',
        'disallow' => ['guest']
    ],

    '/%s/module/reviews/add' => [
        'controller' => 'Admin:Review@addAction'
    ],

    '/%s/module/reviews/edit/(:var)' => [
        'controller' => 'Admin:Review@editAction'
    ],

    '/%s/module/reviews/save' => [
        'controller' => 'Admin:Review@saveAction',
        'disallow' => ['guest']
    ],

    '/%s/module/reviews/delete/(:var)' => [
        'controller' => 'Admin:Review@deleteAction',
        'disallow' => ['guest']
    ]
];