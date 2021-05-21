<?php


namespace MyStore2\Attributes;


class PaymentForm implements \MyStore2\Interfaces\AttributeInterface
{

    public function getPaymentValueParams($id, $name): array
    {
        return [
            "meta" => [
                "href" => $_ENV['MYSTORE_API_URL']."customentity/".$_ENV['DICT_PAYMENT_FORMS']."/".$id,
                "type" => "customentity",
                "mediaType" => "application/json",
            ],
            "name" => $name
        ];

    }

    public function isPaid($params): bool
    {
        return $params['visit']->is_paid == 1 || $params['visit']->payment_status == 1;
    }

    public function getAttributeValue($params)
    {
        $payment_status_id = $_ENV['ATTR_PAY_AFTER'];
        $payment_status_name = "С приемом платежа";

        if($this->isPaid($params)){
            $payment_status_id = $_ENV['ATTR_IS_PAID'];
            $payment_status_name = "Заказ предоплачен";
        }

        return $this->getPaymentValueParams($payment_status_id, $payment_status_name);
    }

    public function getAttributeParams(): array
    {
        return [
            "meta" => [
                "href" => $_ENV['MYSTORE_API_URL']."customerorder/metadata/attributes/".$_ENV['ATTR_PAYMENT_FORM'],
                "type" => "attributemetadata",
                "mediaType" => "application/json"
            ],
            "id" => $_ENV['ATTR_PAYMENT_FORM'],
            "name" => "Прием платежа",
            "type" => "customentity",
        ];
    }

    public static function getAttribute(array $params): array
    {
        $payment_type = new self;
        $attribute = $payment_type->getAttributeParams();
        $attribute['value'] = $payment_type->getAttributeValue($params);
        return $attribute;
    }
}