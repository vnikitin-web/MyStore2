<?php


namespace MyStore2\Attributes;


class City implements \MyStore2\Interfaces\AttributeInterface
{

    public function getAttributeValue($params)
    {
        return $params['visit']->city;
    }

    public function getAttributeParams(): array
    {
        return [
            "meta" => [
                "href" => $_ENV['MYSTORE_API_URL']."customerorder/metadata/attributes/".$_ENV['ATTR_CITY'],
                "type" => "attributemetadata",
                "mediaType" => "application/json"
            ],
            "id" => $_ENV['ATTR_CITY'],
            "name" => "Город",
            "type" => "string"
        ];
    }

    public static function getAttribute(array $params): array
    {
        $city = new self;
        $attribute = $city->getAttributeParams();
        $attribute['value'] = $city->getAttributeValue($params);
        return $attribute;
    }
}