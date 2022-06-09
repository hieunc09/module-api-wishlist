<?php

namespace Zanui\ApiWishlist\Api\Data;

interface ItemsAddedOutputInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    const WISHLIST_ITEMS = 'wishlist_items';
    const USER_ERROR = 'user_errors';

    /**
     * Get wishlist items
     *
     * @return \Zanui\ApiWishlist\Api\Data\WishlistItemInterface[]
     */
    public function getWishlistItems();

    /**
     * Set wishlist items
     *
     * @param \Zanui\ApiWishlist\Api\Data\WishlistItemInterface[] items
     * @return \Zanui\ApiWishlist\Api\Data\WishlistItemInterface[]
     */
    public function setWishlistItems($items);

    /**
     * Get user error
     *
     * @return string[]
     */
    public function getUserError();

    /**
     * Set user error
     *
     * @param string[] $error
     * @return string[]
     */
    public function setUserError($error);
}
