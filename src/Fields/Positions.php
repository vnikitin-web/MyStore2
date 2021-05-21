<?php


namespace MyStore2\Fields;


class Positions
{

    public array $positions = [];

    private function getShippingParams($product)
    {
        return [
            "quantity" => 1,
            "price" => floatval($product['VI_SALE_COST']) * 100.00,
            "assortment" => [
                "meta" => [
                    "href" => $_ENV['MYSTORE_API_URL']."service/".$_ENV['ATTR_SHIPPING'],
                    "type" => "service",
                    "mediaType" => "application/json"
                ]
            ]
        ];
    }

    private function getPositionParams($params, $product): ?array
    {
        $position = $params['visit']->request->getEntity('product', '', '?filter=code='.$product['VI_ITEM_ID']);

        if($position['meta']['size'] > 0){
            return [
                "quantity" => floatval($product['VI_SALE_COUNT']),
                "price" => floatval($product['VI_SALE_COST']) * 100.00,
                "discount" => 0,
                "vat" => 20,
                "assortment" => [
                    "meta" => [
                        "href" => $position['rows'][0]['meta']['href'],
                        "type" => "product",
                        "mediaType" => "application/json",
                    ]
                ],
                "reserve" => floatval($product['VI_SALE_COUNT'])
            ];
        }

        return null;
    }

    public function makePositionsList($params)
    {
        foreach ($params['visit']->products as $product){

            if($product['VI_ITEM_ID'] == '0000-01'){
                $this->positions[] = $this->getShippingParams($product);
                continue;
            }

            $position_params = $this->getPositionParams($params, $product);

            if(!is_null($position_params)){
                $this->positions[] = $position_params;
            }
        }
    }

    public static function getPositions($params): array
    {
        $positions = new self;
        $positions->makePositionsList($params);
        return $positions->positions;
    }
}