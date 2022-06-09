<?php

namespace Zanui\ApiWishlist\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Zanui\ApiWishlist\Api\Data\WishlistItemInterface;

class WishlistItem extends AbstractExtensibleModel implements WishlistItemInterface
{

    /**
     * {@inheritdoc}
     */
    public function getItemId()
    {
        return $this->getData(self::ITEM_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setItemId($itemId)
    {
        return $this->setData(self::ITEM_ID, $itemId);
    }

    /**
     * {@inheritdoc}
     */
    public function getQuantity()
    {
        return $this->getData(self::QUANTITY);
    }

    /**
     * {@inheritdoc}
     */
    public function setQuantity($qty)
    {
        return $this->setData(self::QUANTITY, $qty);
    }

    /**
     * {@inheritdoc}
     */
    public function getImageUrl()
    {
        return $this->getData(self::IMAGE_URL);
    }

    /**
     * {@inheritdoc}
     */
    public function setImageUrl($imageUrl)
    {
        return $this->setData(self::IMAGE_URL, $imageUrl);
    }

    /**
     * {@inheritdoc}
     */
    public function getProduct()
    {
        return $this->getData(self::PRODUCT);
    }

    /**
     * {@inheritdoc}
     */
    public function setProduct(\Magento\Catalog\Api\Data\ProductInterface $product)
    {
        return $this->setData(self::PRODUCT, $product);
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
        \Zanui\ApiWishlist\Api\Data\WishlistItemExtensionInterface $extensionAttributes
    )
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
