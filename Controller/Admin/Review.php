<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Reviews\Controller\Admin;

use Cms\Controller\Admin\AbstractController;
use Krystal\Validate\Pattern;
use Krystal\Stdlib\VirtualEntity;

final class Review extends AbstractController
{
    /**
     * Creates a form
     * 
     * @param \Krystal\Stdlib\VirtualEntity $review
     * @param string $title
     * @return string
     */
    private function createForm(VirtualEntity $review, $title)
    {
        // Load view plugins
        $this->view->getPluginBag()
                   ->appendScript('@Reviews/admin/review.form.js')
                   ->load(array($this->getWysiwygPluginName(), 'datepicker'));

        // Append breadcrumb
        $this->view->getBreadcrumbBag()->addOne('Reviews', 'Reviews:Admin:Review@gridAction')
                                       ->addOne($title);

        return $this->view->render('review.form', array(
            'dateFormat' => $this->getModuleService('reviewsManager')->getTimeFormat(),
            'review' => $review
        ));
    }

    /**
     * Renders empty form
     * 
     * @return string
     */
    public function addAction()
    {
        $review = new VirtualEntity();
        $review->setPublished(true)
               ->setTimestamp(time());

        return $this->createForm($review, 'Add new review');
    }
    
    /**
     * Renders edit form
     * 
     * @param string $id
     * @return string
     */
    public function editAction($id)
    {
        $review = $this->getModuleService('reviewsManager')->fetchById($id);

        if ($review !== false) {
            return $this->createForm($review, 'Edit the review');
        } else {
            return false;
        }
    }

    /**
     * Renders a grid
     * 
     * @param string $page Current page
     * @return string
     */
    public function gridAction($page = 1)
    {
        // Load view plugins
        $this->view->getPluginBag()
                   ->appendScript('@Reviews/admin/browser.js');

        // Append a breadcrumb
        $this->view->getBreadcrumbBag()
                   ->addOne('Reviews');
        
        $reviewsManager = $this->getModuleService('reviewsManager');

        $paginator = $reviewsManager->getPaginator();
        $paginator->setUrl('/admin/module/reviews/page/(:var)');

        return $this->view->render('browser', array(
            'dateFormat' => $reviewsManager->getTimeFormat(),
            'reviews'   => $reviewsManager->fetchAllByPage($page, $this->getSharedPerPageCount(), false),
            'paginator' => $paginator
        ));
    }

    /**
     * Save changes on table form
     * 
     * @return string
     */
    public function tweakAction()
    {
        if ($this->request->hasPost('published')) {
            $published = $this->request->getPost('published');

            // Grab the service
            $reviewsManager = $this->getModuleService('reviewsManager');
            $reviewsManager->updatePublished($published);

            $this->flashBag->set('success', 'Settings have been successfully saved');
            return '1';
        }
    }

    /**
     * Removes a review by its associated id
     * 
     * @return string
     */
    public function deleteAction()
    {
        return $this->invokeRemoval('reviewsManager');
    }

    /**
     * Persists a review
     * 
     * @return string
     */
    public function saveAction()
    {
        $input = $this->request->getPost('review');
        $data = array_merge(array('ip' => $this->request->getClientIp()), $input);

        return $this->invokeSave('reviewsManager', $input['id'], $data, array(
            'input' => array(
                'source' => $input,
                'definition' => array(
                    'name' => new Pattern\Name(),
                    'email' => new Pattern\Email(),
                    'review' => new Pattern\Content(),
                )
            )
        ));
    }
}
