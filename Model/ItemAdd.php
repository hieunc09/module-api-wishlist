<?php

namespace Zanui\ApiWishlist\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Zanui\ApiWishlist\Api\Data\ItemAddInterface;

class ItemAdd extends AbstractExtensibleModel implements ItemAddInterface
{

    /**
     * {@inheritdoc}
     */
    public function getSku()
    {
        return $this->getData(self::SKU);
    }

    /**
     * {@inheritdoc}
     */
    public function setSku($sku)
    {
        return $this->setData(self::SKU, $sku);
    }

    /**
     * {@inheritdoc}
     */
    public function getParentSku()
    {
        return $this->getData(self::PARENT_SKU);
    }

    /**
     * {@inheritdoc}
     */
    public function setParentSku($parentSku)
    {
        return $this->setData(self::PARENT_SKU, $parentSku);
    }

    /**
     * {@inheritdoc}
     */
    public function getQuantity()
    {
        return $this->getData(self::QUANTITY);
    }

    /**
     * {@inheritdoc}
     */
    public function setQuantity($qty)
    {
        return $this->setData(self::QUANTITY, $qty);
    }

    /**
     * {@inheritdoc}
     */
    public function getSelectedOptions()
    {
        return $this->getData(self::SELECTED_OPTIONS);
    }

    /**
     * {@inheritdoc}
     */
    public function setSelectedOptions(array $selectedOption)
    {
        return $this->setData(self::SELECTED_OPTIONS, $selectedOption);
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
        \Zanui\ApiWishlist\Api\Data\ItemAddExtensionInterface $extensionAttributes
    )
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
