<?php


namespace MyStore2\Attributes;


class DealerDate implements \MyStore2\Interfaces\AttributeInterface
{

    public function getAttributeParams(): array
    {
        return [
            "meta" => [
                "href" => $_ENV['MYSTORE_API_URL']."customerorder/metadata/attributes/".$_ENV['ATTR_DEALER_DATE'],
                "type" => "attributemetadata",
                "mediaType" => "application/json"
                ],
            "id" => $_ENV['ATTR_DEALER_DATE'],
            "name" => "Дата встречи дилера",
            "type" => "time"
        ];
    }

    public function getAttributeValue($params)
    {
        return $params['visit']->visit_date;
    }

    public static function getAttribute($params): array
    {
        $dealer_date = new self;
        $attribute = $dealer_date->getAttributeParams();
        $attribute['value'] = $dealer_date->getAttributeValue($params);
        return $attribute;
    }
}