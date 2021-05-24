<?php


namespace MyStore2\Fields;


use MyStore2\Attributes\Area;
use MyStore2\Attributes\City;
use MyStore2\Attributes\ClientName;
use MyStore2\Attributes\Dealer;
use MyStore2\Attributes\DealerDate;
use MyStore2\Attributes\Entrance;
use MyStore2\Attributes\Flat;
use MyStore2\Attributes\FromInterval;
use MyStore2\Attributes\House;
use MyStore2\Attributes\PaymentForm;
use MyStore2\Attributes\Phone;
use MyStore2\Attributes\Punct;
use MyStore2\Attributes\Region;
use MyStore2\Attributes\Street;
use MyStore2\Attributes\TransportCompany;
use MyStore2\Attributes\ToInterval;

class Attributes
{

    public static function getAttributes($params = []): array
    {
        return [
            Dealer::getAttribute($params),
            DealerDate::getAttribute($params),
            ClientName::getAttribute($params),
            Phone::getAttribute($params),
            Region::getAttribute($params),
            Area::getAttribute($params),
            Punct::getAttribute($params),
            City::getAttribute($params),
            Street::getAttribute($params),
            House::getAttribute($params),
            Entrance::getAttribute($params),
            Flat::getAttribute($params),
            PaymentForm::getAttribute($params),
            TransportCompany::getAttribute($params),
            ToInterval::getAttribute($params),
            FromInterval::getAttribute($params)
        ];
    }
}