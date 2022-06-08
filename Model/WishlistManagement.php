<?php
declare(strict_types=1);

namespace Zanui\ApiWishlist\Model;

use Magento\Framework\Data\Collection;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Webapi\Exception;
use Magento\Wishlist\Model\Wishlist\AddProductsToWishlist as AddProductsToWishlistModel;
use Magento\Wishlist\Model\Wishlist\Data\Error;
use Magento\Wishlist\Model\WishlistFactory as WishlistModel;
use Psr\Log\LoggerInterface as Logger;
use Zanui\ApiWishlist\Api\Data\ItemsAddedOutputInterface;
use Zanui\ApiWishlist\Api\WishlistManagementInterface;
use Zanui\ApiWishlist\Model\WishlistItemsFactory as WishlistItems;
use Zanui\ApiWishlist\Model\SpecialPriceFactory as SpecialPrice;
use Zanui\ApiWishlist\Model\ItemsAddedOutputFactory as ItemsAddedOutput;
use Zanui\ApiWishlist\Helper\ProductHelper;
use Zanui\ApiWishlist\Helper\WishlistHelper;
use Magento\Framework\Webapi\Rest\Request;

class WishlistManagement implements WishlistManagementInterface
{
    /**
     * @var WishlistModel
     */
    protected $wishlist;

    /**
     * @var WishlistItemsFactory
     */
    protected $wishlistItems;

    /**
     * @var SpecialPriceFactory
     */
    protected $specialPrice;

    /**
     * @var ProductHelper
     */
    protected $productHelper;

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
     * @param WishlistModel $wishlist
     * @param WishlistItemsFactory $wishlistItems
     * @param SpecialPriceFactory $specialPrice
     * @param ProductHelper $productHelper
     * @param WishlistHelper $wishlistHelper
     * @param AddProductsToWishlistModel $addProductsToWishlist
     * @param ItemsAddedOutputFactory $itemsAddedOutput
     * @param Request $request
     * @param Logger $logger
     */
    public function __construct(
        WishlistModel              $wishlist,
        WishlistItems              $wishlistItems,
        SpecialPrice               $specialPrice,
        ProductHelper              $productHelper,
        WishlistHelper             $wishlistHelper,
        AddProductsToWishlistModel $addProductsToWishlist,
        ItemsAddedOutput           $itemsAddedOutput,
        Request                    $request,
        Logger                     $logger
    )
    {
        $this->wishlist = $wishlist;
        $this->wishlistItems = $wishlistItems;
        $this->specialPrice = $specialPrice;
        $this->productHelper = $productHelper;
        $this->wishlistHelper = $wishlistHelper;
        $this->addProductsToWishlist = $addProductsToWishlist;
        $this->wishlistItemsAdded = $itemsAddedOutput;
        $this->logger = $logger;
        $this->request = $request;
    }

    /**
     * @param $customerId
     * @return \Zanui\ApiWishlist\Model\WishlistItems[]
     * @throws NoSuchEntityException
     * @throws InputException
     * @throws Exception
     */
    public function getWishlistForCustomer($customerId)
    {
        try {
            $data = [];
            if (null === $customerId || 0 === $customerId) {
                throw new InputException(__('The current user cannot perform operations on wishlist'));
            } else {
                $wishListCustomer = $this->wishlist->create()->loadByCustomerId($customerId);
                //get param for pagination
                $currentPage = $this->request->getParam('currentPage') ?? 1;
                $pageSize = $this->request->getParam('pageSize') ?? 20;
                //pagination and sort items by latest added
                $collection = $wishListCustomer->getItemCollection()
                    ->setPageSize($pageSize)
                    ->setCurPage($currentPage)
                    ->setOrder('wishlist_item_id', Collection::SORT_ORDER_DESC);
                //get data for wishlist items
                if ($wishListCustomer->getItemCollection()->count()) {
                    $wishListItems = $this->wishlistItems->create();
                    foreach ($collection as $item) {
                        $data[] = clone $this->getWishlistItemsData($wishListItems, $item);
                    }
                }
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
        return $data;
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
            $dataItemsOutput = [];
            if (null === $customerId || 0 === $customerId) {
                throw new InputException(__('The current user cannot perform operations on wishlist'));
            } else {
                //get wishlist data
                $wishlistId = $wishlistItems->getWishlistId() ?: null;
                $wishlist = $this->wishlistHelper->getWishlist($wishlistId, $customerId);

                if (null === $wishlist->getId() || $customerId !== (int)$wishlist->getCustomerId()) {
                    throw new InputException(__('The wishlist was not found.'));
                }
                //get wishlist items data
                $wishlistItems = $this->wishlistHelper->getWishlistItems($wishlistItems->getItems());
                //add items to wishlist
                $wishlistOutput = $this->addProductsToWishlist->execute($wishlist, $wishlistItems);
                //get wishlist items with extra field
                $this->wishlist->create()->loadByCustomerId($customerId);
                $collection = $this->wishlist->create()->loadByCustomerId($customerId)->getItemCollection()
                    ->setOrder('wishlist_item_id', Collection::SORT_ORDER_DESC);
                $wishListItemsOutput = $this->wishlistItems->create();
                foreach ($collection as $item) {
                    $dataItemsOutput[] = clone $this->getWishlistItemsData($wishListItemsOutput, $item);
                }
                $itemsAdded->setWishlistItems($dataItemsOutput);
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
     * @param $wishListItems
     * @param $item
     * @return mixed
     * @throws NoSuchEntityException
     */
    private function getWishlistItemsData($wishListItems, $item)
    {
        $currentProduct = $item->getProduct();
        //check and get child product
        if ($currentProduct->getTypeId() != 'simple') {
            if ($idChild = $item->getOptionByCode('simple_product')) {
                $currentProduct = $this->productHelper->getChildProduct($idChild->getProductId());
            }
        }
        //prepare data wishlist
        $wishListItems->setWishlistId($item->getWishlistId());
        $wishListItems->setItemId($item->getWishlistItemId());
        $wishListItems->setProductId($currentProduct->getId());
        $wishListItems->setName($currentProduct->getName());
        $wishListItems->setSku($currentProduct->getSku());
        $wishListItems->setImage($this->productHelper->getImageUrl($currentProduct, 'product_base_image'));
        $wishListItems->setPrice((float)$currentProduct->getPrice());
        $wishListItems->setSpecialPrice($this->productHelper->getSpecialPriceInfor($currentProduct));
        return $wishListItems;
    }
}
