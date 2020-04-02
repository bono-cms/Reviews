<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Reviews\Service;

final class SiteService
{
    /**
     * Reviews manager
     * 
     * @var \Reviews\Service\ReviewsManager
     */
    private $reviewsManager;

    /**
     * State initialization
     * 
     * @param \Reviews\Service\ReviewsManager $reviewsManager
     * @return void
     */
    public function __construct(ReviewsManager $reviewsManager)
    {
        $this->reviewsManager = $reviewsManager;
    }

    /**
     * Get all published reviews
     * 
     * @return array
     */
    public function getAll()
    {
        return $this->reviewsManager->fetchAll(true, null, null);
    }
}
