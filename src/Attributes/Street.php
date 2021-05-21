<?php


namespace MyStore2\Attributes;


class Street implements \MyStore2\Interfaces\AttributeInterface
{

    public function getAttributeValue($params)
    {
        return $params['visit']->street;
    }

    public function getAttributeParams(): array
    {
        return [
            "meta" => [
                "href" => $_ENV['MYSTORE_API_URL']."customerorder/metadata/attributes/".$_ENV['ATTR_STREET'],
                "type" => "attributemetadata",
                "mediaType" => "application/json"
            ],
            "id" => $_ENV['ATTR_STREET'],
            "name" => "Улица",
            "type" => "text"
        ];
    }

    public static function getAttribute(array $params): array
    {
        $street = new self;
        $attribute = $street->getAttributeParams();
        $attribute['value'] = $street->getAttributeValue($params);
        return $attribute;
    }
}