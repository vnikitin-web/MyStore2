<?php


namespace MyStore2\Attributes;


class Phone implements \MyStore2\Interfaces\AttributeInterface
{

    public function getAttributeValue($params)
    {
        return intval($params['visit']->client_phone);
    }

    public function getAttributeParams(): array
    {
        return [
            "meta" => [
                "href" => $_ENV['MYSTORE_API_URL']."customerorder/metadata/attributes/".$_ENV['ATTR_PHONE'],
                "type" => "attributemetadata",
                "mediaType" => "application/json"
            ],
            "id" => "4a20eb4c-16c0-11eb-0a80-03f1001b6344",
            "name" => "Мобильный телефон",
            "type" => "long"
        ];
    }

    public static function getAttribute(array $params): array
    {
        $phone = new self;
        $attribute = $phone->getAttributeParams();
        $attribute['value'] = $phone->getAttributeValue($params);
        return $attribute;
    }
}