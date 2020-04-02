<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Reviews\Storage\MySQL;

use Cms\Storage\MySQL\AbstractMapper;
use Reviews\Storage\ReviewsMapperInterface;

final class ReviewsMapper extends AbstractMapper implements ReviewsMapperInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getTableName()
    {
        return self::getWithPrefix('bono_module_reviews');
    }

    /**
     * Fetches review author's name by associated id
     * 
     * @param string $id
     * @return string
     */
    public function fetchNameById($id)
    {
        return $this->findColumnByPk($id, 'name');
    }

    /**
     * Updates review published state by its associated id
     * 
     * @param string $id Review id
     * @param string $published Either 0 or 1
     * @return boolean
     */
    public function updatePublishedById($id, $published)
    {
        $data = array(
            'published' => $published,
            'id' => $id
        );

        return $this->persist($data);
    }

    /**
     * Fetches all published reviews filtered by pagination
     * 
     * @param boolean $published Whether to fetch only published ones
     * @param integer $page Current page
     * @param integer $limit Per page count
     * @return array
     */
    public function fetchAll($published, $page, $limit)
    {
        $db = $this->db->select('*')
                       ->from(self::getTableName());

        if ($published === true) {
            $db->andWhereEquals('published', '1')
               ->orderBy(array(
                    'timestamp' => 'DESC', 
                    'id' => 'DESC'
               ));
        } else {
            $db->orderBy('id')
               ->desc();
        }

        // Apply pagination if required
        if ($page !== null && $limit !== null) {
            $db->paginate($page, $limit);
        }

        return $db->queryAll();
    }
}
