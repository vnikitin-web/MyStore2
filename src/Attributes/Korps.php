<?php


namespace MyStore2\Attributes;


class Korps implements \MyStore2\Interfaces\AttributeInterface
{

    public function getAttributeValue($params)
    {
        // TODO: Implement getAttributeValue() method.
    }

    public function getAttributeParams(): array
    {
        // TODO: Implement getAttributeParams() method.
    }

    public static function getAttribute(array $params): array
    {
        $korps = new self;
        $attribute = $korps->getAttributeParams();
        $attribute['value'] = $attribute->getAttributeValue($params);
        return $attribute;
    }
}