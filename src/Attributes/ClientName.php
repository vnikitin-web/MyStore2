<?php


namespace MyStore2\Attributes;


class ClientName implements \MyStore2\Interfaces\AttributeInterface
{

    public function getAttributeValue($params)
    {
        return $this->nameValidator($params['visit']->client_name);
    }

    private function nameValidator($name_string): string
    {

        $name_parts = explode(' ', trim($name_string));

        $wrong_symbols = ['-', '"', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '{', '}', '|', ':', '"', '<', '>', '?', '[', ']', ';', "'", ',', '.', '/', '', '~', '`', '='];

        $name = array_filter($name_parts , function($item) use ($wrong_symbols){
            return !in_array($item, $wrong_symbols);
        });

        return implode(' ', $name);
    }

    public function getAttributeParams(): array
    {

        return [
            "meta" => [
                "href" => $_ENV['MYSTORE_API_URL']."customerorder/metadata/attributes/".$_ENV['ATTR_CLIENT_NAME'],
                "type" => "attributemetadata",
                "mediaType" => "application/json"
            ],
            "id" => $_ENV['ATTR_CLIENT_NAME'],
            "name" => "ФИО",
            "type" => "string"
        ];

    }

    public static function getAttribute(array $params): array
    {
        $client_name = new self;
        $attribute = $client_name->getAttributeParams();
        $attribute['value'] = $client_name->getAttributeValue($params);
        return $attribute;
    }
}