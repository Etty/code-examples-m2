<?php
namespace MDL\CustomShipments\Ui\Component\Listing\Column\Mdlcustomshipmentgrid;

class PageActions extends \Magento\Ui\Component\Listing\Columns\Column
{
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource["data"]["items"])) {
            foreach ($dataSource["data"]["items"] as & $item) {
                $name = $this->getData("name");
                $id = "X";
                if(isset($item["mdl_customshipments_shipment_id"]))
                {
                    $id = $item["mdl_customshipments_shipment_id"];
                }
                $item[$name]["view"] = [
                    "href"=>$this->getContext()->getUrl(
                        "mdl_custom_shipments/shipment/edit",["mdl_customshipments_shipment_id"=>$id]),
                    "label"=>__("Edit")
                ];
            }
        }

        return $dataSource;
    }    
    
}
