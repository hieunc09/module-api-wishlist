<?php
declare(strict_types=1);

namespace Zanui\ApiWishlist\Model;

use Magento\Framework\Data\Collection;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Wishlist\Model\Wishlist\AddProductsToWishlist as AddProductsToWishlistModel;
use Magento\Wishlist\Model\Wishlist\Data\Error;
use Magento\Wishlist\Model\WishlistFactory as MagentoWishlistModel;
use Magento\Wishlist\Model\Wishlist as MagentoWishlist;
use Magento\Wishlist\Model\ResourceModel\Item\Collection as WishlistItemCollection;
use Magento\Wishlist\Model\ResourceModel\Item\CollectionFactory as WishlistItemCollectionFactory;
use Magento\Framework\Webapi\Rest\Request;
use Magento\Store\Api\Data\StoreInterface;
use Psr\Log\LoggerInterface as Logger;
use Zanui\ApiWishlist\Api\Data\ItemsAddedOutputInterface;
use Zanui\ApiWishlist\Api\WishlistManagementInterface;
use Zanui\ApiWishlist\Model\WishlistItemFactory as WishlistItem;
use Zanui\ApiWishlist\Model\WishlistFactory as Wishlist;
use Zanui\ApiWishlist\Model\ItemsAddedOutputFactory as ItemsAddedOutput;
use Zanui\ApiWishlist\Helper\ProductHelper;
use Zanui\ApiWishlist\Helper\WishlistHelper;


class WishlistManagement implements WishlistManagementInterface
{
    /**
     * @var MagentoWishlistModel
     */
    protected $magentoWishlistModel;

    /**
     * @var WishlistItemCollectionFactory
     */
    private $wishlistItemCollectionFactory;

    /**
     * @var ProductHelper
     */
    protected $productHelper;

    /**
     * @var Wishlist
     */
    protected $wishlist;

    /**
     * @var WishlistItem
     */
    protected $wishlistItem;

    /**
     * @var WishlistHelper
     */
    protected $wishlistHelper;

    /**
     * @var ItemsAddedOutputFactory
     */
    protected $wishlistItemsAdded;

    /**
     * @var AddProductsToWishlistModel
     */
    private $addProductsToWishlist;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param MagentoWishlistModel $magentoWishlistModel
     * @param WishlistItemCollectionFactory $wishlistItemCollectionFactory
     * @param AddProductsToWishlistModel $addProductsToWishlist
     * @param StoreManagerInterface $storeManager
     * @param Request $request
     * @param WishlistFactory $wishlist
     * @param WishlistItemFactory $wishlistItem
     * @param ItemsAddedOutputFactory $itemsAddedOutput
     * @param ProductHelper $productHelper
     * @param WishlistHelper $wishlistHelper
     * @param Logger $logger
     */
    public function __construct(
        MagentoWishlistModel          $magentoWishlistModel,
        WishlistItemCollectionFactory $wishlistItemCollectionFactory,
        AddProductsToWishlistModel    $addProductsToWishlist,
        StoreManagerInterface         $storeManager,
        Request                       $request,
        Wishlist                      $wishlist,
        WishlistItem                  $wishlistItem,
        ItemsAddedOutput              $itemsAddedOutput,
        ProductHelper                 $productHelper,
        WishlistHelper                $wishlistHelper,
        Logger                        $logger
    )
    {
        $this->magentoWishlistModel = $magentoWishlistModel;
        $this->wishlistItemCollectionFactory = $wishlistItemCollectionFactory;
        $this->addProductsToWishlist = $addProductsToWishlist;
        $this->storeManager = $storeManager;
        $this->request = $request;
        $this->wishlist = $wishlist;
        $this->wishlistItem = $wishlistItem;
        $this->wishlistItemsAdded = $itemsAddedOutput;
        $this->productHelper = $productHelper;
        $this->wishlistHelper = $wishlistHelper;
        $this->logger = $logger;

    }

    /**
     * @param $customerId
     * @return \Zanui\ApiWishlist\Model\Wishlist
     * @throws InputException
     */
    public function getWishlistForCustomer($customerId)
    {
        try {
            $wishlistOutput = $this->wishlist->create();
            if (null === $customerId || 0 === $customerId) {
                throw new InputException(__('The current user cannot perform operations on wishlist'));
            } else {
                $wishListByCustomer = $this->magentoWishlistModel->create()->loadByCustomerId($customerId);
                if (null === $wishListByCustomer->getId()) {
                    return $wishlistOutput;
                }
                //set data for wishlist output
                $wishlistOutput->setWishlistId($wishListByCustomer->getId());
                $wishlistOutput->setSharingCode($wishListByCustomer->getSharingCode());
                $wishlistOutput->setUpdatedAt($wishListByCustomer->getUpdatedAt());
                $wishlistOutput->setItemsCount($wishListByCustomer->getItemsCount());
                $wishlistOutput->setItems($this->getWishlistItemsData($wishListByCustomer));
            }
        } catch (LocalizedException $e) {
            $this->logger->critical($e);
            throw new InputException(
                __(
                    'Can\'t get the wishlist. Error: "%message"',
                    ['message' => $e->getMessage()]
                )
            );
        }
        return $wishlistOutput;
    }

