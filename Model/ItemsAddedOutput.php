<?php

namespace Zanui\ApiWishlist\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Zanui\ApiWishlist\Api\Data\ItemsAddedOutputInterface;

class ItemsAddedOutput extends AbstractExtensibleModel implements ItemsAddedOutputInterface
{

    /**
     * {@inheritdoc}
     */
    public function getWishlistItems()
    {
        return $this->getData(self::WISHLIST_ITEMS);
    }

    /**
     * {@inheritdoc}
     */
    public function setWishlistItems($items)
    {
        return $this->setData(self::WISHLIST_ITEMS, $items);
    }

    /**
     * {@inheritdoc}
     */
    public function getUserError()
    {
        return $this->getData(self::USER_ERROR);
    }

    /**
     * {@inheritdoc}
     */
    public function setUserError($error)
    {
        return $this->setData(self::USER_ERROR, $error);
    }
}
