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

use Cms\Service\AbstractManager;
use Cms\Service\HistoryManagerInterface;
use Reviews\Storage\ReviewsMapperInterface;
use Krystal\Stdlib\VirtualEntity;
use Krystal\Stdlib\ArrayUtils;

final class ReviewsManager extends AbstractManager
{
    /**
     * Any mapper that implements this interface
     * 
     * @var \Review\Storage\ReviewsMapperInterface
     */
    private $reviewsMapper;

    /**
     * State initialization
     * 
     * @param \Review\Storage\ReviewsMapperInterface $reviewsMapper
     * @return void
     */
    public function __construct(ReviewsMapperInterface $reviewsMapper)
    {
        $this->reviewsMapper = $reviewsMapper;
    }

    /**
     * {@inheritDoc}
     */
    protected function toEntity(array $review)
    {
        $entity = new VirtualEntity();
        $entity->setId($review['id'], VirtualEntity::FILTER_INT)
               ->setTimestamp($review['timestamp'], VirtualEntity::FILTER_INT)
               ->setIp($review['ip'], VirtualEntity::FILTER_HTML)
               ->setPublished($review['published'], VirtualEntity::FILTER_BOOL)
               ->setName($review['name'], VirtualEntity::FILTER_HTML)
               ->setEmail($review['email'], VirtualEntity::FILTER_HTML)
               ->setReview($review['review'], VirtualEntity::FILTER_SAFE_TAGS);

        return $entity;
    }

    /**
     * Updates published state by their associated ids
     * 
     * @param array $pair
     * @return boolean
     */
    public function updatePublished(array $pair)
    {
        foreach ($pair as $id => $published) {
            if (!$this->reviewsMapper->updatePublishedById($id, $published)) {
                return false;
            }
        }

        return true;
    }
    
    /**
     * Deletes reviews by theirs associated ids
     * 
     * @param array $ids
     * @return boolean
     */
    public function deleteByIds(array $ids)
    {
        foreach ($ids as $id) {
            if (!$this->reviewsMapper->deleteById($id)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Deletes a review by its associated id
     * 
     * @param string $id
     * @return boolean
     */
    public function deleteById($id)
    {
        return $this->reviewsMapper->deleteById($id);
    }

    /**
     * Returns prepared paginator's instance
     * 
     * @return \Krystal\Paginate\Paginator
     */
    public function getPaginator()
    {
        return $this->reviewsMapper->getPaginator();
    }

    /**
     * Returns default time format
     * 
     * @return string
     */
    public function getTimeFormat()
    {
        return 'm/d/Y';
    }

    /**
     * Fetches all reviews filtered pagination
     * 
     * @param integer $page Current page
     * @param integer $itemsPerPage Items to be shown per page
     * @param boolean $published
     * @return array
     */
    public function fetchAllByPage($page, $itemsPerPage, $published)
    {
        return $this->prepareResults($this->reviewsMapper->fetchAllByPage($page, $itemsPerPage, $published));
    }

    /**
     * Returns last id
     * 
     * @return integer
     */
    public function getLastId()
    {
        return $this->reviewsMapper->getLastId();
    }

    /**
     * Fetches a review by its associated id
     * 
     * @param string $id
     * @return array
     */
    public function fetchById($id)
    {
        return $this->prepareResult($this->reviewsMapper->fetchById($id));
    }

    /**
     * Saves the form
     * 
     * @param array $data
     * @return void
     */
    public function save(array $data)
    {
        $data['timestamp'] = strtotime($data['date']);
        $data = ArrayUtils::arrayWithout($data, array('date'));

        return $this->reviewsMapper->persist($data);
    }

    /**
     * Sends data from a user
     * 
     * @param array $input Raw input data
     * @param boolean $enableModeration Whether a review should be moderated or not
     * @return boolean
     */
    public function send(array $input, $enableModeration)
    {
        // Always current timestamp
        $input['timestamp'] = time();

        // This value depends on configuration, where we handled moderation
        if ($enableModeration) {
            $input['published'] = '0';
        } else {
            $input['published'] = '1';
        }

        return $this->reviewsMapper->insert(ArrayUtils::arrayWithout($input, array('captcha')));
    }
}
