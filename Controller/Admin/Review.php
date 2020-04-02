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
        $this->view->getBreadcrumbBag()->addOne('Reviews', 'Reviews:Admin:Review@indexAction')
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
            return $this->createForm($review, $this->translator->translate('Edit the review from "%s"', $review->getName()));
        } else {
            return false;
        }
    }

    /**
     * Renders a grid
     * 
     * @return string
     */
    public function indexAction()
    {
        // Current page
        $page = $this->request->getQuery('page', 1);

        // Append a breadcrumb
        $this->view->getBreadcrumbBag()
                   ->addOne('Reviews');

        $reviewsManager = $this->getModuleService('reviewsManager');

        return $this->view->render('index', array(
            'dateFormat' => $reviewsManager->getTimeFormat(),
            'reviews'   => $reviewsManager->fetchAll(false, $page, $this->getSharedPerPageCount()),
            'paginator' => $reviewsManager->getPaginator()
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
     * @param string $id
     * @return string
     */
    public function deleteAction($id)
    {
        $service = $this->getModuleService('reviewsManager');
        $historyService = $this->getService('Cms', 'historyManager');

        // Batch removal
        if ($this->request->hasPost('batch')) {
            $ids = array_keys($this->request->getPost('batch'));

            $service->deleteByIds($ids);
            $this->flashBag->set('success', 'Selected elements have been removed successfully');

            // Save in the history
            $historyService->write('Reviews', 'Batch removal of %s reviews', count($ids));

        } else {
            $this->flashBag->set('warning', 'You should select at least one element to remove');
        }

        // Single removal
        if (!empty($id)) {
            $review = $this->getModuleService('reviewsManager')->fetchById($id);

            $service->deleteById($id);
            $this->flashBag->set('success', 'Selected element has been removed successfully');

            // Save in the history
            $historyService->write('Reviews', 'A review by "%s" has been removed', $review->getName());
        }

        return '1';
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

        $formValidator = $this->createValidator(array(
            'input' => array(
                'source' => $input,
                'definition' => array(
                    'name' => new Pattern\Name(),
                    'email' => new Pattern\Email(),
                    'review' => new Pattern\Content(),
                )
            )
        ));

        if ($formValidator->isValid()) {
            $service = $this->getModuleService('reviewsManager');
            $historyService = $this->getService('Cms', 'historyManager');

            $service->save($data);

            if (!empty($input['id'])) {
                $this->flashBag->set('success', 'The element has been updated successfully');

                $historyService->write('Reviews', 'A review by "%s" has been updated', $input['name']);
                return '1';

            } else {
                $this->flashBag->set('success', 'The element has been created successfully');

                $historyService->write('Reviews', 'A new review by "%s" has been added', $input['name']);
                return $service->getLastId();
            }

        } else {
            return $formValidator->getErrors();
        }
    }
}
