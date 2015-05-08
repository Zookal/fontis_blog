<?php

/**
 * Fontis Blog Extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * Parts of this software are derived from code originally developed by
 * Robert Chambers <magento@robertchambers.co.uk>
 * and released as 'Lazzymonk's Blog' 0.5.8 in 2009.
 *
 * @category   Fontis
 * @package    Fontis_Blog
 * @copyright  Copyright (c) 2013 Fontis Pty. Ltd. (http://www.fontis.com.au)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Fontis_Blog_Helper_Cat extends Mage_Core_Helper_Abstract
{
    /**
     * Renders CMS page
     *
     * Call from controller action
     *
     * @param Mage_Core_Controller_Front_Action $action
     * @param null                              $identifier
     *
     * @return bool
     */
    public function renderPage(Mage_Core_Controller_Front_Action $action, $identifier = null)
    {
        if (!$cat_id = Mage::getSingleton('blog/cat')->load($identifier)->getCatId()) {
            return false;
        }

        $action->loadLayout();
        $layout = $action->getLayout();
        if ($storage = Mage::getSingleton('customer/session')) {
            $layout->getMessagesBlock()->addMessages($storage->getMessages(true));
        }
        $blogTitle = Mage::getStoreConfig('fontis_blog/blog/title');
        $pageTitle = Mage::getSingleton('blog/cat')->load($identifier)->getTitle();
        if ($head = $layout->getBlock('head')) {
            $head->setTitle($blogTitle . ' - ' . $pageTitle);
            if (Mage::helper('blog')->isRssEnabled()) {
                $head->addItem('rss', Mage::getUrl(Mage::helper('blog')->getBlogRoute() . '/cat/' . $identifier) . 'rss');
            }
        }
        $layout->getBlock('root')->setTemplate(Mage::getStoreConfig('fontis_blog/blog/layout'));
        $action->renderLayout();

        return true;
    }
}
