<?php


namespace MyStore2\Attributes;


class Punct implements \MyStore2\Interfaces\AttributeInterface
{

    public function getAttributeValue($params)
    {
        return $params['visit']->punct;
    }

    public function getAttributeParams(): array
    {
        return [
            "meta" => [
                "href" => $_ENV['MYSTORE_API_URL']."customerorder/metadata/attributes/".$_ENV['ATTR_PUNCT'],
                "type" => "attributemetadata",
                "mediaType" => "application/json"
            ],
            "id" => $_ENV['ATTR_PUNCT'],
            "name" => "Пункт",
            "type" => "string",
        ];
    }

    public static function getAttribute(array $params): array
    {
        $punct = new self;
        $attribute = $punct->getAttributeParams();
        $attribute['value'] = $punct->getAttributeValue($params);
        return $attribute;
    }
}