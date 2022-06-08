<?php

namespace Zanui\ApiWishlist\Api\Data;

interface SpecialPriceInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    const SPECIAL_PRICE = 'special_price';
    const PRICE_FROM = 'price_from';
    const PRICE_TO = 'price_to';

    /**
     * Set product special price value.
     *
     * @param float $specialPrice
     * @return \Magento\Catalog\Api\Data\SpecialPriceInterface
     */
    public function setSpecialPrice($specialPrice);

    /**
     * Get product special price value.
     *
     * @return float
     */
    public function getSpecialPrice();

    /**
     * Set start date for special price in Y-m-d H:i:s format.
     *
     * @param string $datetime
     * @return \Zanui\ApiWishlist\Api\Data\SpecialPriceInterface
     */
    public function setPriceFrom($datetime);

    /**
     * Get start date for special price in Y-m-d H:i:s format.
     *
     * @return string
     */
    public function getPriceFrom();

    /**
     * Set end date for special price in Y-m-d H:i:s format.
     *
     * @param string $datetime
     * @return \Zanui\ApiWishlist\Api\Data\SpecialPriceInterface
     */
    public function setPriceTo($datetime);

    /**
     * Get end date for special price in Y-m-d H:i:s format.
     *
     * @return string
     */
    public function getPriceTo();

    /**
     * Retrieve existing extension attributes object.
     * If extension attributes do not exist return null.
     *
     * @return \Zanui\ApiWishlist\Api\Data\SpecialPriceExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \Zanui\ApiWishlist\Api\Data\SpecialPriceExtensionInterface $extensionAttributes
     * @return \Zanui\ApiWishlist\Api\Data\SpecialPriceInterface
     */
    public function setExtensionAttributes(
        \Zanui\ApiWishlist\Api\Data\SpecialPriceExtensionInterface $extensionAttributes
    );
}

