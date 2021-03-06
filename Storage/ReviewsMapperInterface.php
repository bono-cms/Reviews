<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Reviews\Storage;

interface ReviewsMapperInterface
{
    /**
     * Fetches review author's name by associated id
     * 
     * @param string $id
     * @return string
     */
    public function fetchNameById($id);

    /**
     * Updates review published state by its associated id
     * 
     * @param string $id Review id
     * @param string $published Either 0 or 1
     * @return boolean
     */
    public function updatePublishedById($id, $published);

    /**
     * Fetches all published reviews filtered by pagination
     * 
     * @param boolean $published Whether to fetch only published ones
     * @param integer $page Current page
     * @param integer $limit Per page count
     * @return array
     */
    public function fetchAll($published, $page, $limit);
}
