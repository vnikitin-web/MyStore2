<?php


namespace MyStore2\Attributes;


class Flat implements \MyStore2\Interfaces\AttributeInterface
{

    public function getAttributeValue($params)
    {
        return $params['visit']->flat;
    }

    public function getAttributeParams(): array
    {
        return [
            "meta" => [
                "href" => $_ENV['MYSTORE_API_URL']."customerorder/metadata/attributes/".$_ENV['ATTR_FLAT'],
                "type" => "attributemetadata",
                "mediaType" => "application/json"
            ],
            "id" => $_ENV['ATTR_FLAT'],
            "name" => "Квартира",
            "type" => "string"
        ];
    }

    public static function getAttribute(array $params): array
    {
        $flat = new self;
        $attribute = $flat->getAttributeParams();
        $attribute['value'] = $flat->getAttributeValue($params);
        return $attribute;
    }
}