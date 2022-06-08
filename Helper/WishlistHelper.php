<?php

namespace Zanui\ApiWishlist\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Wishlist\Model\ResourceModel\Wishlist as WishlistResourceModel;
use Magento\Wishlist\Model\Wishlist;
use Magento\Wishlist\Model\Wishlist\Data\WishlistItemFactory;
use Magento\Wishlist\Model\WishlistFactory as WishlistModel;

class WishlistHelper extends AbstractHelper
{
    /**
     * @var WishlistModel
     */
    private $wishlistModel;

    /**
     * @var WishlistResourceModel
     */
    private $wishlistResource;

    /**
     * @param WishlistModel $wishlistModel
     * @param WishlistResourceModel $wishlistResource
     * @param Context $context
     */
    public function __construct(
        WishlistModel         $wishlistModel,
        WishlistResourceModel $wishlistResource,
        Context               $context
    )
    {
        $this->wishlistModel = $wishlistModel;
        $this->wishlistResource = $wishlistResource;
        parent::__construct($context);
    }

    /**
     * Get wishlist items
     *
     * @param array $wishlistItemsData
     *
     * @return array
     */
    public function getWishlistItems(array $wishlistItemsData): array
    {
        $wishlistItems = [];

        foreach ($wishlistItemsData as $wishlistItemData) {
            $wishlistItems[] = (new WishlistItemFactory())->create($wishlistItemData->getData());
        }

        return $wishlistItems;
    }

    /**
     * Get customer wishlist
     *
     * @param int|null $wishlistId
     * @param int|null $customerId
     *
     * @return Wishlist
     */
    public function getWishlist(?int $wishlistId, ?int $customerId): Wishlist
    {
        $wishlist = $this->wishlistModel->create();

        if ($wishlistId !== null && $wishlistId > 0) {
            $this->wishlistResource->load($wishlist, $wishlistId);
        } elseif ($customerId !== null) {
            $wishlist->loadByCustomerId($customerId, true);
        }

        return $wishlist;
    }
}
