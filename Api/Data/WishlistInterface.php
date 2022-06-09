<?php

namespace Zanui\ApiWishlist\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface WishlistInterface extends ExtensibleDataInterface
{
    const WISHLIST_ID = 'wishlist_id';
    const ITEMS = 'items';
    const SHARING_CODE = 'sharing_code';
    const UPDATED_AT = 'updated_at';
    const ITEMS_COUNT = 'items_count';

    /**
     * Get wishlist id.
     *
     * @return string
     */
    public function getWishlistId();


    /**
     * Set wishlist id.
     *
     * @param int $id
     * @return \Zanui\ApiWishlist\Api\Data\WishlistInterface
     */
    public function setWishlistId($id);

    /**
     * Get sharing code.
     *
     * @return string
     */
    public function getSharingCode();

    /**
     * Set sharing code.
     *
     * @param string $sharingCode
     * @return \Zanui\ApiWishlist\Api\Data\WishlistInterface
     */
    public function setSharingCode($sharingCode);

    /**
     * Get updated at
     *
     * @return string
     */
    public function getUpdatedAt();

    /**
     * Set updated at
     *
     * @param string $updatedAt
     * @return \Zanui\ApiWishlist\Api\Data\WishlistInterface
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Get items count
     *
     * @return int
     */
    public function getItemsCount();

    /**
     * Set items count
     *
     * @param int $itemsCount
     * @return \Zanui\ApiWishlist\Api\Data\WishlistInterface
     */
    public function setItemsCount($itemsCount);

    /**
     * Get items.
     *
     * @return \Zanui\ApiWishlist\Api\Data\WishlistItemInterface[]
     */
    public function getItems();

    /**
     * Set items.
     *
     * @param \Zanui\ApiWishlist\Api\Data\WishlistItemInterface[] $items
     * @return \Zanui\ApiWishlist\Api\Data\WishlistInterface
     */
    public function setItems($items);

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Zanui\ApiWishlist\Api\Data\WishlistExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \Zanui\ApiWishlist\Api\Data\WishlistExtensionInterface $extensionAttributes
     * @return \Zanui\ApiWishlist\Api\Data\WishlistInterface
     */
    public function setExtensionAttributes(
        \Zanui\ApiWishlist\Api\Data\WishlistExtensionInterface $extensionAttributes
    );
}
