<?php

namespace Zanui\ApiWishlist\Api;

interface   WishlistManagementInterface
{

    /**
     * Return Wishlist items.
     *
     * @param int $customerId
     * @return \Zanui\ApiWishlist\Api\Data\WishlistInterface
     */
    public function getWishlistForCustomer($customerId);

    /**
     * Return Added wishlist item.
     *
     * @param int $customerId
     * @param \Zanui\ApiWishlist\Api\Data\WishlistItemsAddInterface $wishlistItems
     * @return \Zanui\ApiWishlist\Api\Data\ItemsAddedOutputInterface
     *
     */
    public function addWishlistForCustomer($customerId, $wishlistItems);

}
