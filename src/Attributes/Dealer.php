<?php


namespace MyStore2\Attributes;


class Dealer implements \MyStore2\Interfaces\AttributeInterface
{

    private function getDealerParams($dealer): array
    {
        return [
            "meta" => [
                "href" => $_ENV['MYSTORE_API_URL']."customentity/".$_ENV['DICT_DEALERS']."/".$dealer['id'],
                "type" => "customentity",
                "mediaType" => "application/json"
            ],
            "name" => $dealer['name']
        ];
    }

    public function getAttributeParams(): array
    {
        return [
            "meta" => [
                "href" => $_ENV['MYSTORE_API_URL']."customerorder/metadata/attributes/".$_ENV['ATTR_DEALER'],
                "type" => "attributemetadata",
                "mediaType" => "application/json"
            ],
            "id" => $_ENV['ATTR_DEALER'],
            "name" => "Дилер",
            "type" => "customentity"
        ];
    }

    public function getAttributeValue($params)
    {
        $dealers = $params['visit']->request->getEntity('customentity', $_ENV['DICT_DEALERS']);

        $default = [];

        foreach ($dealers['rows'] as $dealer){

            if($dealer['name'] == 'default')
                $default = $dealer;

            if($dealer['code'] == $params['visit']->visit_dealer)
                return $this->getDealerParams($dealer);
        }

        return $this->getDealerParams($default);
    }

    public static function getAttribute($params): array
    {
        $dealer = new self;
        $attribute =  $dealer->getAttributeParams();
        $attribute['value'] = $dealer->getAttributeValue($params);
        return $attribute;
    }
}

