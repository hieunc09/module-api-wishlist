<?php

namespace Zanui\ApiWishlist\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Zanui\ApiWishlist\Api\Data\WishlistInterface;

class Wishlist extends AbstractExtensibleModel implements WishlistInterface
{

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
    public function getSharingCode()
    {
        return $this->getData(self::SHARING_CODE);
    }

    /**
     * {@inheritdoc}
     */
    public function setSharingCode($sharingCode)
    {
        return $this->setData(self::SHARING_CODE, $sharingCode);
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * {@inheritdoc}
     */
    public function getItemsCount()
    {
        return $this->getData(self::ITEMS_COUNT);
    }

    /**
     * {@inheritdoc}
     */
    public function setItemsCount($itemsCount)
    {
        return $this->setData(self::ITEMS_COUNT, $itemsCount);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * {@inheritdoc}
     */
    public function setExtensionAttributes(
        \Zanui\ApiWishlist\Api\Data\WishlistExtensionInterface $extensionAttributes
    )
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
