<?php
namespace MDL\CustomShipments\Model\Config\Source;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\App\ResourceConnection;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * Custom Attribute Renderer
 *
 * @author      Webkul Core Team <support@webkul.com>
 */
class Options extends AbstractSource
{
    /**
     * @var  ResourceConnection
     */
    protected $resource;


    /**
     * @param ResourceConnection $resource
     */
    public function __construct(ResourceConnection $resource)
    {
        $this->resource = $resource;
    }

    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        $connection = $this->resource->getConnection(ResourceConnection::DEFAULT_CONNECTION);
        $shipCollection = $connection->fetchCol("SELECT DISTINCT(`code`) FROM `mdl_customshipments_shipment`");

        foreach($shipCollection as $item){
            $this->_options[] = ['label' => $item, 'value' => $item];
        }
        return $this->_options;
    }

    /**
     * Get a text for option value
     *
     * @param string|integer $value
     * @return string|bool
     */
    public function getOptionText($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }

    /**
     * Retrieve flat column definition
     *
     * @return array
     */
    public function getFlatColumns()
    {
        $attributeCode = $this->getAttribute()->getAttributeCode();
        return [
            $attributeCode => [
                'unsigned' => false,
                'default' => null,
                'extra' => null,
                'type' => Table::TYPE_INTEGER,
                'nullable' => true,
                'comment' => 'Custom Attribute Options  ' . $attributeCode . ' column',
            ],
        ];
    }
}