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
    
    '/admin/module/reviews/config' => array(
        'controller' => 'Admin:Config@indexAction'
    ),
    
    '/admin/module/reviews/config.ajax' => array(
        'controller' => 'Admin:Config@saveAction',
        'disallow' => array('guest')
    ),
    
    '/admin/module/reviews' => array(
        'controller' => 'Admin:Browser@indexAction'
    ),
    
    '/admin/module/reviews/save.ajax' => array(
        'controller' => 'Admin:Browser@saveAction',
        'disallow' => array('guest')
    ),
    
    '/admin/module/reviews/page/(:var)' => array(
        'controller' => 'Admin:Browser@indexAction'
    ),
    
    '/admin/module/reviews/add' => array(
        'controller' => 'Admin:Add@indexAction'
    ),
    
    '/admin/module/reviews/add.ajax' => array(
        'controller' => 'Admin:Add@addAction',
        'disallow' => array('guest')
    ),
    
    '/admin/module/reviews/edit/(:var)' => array(
        'controller' => 'Admin:Edit@indexAction'
    ),
    
    '/admin/module/reviews/edit.ajax' => array(
        'controller' => 'Admin:Edit@updateAction',
        'disallow' => array('guest')
    ),
    
    '/admin/module/reviews/delete.ajax' => array(
        'controller' => 'Admin:Browser@deleteAction',
        'disallow' => array('guest')
    ),
    
    '/admin/module/reviews/delete-selected.ajax' => array(
        'controller' => 'Admin:Browser@deleteSelectedAction',
        'disallow' => array('guest')
    )
);
