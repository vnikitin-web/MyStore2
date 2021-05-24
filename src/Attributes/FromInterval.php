<?php


namespace MyStore2\Attributes;


class FromInterval implements \MyStore2\Interfaces\AttributeInterface
{

    public function getAttributeValue($params)
    {
        $hours = $params['visit']->time_from;
        $date = $this->getDate($params['visit']->visit_date);
        return "{$date} {$hours}:00:00";
    }

    private function getDate($visit_date)
    {
        $parts = explode(" ", $visit_date);
        return $parts[0];
    }

    public function getAttributeParams(): array
    {
        return [
            "meta" => [
                "href" => $_ENV['MYSTORE_API_URL']."customerorder/metadata/attributes/".$_ENV['ATTR_FROM_INTERVAL'],
                "type" => "attributemetadata",
                "mediaType" => "application/json"
            ],
            "id" => $_ENV['ATTR_FROM_INTERVAL'],
            "name" => "Доставить c",
            "type" => "time"
        ];
    }

    public static function getAttribute(array $params): array
    {
        $from_interval = new self;
        $attribute = $from_interval->getAttributeParams();
        $attribute['value'] = $from_interval->getAttributeValue($params);
        return $attribute;
    }
}