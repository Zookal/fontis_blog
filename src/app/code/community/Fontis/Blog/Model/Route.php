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
class Fontis_Blog_Model_Route extends Mage_Core_Model_Config_Data
{
    public function toOptionArray()
    {
        $options = [];
        return $options;
    }

    protected function _beforeSave()
    {
        $value = $this->getValue();
        if (trim($value) == '') {
            $value = 'blog';
        }
        $this->setValue($value);
        return $this;
    }
}
