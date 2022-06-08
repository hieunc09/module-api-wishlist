<?php

namespace Zanui\ApiWishlist\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Zanui\ApiWishlist\Api\Data\WishlistItemsAddInterface;

class WishlistItemsAdd extends AbstractExtensibleModel implements WishlistItemsAddInterface
{

    /**
     * {@inheritdoc}
     */
    public function getItems()
    {
        return $this->getData(self::ITEMS);
    }

    /**
     * {@inheritdoc}
     */
    public function setItems($items)
    {
        return $this->setData(self::ITEMS, $items);
    }

    /**
     * {@inheritdoc}
     */
    public function getWishlistId()
    {
        return $this->getData(self::WISHLIST_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setWishlistId($id)
    {
        return $this->setData(self::WISHLIST_ID, $id);
    }
}
