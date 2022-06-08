<?php

namespace Zanui\ApiWishlist\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface WishlistItemsInterface extends ExtensibleDataInterface
{
    const WISHLIST_ID = 'wishlist_id';
    const ITEM_ID = 'item_id';
    const PRODUCT_ID = 'product_id';
    const SKU = 'sku';
    const IMAGE = 'image';
    const NAME = 'name';
    const PRICE = 'price';
    const SPECIAL_PRICE = 'special_price';

    /**
     * Get wishlist id.
     *
     * @return int
     */
    public function getWishlistId();

    /**
     * Set wishlist id.
     *
     * @param int $wishlistId
     * @return \Zanui\ApiWishlist\Api\Data\WishlistItemsInterface
     */
    public function setWishlistId($wishlistId);

    /**
     * Get item id.
     *
     * @return int
     */
    public function getItemId();

    /**
     * Set item id.
     *
     * @param int $itemId
     * @return \Zanui\ApiWishlist\Api\Data\WishlistItemsInterface
     */
    public function setItemId($itemId);

    /**
     * Get product id.
     *
     * @return int
     */
    public function getProductId();

    /**
     * Set product id.
     *
     * @param int $productId
     * @return \Zanui\ApiWishlist\Api\Data\WishlistItemsInterface
     */
    public function setProductId($productId);

    /**
     * Get sku.
     *
     * @return string
     */
    public function getSku();


    /**
     * Set sku.
     *
     * @param string $sku
     * @return \Zanui\ApiWishlist\Api\Data\WishlistItemsInterface
     */
    public function setSku($sku);

    /**
     * Get image.
     *
     * @return string
     */
    public function getImage();

    /**
     * Set image.
     *
     * @param string $image
     * @return \Zanui\ApiWishlist\Api\Data\WishlistItemsInterface
     */
    public function setImage($image);

    /**
     * Get product name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set product name.
     *
     * @param string $name
     * @return \Zanui\ApiWishlist\Api\Data\WishlistItemsInterface
     */
    public function setName($name);

    /**
     * Get product price.
     *
     * @return float
     */
    public function getPrice();

    /**
     * Set product price.
     *
     * @param float $price
     * @return \Zanui\ApiWishlist\Api\Data\WishlistItemsInterface
     */
    public function setPrice($price);

    /**
     * Get product special price.
     *
     * @return \Zanui\ApiWishlist\Api\Data\SpecialPriceInterface
     */
    public function getSpecialPrice();

    /**
     * Set product special price.
     *
     * @param \Zanui\ApiWishlist\Api\Data\SpecialPriceInterface $specialPrice
     * @return \Zanui\ApiWishlist\Api\Data\WishlistItemsInterface
     */
    public function setSpecialPrice(\Zanui\ApiWishlist\Api\Data\SpecialPriceInterface $specialPrice);

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Zanui\ApiWishlist\Api\Data\WishlistItemsExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \Zanui\ApiWishlist\Api\Data\WishlistItemsExtensionInterface $extensionAttributes
     * @return \Zanui\ApiWishlist\Api\Data\WishlistItemsInterface
     */
    public function setExtensionAttributes(
        \Zanui\ApiWishlist\Api\Data\WishlistItemsExtensionInterface $extensionAttributes
    );

}
