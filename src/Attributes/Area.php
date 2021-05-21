<?php


namespace MyStore2\Attributes;


class Area implements \MyStore2\Interfaces\AttributeInterface
{

    public function getAttributeValue($params)
    {
        return $params['visit']->area;
    }

    public function getAttributeParams(): array
    {
        return [
            "meta" => [
                "href" => $_ENV['MYSTORE_API_URL'] . "customerorder/metadata/attributes/" . $_ENV['ATTR_AREA'],
                "type" => "attributemetadata",
                "mediaType" => "application/json"
            ],
            "id" => $_ENV['ATTR_AREA'],
            "name" => "Район",
            "type" => "string"
        ];
    }

    public static function getAttribute(array $params): array
    {
        $area = new self;
        $attribute = $area->getAttributeParams();
        $attribute['value'] = $area->getAttributeValue($params);
        return $attribute;
    }
}