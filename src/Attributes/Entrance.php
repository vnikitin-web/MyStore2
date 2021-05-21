<?php


namespace MyStore2\Attributes;


class Entrance implements \MyStore2\Interfaces\AttributeInterface
{

    public function getAttributeValue($params)
    {
        return $params['visit']->entrance;
    }

    public function getAttributeParams(): array
    {
        return [
            "meta" => [
                "href" => $_ENV['MYSTORE_API_URL']."customerorder/metadata/attributes/".$_ENV['ATTR_ENTRANCE'],
                "type" => "attributemetadata",
                "mediaType" => "application/json"
            ],
            "id" => $_ENV['ATTR_ENTRANCE'],
            "name" => "Подъезд",
            "type" => "string"
        ];
    }

    public static function getAttribute(array $params): array
    {
        $entrance = new self;
        $attribute = $entrance->getAttributeParams();
        $attribute['value'] = $entrance->getAttributeValue($params);
        return $attribute;
    }
}