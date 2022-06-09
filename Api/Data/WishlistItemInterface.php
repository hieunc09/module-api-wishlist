<?php

namespace Zanui\ApiWishlist\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface WishlistItemInterface extends ExtensibleDataInterface
{
    const ITEM_ID = 'item_id';
    const IMAGE_URL = 'image_url';
    const QUANTITY = 'quantity';
    const PRODUCT = 'product';

    /**
     * Get item id.
     *
     * @return int
     */
    public function getItemId();

    /**
     * Set quantity
     *
     * @param int $itemId
     * @return \Zanui\ApiWishlist\Api\Data\WishlistItemInterface
     */
    public function setItemId($itemId);

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity();

    /**
     * Set quantity
     *
     * @param int $qty
     * @return \Zanui\ApiWishlist\Api\Data\WishlistItemInterface
     */
    public function setQuantity($qty);

    /**
     * Get image.
     *
     * @return string
     */
    public function getImageUrl();

    /**
     * Set image.
     *
     * @param string $imageUrl
     * @return \Zanui\ApiWishlist\Api\Data\WishlistItemInterface
     */
    public function setImageUrl($imageUrl);

    /**
     * Set product data.
     *
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @return \Zanui\ApiWishlist\Api\Data\WishlistItemInterface
     */
    public function setProduct(\Magento\Catalog\Api\Data\ProductInterface $product);

    /**
     * Get product data.
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface
     */
    public function getProduct();

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Zanui\ApiWishlist\Api\Data\WishlistItemExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \Zanui\ApiWishlist\Api\Data\WishlistItemExtensionInterface $extensionAttributes
     * @return \Zanui\ApiWishlist\Api\Data\WishlistItemInterface
     */
    public function setExtensionAttributes(
        \Zanui\ApiWishlist\Api\Data\WishlistItemExtensionInterface $extensionAttributes
    );

}
