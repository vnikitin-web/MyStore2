<?php


namespace MyStore2\Attributes;


class Region implements \MyStore2\Interfaces\AttributeInterface
{

    private function validateRegion($region_string): string
    {
        $string_parts = explode(" г", trim($region_string));


        return $string_parts[0];
    }

    public function getAttributeValue($params)
    {
        return $this->validateRegion($params['visit']->region);
    }

    public function getAttributeParams(): array
    {
        return [
            "meta" => [
                "href" => $_ENV['MYSTORE_API_URL']."customerorder/metadata/attributes/".$_ENV['ATTR_REGION'],
                "type" => "attributemetadata",
                "mediaType" => "application/json"
            ],
            "id" => "54b96a77-2e56-11eb-0a80-06d0000e15b0",
            "name" => "Регион",
            "type" => "string"
        ];
    }

    public static function getAttribute(array $params): array
    {
        $region = new self;
        $attribute = $region->getAttributeParams();
        $attribute['value'] = $region->getAttributeValue($params);
        return $attribute;
    }
}