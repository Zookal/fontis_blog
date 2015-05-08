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
class Fontis_Blog_Model_Mysql4_Post_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected $_previewFlag;

    protected function _construct()
    {
        $this->_init('blog/post');
    }

    public function addEnableFilter($status)
    {
        $this->getSelect()->where('status = ?', $status);
        return $this;
    }

    public function addCatFilter($catId)
    {
        $this->getSelect()->join(
            ['cat_table' => $this->getTable('post_cat')],
            'main_table.post_id = cat_table.post_id',
            []
        )
            ->where('cat_table.cat_id = ?', $catId);

        return $this;
    }

    protected function _afterLoad()
    {
        /*$items = $this->getColumnValues('post_id');
        if (count($items)) {
            $select = $this->getConnection()->select()
                    ->from($this->getTable('store'))
                    ->where($this->getTable('store').'.post_id IN (?)', $items);
            if ($result = $this->getConnection()->fetchPairs($select)) {
                foreach ($this as $item) {
                    if (!isset($result[$item->getData('post_id')])) {
                        continue;
                    }
                    if ($result[$item->getData('post_id')] == 0) {
                        $storeCode = key(Mage::app()->getStores(false, true));
                    } else {
                        $storeCode = Mage::app()->getStore($result[$item->getData('post_id')])->getCode();
                    }
                    $item->setData('store_code', $storeCode);
                }
            }
        }*/

        if (count($this) > 0) {
            Mage::dispatchEvent('fontis_blog_post_collection_load_after', ['collection' => $this]);
        }

        return parent::_afterLoad();
    }

    public function toOptionArray()
    {
        return $this->_toOptionArray('identifier', 'title');
    }

    public function addStoreFilter($store)
    {
        if (!Mage::app()->isSingleStoreMode()) {
            if ($store instanceof Mage_Core_Model_Store) {
                $store = [$store->getId()];
            }

            $this->getSelect()->join(
                ['store_table' => $this->getTable('store')],
                'main_table.post_id = store_table.post_id',
                []
            )
                ->where('store_table.store_id in (?)', [0, $store]);

            return $this;
        }
        return $this;
    }
}
