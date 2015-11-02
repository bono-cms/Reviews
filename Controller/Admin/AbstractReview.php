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

abstract class AbstractReview extends AbstractController
{
    /**
     * Returns configured form validator
     * 
     * @param array $input Raw input data
     * @return \Krystal\Validate\ValidatorChain
     */
    final protected function getValidator(array $input)
    {
        return $this->validatorFactory->build(array(
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

    /**
     * Returns template path
     * 
     * @return string
     */
    final protected function getTemplatePath()
    {
        return 'review.form';
    }

    /**
     * Loads shared plug-ins
     * 
     * @return void
     */
    final protected function loadSharedPlugins()
    {
        $this->view->getPluginBag()
                   ->appendScript('@Reviews/admin/review.form.js')
                   ->load(array($this->getWysiwygPluginName(), 'datepicker'));
    }

    /**
     * Loads breadcrumbs
     * 
     * @param string $title
     * @return void
     */
    final protected function loadBreadcrumbs($title)
    {
        $this->view->getBreadcrumbBag()->addOne('Reviews', 'Reviews:Admin:Browser@indexAction')
                                       ->addOne($title);
    }

    /**
     * Returns request container
     * 
     * @return array
     */
    final protected function getContainer()
    {
        return array_merge(array('ip' => $this->request->getClientIp()), $this->request->getPost('review'));
    }

    /**
     * Returns review manager
     * 
     * @return \Reviews\Service\ReviewsManager
     */
    final protected function getReviewsManager()
    {
        return $this->getModuleService('reviewsManager');
    }
}
