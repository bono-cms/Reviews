<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Reviews;

use Cms\AbstractCmsModule;
use Reviews\Service\ReviewsManager;
use Reviews\Service\SiteService;

final class Module extends AbstractCmsModule
{
    /**
     * {@inheritDoc}
     */
    public function getServiceProviders()
    {
        $reviewsManager = new ReviewsManager($this->getMapper('/Reviews/Storage/MySQL/ReviewsMapper'));

        return array(
            'reviewsManager' => $reviewsManager,
            'configManager' => $this->createConfigService(),
            'siteService' => new SiteService($reviewsManager)
        );
    }
}
