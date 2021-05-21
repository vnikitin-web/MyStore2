<?php


namespace MyStore2\Attributes;


class TransportCompany implements \MyStore2\Interfaces\AttributeInterface
{


    private function getValueParams($id, $name)
    {
        return [
            "meta" => [
                "href" => $_ENV['MYSTORE_API_URL']."customentity/".$_ENV['DICT_TRANSPORT_COMPANY']."/".$id,
                "type" => "customentity",
                "mediaType" => "application/json",
            ],
            "name" => $name
        ];
    }

    public function getAttributeValue($params)
    {
        $transport_company_id = $_ENV['ATTR_DEFAULT_TRANSPORT_COMPANY'];
        $transport_company_name = 'Нет';

        if($params['visit']->is_dostavista){
            $transport_company_id = $_ENV['ATTR_DOSTAVISTA'];
            $transport_company_name = "Достависта";
        }

        return $this->getValueParams($transport_company_id, $transport_company_name);
    }

    public function getAttributeParams(): array
    {
        return [
            "meta" => [
                "href" => $_ENV['MYSTORE_API_URL']."customerorder/metadata/attributes/".$_ENV['DICT_TRANSPORT_COMPANY'],
                "type" => "attributemetadata",
                "mediaType" => "application/json"
            ],
            "id" => $_ENV['DICT_TRANSPORT_COMPANY'],
            "name" => "Транспортныя компания",
            "type" => "customentity",
      ];

    }

    public static function getAttribute(array $params): array
    {
        $transport_company = new self;
        $attribute = $transport_company->getAttributeParams();
        $attribute['value'] = $transport_company->getAttributeValue($params);
        return $attribute;
    }
}