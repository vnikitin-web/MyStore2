<?php


namespace MyStore2\Attributes;


class House implements \MyStore2\Interfaces\AttributeInterface
{

    public function getAttributeValue($params)
    {
        return $params['visit']->house;
    }

    public function getAttributeParams(): array
    {
        return [
            "meta" => [
                "href" => $_ENV['MYSTORE_API_URL']."customerorder/metadata/attributes/".$_ENV['ATTR_HOUSE'],
                "type" => "attributemetadata",
                "mediaType" => "application/json"
            ],
            "id" => $_ENV['ATTR_HOUSE'],
            "name" => "Дом",
            "type" => "string"
        ];
    }

    public static function getAttribute(array $params): array
    {
        $house = new self;
        $attribute = $house->getAttributeParams();
        $attribute['value'] = $house->getAttributeValue($params);
        return $attribute;
    }
}