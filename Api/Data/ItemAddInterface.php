<?php

namespace Zanui\ApiWishlist\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface ItemAddInterface extends ExtensibleDataInterface
{
    const SKU = 'sku';
    const QUANTITY = 'quantity';
    const SELECTED_OPTIONS = 'selected_options';
    const PARENT_SKU = 'parent_sku';

    /**
     * Get sku.
     *
     * @return string
     */
    public function getSku();


    /**
     * Set sku.
     *
     * @param string $sku
     * @return \Zanui\ApiWishlist\Api\Data\ItemAddInterface
     */
    public function setSku($sku);

    /**
     * Get parent sku.
     *
     * @return string
     */
    public function getParentSku();

    /**
     * Set parent sku.
     *
     * @param string $parentSku
     * @return \Zanui\ApiWishlist\Api\Data\ItemAddInterface
     */
    public function setParentSku($parentSku);

    /**
     * Get qty.
     *
     * @return int
     */
    public function getQuantity();

    /**
     * Set qty.
     *
     * @param int $qty
     * @return \Zanui\ApiWishlist\Api\Data\ItemAddInterface
     */
    public function setQuantity($qty);

    /**
     * Get selected option.
     *
     * @return string[]
     */
    public function getSelectedOptions();

    /**
     * Set selected option.
     *
     * @param array $selectedOptions
     * @return \Zanui\ApiWishlist\Api\Data\ItemAddInterface
     */
    public function setSelectedOptions(array $selectedOptions);

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Zanui\ApiWishlist\Api\Data\ItemAddExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \Zanui\ApiWishlist\Api\Data\ItemAddExtensionInterface $extensionAttributes
     * @return \Zanui\ApiWishlist\Api\Data\ItemAddInterface
     */
    public function setExtensionAttributes(
        \Zanui\ApiWishlist\Api\Data\ItemAddExtensionInterface $extensionAttributes
    );

}
