<?php

namespace Zanui\ApiWishlist\Helper;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Helper\ImageFactory as ProductImageHelper;
use Magento\Catalog\Model\Product;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\App\Emulation as AppEmulation;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface as Logger;
use Zanui\ApiWishlist\Api\Data\SpecialPriceInterface;
use Zanui\ApiWishlist\Model\SpecialPriceFactory as SpecialPrice;
use Magento\Catalog\Model\ProductRepository;

class ProductHelper extends AbstractHelper
{
    /**
     * @var SpecialPrice
     */
    protected $specialPrice;

    /**
     *
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var AppEmulation
     */
    protected $appEmulation;

    /**
     * @var ProductImageHelper
     */
    protected $productImageHelper;

    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @param SpecialPrice $specialPrice
     * @param StoreManagerInterface $storeManager
     * @param AppEmulation $appEmulation
     * @param ProductImageHelper $productImageHelper
     * @param ProductRepository $productRepository
     * @param Logger $logger
     * @param Context $context
     */
    public function __construct(
        SpecialPrice          $specialPrice,
        StoreManagerInterface $storeManager,
        AppEmulation          $appEmulation,
        ProductImageHelper    $productImageHelper,
        ProductRepository     $productRepository,
        Logger                $logger,
        Context               $context
    )
    {
        $this->specialPrice = $specialPrice;
        $this->storeManager = $storeManager;
        $this->appEmulation = $appEmulation;
        $this->productImageHelper = $productImageHelper;
        $this->productRepository = $productRepository;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * @param $id
     * @return ProductInterface|mixed|null
     */
    public function getChildProduct($id): mixed
    {
        try {
            $productChild = $this->productRepository->getById($id);
        } catch (NoSuchEntityException $e) {
            $errorMessage = sprintf(
                "Can't get child product with this id. Error %s.",
                $e->getMessage()
            );
            $this->logger->error($errorMessage);
            throw new \LogicException($errorMessage);
        }
        return $productChild;
    }

    /**
     * @param $product
     * @return SpecialPriceInterface
     */
    public function getSpecialPriceInfor($product): SpecialPriceInterface
    {
        $specialPrice = $this->specialPrice->create();
        if (!empty($product->getSpecialPrice())) {
            $specialPrice->setSpecialPrice((float)$product->getSpecialPrice());
            $specialPrice->setPriceFrom($product->getSpecialFromDate());
            $specialPrice->setPriceTo($product->getSpecialToDate());
        }
        return $specialPrice;
    }

    /**
     * Helper function that provides full cache image url
     * @param Product
     * @param string $imageType
     * @return string
     * @throws NoSuchEntityException
     */
    public function getImageUrl($product, string $imageType = ''): string
    {
        $storeId = $this->storeManager->getStore()->getId();
        $this->appEmulation->startEnvironmentEmulation($storeId, \Magento\Framework\App\Area::AREA_FRONTEND, true);
        $imageUrl = $this->productImageHelper->create()->init($product, $imageType)->getUrl();
        $this->appEmulation->stopEnvironmentEmulation();

        return $imageUrl;
    }
}
