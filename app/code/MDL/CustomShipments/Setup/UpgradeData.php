<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MDL\CustomShipments\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;
    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @inheritdoc
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '0.0.2', '<')) {
            /** @var EavSetup $eavSetup */
            $eavSetup = $this->eavSetupFactory->create();
            $attrCode = 'mdl_shipments';
            $productEntity = \Magento\Catalog\Model\Product::ENTITY;

//            $eavSetup->removeAttribute($productEntity, $attrCode);
            if (!$eavSetup->getAttribute($productEntity, $attrCode)) {
                $eavSetup->addAttribute(
                    $productEntity,
                    $attrCode,/* Custom Attribute Code */
                    [
                        'group' => 'Shipping methods',
                        'type' => 'varchar',
                        'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                        'length' => '50',
                        'frontend' => '',
                        'label' => 'Shipping methods',
                        'input' => 'multiselect',
                        'class' => '',
                        'source' => 'MDL\CustomShipments\Model\Config\Source\Options',
                        'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                        'visible' => true,
                        'required' => false,
                        'user_defined' => true,
                        'default' => '',
                        'searchable' => false,
                        'filterable' => false,
                        'comparable' => false,
                        'visible_on_front' => true,
                        'used_in_product_listing' => true,
                        'unique' => false
                    ]
                );
            }


        }

        if (version_compare($context->getVersion(), '0.0.3', '<')) {
            $eavSetup = $this->eavSetupFactory->create();
            $attrCode = 'mdl_shipments';
            $productEntity = \Magento\Catalog\Model\Product::ENTITY;

            if ($eavSetup->getAttribute($productEntity, $attrCode)) {
                $eavSetup->updateAttribute($productEntity, $attrCode, 'is_visible_on_front', false);
            }
        }

        $setup->endSetup();
    }
    
}
