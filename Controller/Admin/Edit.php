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

final class Edit extends AbstractReview
{
    /**
     * Shows edit form
     * 
     * @param string $id Reviews id
     * @return string
     */
    public function indexAction($id)
    {
        $review = $this->getReviewsManager()->fetchById($id);

        if ($review !== false) {
            $this->loadSharedPlugins();

            return $this->view->render($this->getTemplatePath(), $this->getWithSharedVars(array(
                'title' => 'Edit the review',
                'review' => $review
            )));

        } else {
            return false;
        }
    }

    /**
     * Updates a review
     * 
     * @return string
     */
    public function updateAction()
    {
        $formValidator = $this->getValidator($this->request->getPost('review'));

        if ($formValidator->isValid()) {

            if ($this->getReviewsManager()->update($this->getContainer())) {
                $this->flashBag->set('success', 'The review has been updated successfully');
                return '1';
            }

        } else {

            return $formValidator->getErrors();
        }
    }
}
