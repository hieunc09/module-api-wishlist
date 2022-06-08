<?php

namespace Zanui\ApiWishlist\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Zanui\ApiWishlist\Api\Data\SpecialPriceInterface;

class SpecialPrice extends AbstractExtensibleModel implements SpecialPriceInterface
{
    /**
     * {@inheritdoc}
     */
    public function setSpecialPrice($specialPrice)
    {
        return $this->setData(self::SPECIAL_PRICE, $specialPrice);
    }

    /**
     * {@inheritdoc}
     */
    public function getSpecialPrice()
    {
        return $this->getData(self::SPECIAL_PRICE);
    }

    /**
     * {@inheritdoc}
     */
    public function setPriceFrom($datetime)
    {
        return $this->setData(self::PRICE_FROM, $datetime);
    }

    /**
     * {@inheritdoc}
     */
    public function getPriceFrom()
    {
        return $this->getData(self::PRICE_FROM);
    }

    /**
     * {@inheritdoc}
     */
    public function setPriceTo($datetime)
    {
        return $this->setData(self::PRICE_TO, $datetime);
    }

    /**
     * {@inheritdoc}
     */
    public function getPriceTo()
    {
        return $this->getData(self::PRICE_TO);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * {@inheritdoc}
     */
    public function setExtensionAttributes(
        \Zanui\ApiWishlist\Api\Data\SpecialPriceExtensionInterface $extensionAttributes
    )
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
