<?php

namespace Zanui\ApiWishlist\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface WishlistItemsAddInterface extends ExtensibleDataInterface
{
    const ITEMS = 'items';
    const WISHLIST_ID = 'wishlist_id';

    /**
     * Get items
     *
     * @return \Zanui\ApiWishlist\Api\Data\ItemAddInterface[]
     */
    public function getItems();

    /**
     * Set items
     *
     * @param \Zanui\ApiWishlist\Api\Data\ItemAddInterface[] $items
     * @return \Zanui\ApiWishlist\Api\Data\ItemAddInterface[]
     */
    public function setItems($items);

    /**
     * Get wishlist id
     *
     * @return int
     */
    public function getWishlistId();

    /**
     * Set wishlist id
     *
     * @param int $id
     * @return \Zanui\ApiWishlist\Api\Data\WishlistItemsAddInterface
     */
    public function setWishlistId($id);

}
