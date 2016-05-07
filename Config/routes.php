<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

return array(
    '/module/reviews' => array(
        'controller' => 'Reviews@indexAction'
    ),
    
    '/%s/module/reviews/config' => array(
        'controller' => 'Admin:Config@indexAction'
    ),
    
    '/%s/module/reviews/config.ajax' => array(
        'controller' => 'Admin:Config@saveAction',
        'disallow' => array('guest')
    ),
    
    '/%s/module/reviews' => array(
        'controller' => 'Admin:Review@gridAction'
    ),
    
    '/%s/module/reviews/tweak' => array(
        'controller' => 'Admin:Review@tweakAction',
        'disallow' => array('guest')
    ),
    
    '/%s/module/reviews/page/(:var)' => array(
        'controller' => 'Admin:Review@gridAction'
    ),
    
    '/%s/module/reviews/add' => array(
        'controller' => 'Admin:Review@addAction'
    ),
    
    '/%s/module/reviews/edit/(:var)' => array(
        'controller' => 'Admin:Review@editAction'
    ),
    
    '/%s/module/reviews/save' => array(
        'controller' => 'Admin:Review@saveAction',
        'disallow' => array('guest')
    ),
    
    '/%s/module/reviews/delete/(:var)' => array(
        'controller' => 'Admin:Review@deleteAction',
        'disallow' => array('guest')
    )
);
