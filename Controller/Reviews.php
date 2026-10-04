<?php

/**
 * This file is part of the Bono CMS
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Reviews\Controller;

use Site\Controller\AbstractController;

final class Reviews extends AbstractController
{
    /**
     * Shows reviews
     *
     * @param string $id Page id
     * @param string $pageNumber Page id
     * @param string $code Language code
     * @param string $slug Page slug
     * @return string
     */
    public function indexAction($id = false, $pageNumber = 1, $code = null, $slug = null)
    {
        if ($this->request->isPost()) {
            return $this->submitAction();
        } else {
            return $this->showAction($id, $pageNumber, $code, $slug);
        }
    }

    /**
     * Shows a web-page with reviews
     * 
     * @param string $id Page id
     * @param string $pageNumber Page id
     * @param string $code Language code
     * @param string $slug Page slug
     * @return string
     */
    private function showAction($id, $pageNumber, $code, $slug)
    {
        $pageManager = $this->getService('Pages', 'pageManager');
        $page = $pageManager->fetchById($id);

        if ($page !== false) {
            // Prepare view
            $this->loadSitePlugins();
            $this->view->getBreadcrumbBag()
                       ->addOne($page->getName());

            $reviewManager = $this->getModuleService('reviewsManager');
            $reviews = $reviewManager->fetchAll(true, $pageNumber, $this->getConfig()->getPerPageCount());

            $paginator = $reviewManager->getPaginator();
            $this->preparePaginator($paginator, $code, $slug, $pageNumber);

            return $this->view->render('reviews', [
                'reviews' => $reviews,
                'paginator' => $paginator,
                'page' => $page,
                'languages' => $pageManager->getSwitchUrls($id, 'Reviews:Reviews@indexAction')
            ]);

        } else {
            return false;
        }
    }

    /**
     * Adds a review by the user
     * 
     * @return string
     */
    private function submitAction()
    {
        $input = $this->request->getPost();

        $validator = $this->createValidation();

        $validator->field('name')
                  ->required();

        $validator->field('email')
                  ->required()
                  ->addRule('email');

        $validator->field('review')
                  ->required();

        $validator->field('captcha')
                  ->required()
                  ->addRule('captcha', null, ['expected' => $this->captcha->getAnswer()]);

        if ($validator->isPassed()) {
            // Summary data to be sent
            $data = array_merge($input, ['ip' => $this->request->getClientIP()]);

            // Defines whether must be published or not
            $published = (bool) $this->getConfig()->getEnabledModeration();

            // If moderation isn't enabled, then send a message
            if ($published) {
                $this->sendMessage($input);
            } else {
                // The moderation is disabled, so we have to notify manually
                $notificationManager = $this->getService('Cms', 'notificationManager');
                $notificationManager->notify('You have received a new review');
            }

            if ($this->getModuleService('reviewsManager')->send($data, $published)) {
                $this->flashBag->set('success', 'Your review has been sent! Thank you');
            }

            return $this->json([
                'refresh' => true
            ]);

        } else {
            return $this->json([
                'errors' => $validator->getErrors()
            ]);
        }
    }

    /**
     * Sends a message from the input
     * 
     * @param array $input Raw input data
     * @return boolean
     */
    private function sendMessage(array $input)
    {
        // Render the body firstly
        $message = $this->view->renderRaw($this->moduleName, 'messages', 'notification', [
            'input' => $input
        ]);

        // Prepare a subject
        $subject = $this->translator->translate('You have received a new review from %s', $input['name']);

        // Grab mailer service
        $mailer = $this->getService('Cms', 'mailer');
        return $mailer->send($subject, $message, 'A new review waits for your approval');
    }

    /**
     * Returns configuration entity
     * 
     * @return \Krystal\Stdlib\VirtualEntity
     */
    private function getConfig()
    {
        return $this->getModuleService('configManager')->getEntity();
    }
}