    /**
     * @param $customerId
     * @param $wishlistItems
     * @return ItemsAddedOutputInterface
     * @throws InputException
     */
    public function addWishlistForCustomer($customerId, $wishlistItems)
    {
        try {
            $itemsAdded = $this->wishlistItemsAdded->create();
            if (null === $customerId || 0 === $customerId) {
                throw new InputException(__('The current user cannot perform operations on wishlist'));
            } else {
                //get wishlist data
                $wishlistId = $wishlistItems->getWishlistId() ?: null;
                $wishlistModel = $this->wishlistHelper->getWishlist($wishlistId, $customerId);

                if (null === $wishlistModel->getId() || $customerId !== (int)$wishlistModel->getCustomerId()) {
                    throw new InputException(__('The wishlist was not found.'));
                }
                //get wishlist items data
                $wishlistItems = $this->wishlistHelper->getWishlistItems($wishlistItems->getItems());
                //add items to wishlist
                $wishlistOutput = $this->addProductsToWishlist->execute($wishlistModel, $wishlistItems);
                $itemsAdded->setWishlistItems($this->getWishlistItemsData($wishlistOutput->getWishlist()));
                //add error message into output
                $itemsAdded->setUserError(array_map(
                    function (Error $error) {
                        return [
                            'code' => $error->getCode(),
                            'message' => $error->getMessage(),
                        ];
                    },
                    $wishlistOutput->getErrors()
                ));

            }
        } catch (LocalizedException $e) {
            $this->logger->critical($e);
            throw new InputException(
                __(
                    'Can\'t add the product. Error: "%message"',
                    ['message' => $e->getMessage()]
                )
            );
        }
        return $itemsAdded;
    }

    /**
     * @param MagentoWishlist $wishList
     * @return array
     * @throws NoSuchEntityException
     */
    private function getWishlistItemsData(MagentoWishlist $wishList)
    {
        $itemsData = [];
        //load wishlist items
        /** @var WishlistItemCollection $wishlistItemCollection */
        $wishlistItemsCollection = $this->getWishListItems($wishList);
        $wishlistItems = $wishlistItemsCollection->getItems();
        //get data wishlist items
        foreach ($wishlistItems as $wishlistItem) {
            $wishListItem = $this->wishlistItem->create();
            $currentProduct = $wishlistItem->getProduct();
            //check and get child product
            if ($currentProduct->getTypeId() != 'simple') {
                if ($idChild = $wishlistItem->getOptionByCode('simple_product')) {
                    $currentProduct = $this->productHelper->getChildProduct($idChild->getProductId());
                }
            }
            //prepare data wishlist items
            $wishListItem->setItemId($wishlistItem->getWishlistItemId());
            $wishListItem->setQuantity($wishlistItem->getQty());
            $wishListItem->setImageUrl($this->productHelper->getImageUrl($currentProduct, 'product_base_image'));
            $wishListItem->setProduct($currentProduct);
            $itemsData[] = $wishListItem;
        }
        return $itemsData;
    }

    /**
     * Get wishlist items
     *
     * @param MagentoWishlist $wishlist
     * @return WishlistItemCollection
     */
    private function getWishListItems(MagentoWishlist $wishlist)
    {
        //get param for pagination
        $currentPage = $this->request->getParam('currentPage') ?? 1;
        $pageSize = $this->request->getParam('pageSize') ?? 20;

        $wishlistItemCollection = $this->wishlistItemCollectionFactory->create();
        $wishlistItemCollection
            ->addWishlistFilter($wishlist)
            ->addStoreFilter(array_map(function (StoreInterface $store) {
                return $store->getId();
            }, $this->storeManager->getStores()))
            ->setVisibilityFilter()
            ->setOrder('wishlist_item_id', Collection::SORT_ORDER_DESC);
        if ($currentPage > 0) {
            $wishlistItemCollection->setCurPage($currentPage);
        }
        if ($pageSize > 0) {
            $wishlistItemCollection->setPageSize($pageSize);
        }
        return $wishlistItemCollection;
    }
}
