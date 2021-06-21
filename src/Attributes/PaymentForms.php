<?php


namespace MyStore2\Attributes;


class PaymentForms
{
    private function getPaymentFormParams($payment_form): array
    {
        return [
            "meta" => [
                "href" => $_ENV['MYSTORE_API_URL']."customentity/".$_ENV['DICT_PAYMENT_TYPES']."/".$payment_form['id'],
                "type" => "customentity",
                "mediaType" => "application/json"
            ],
            "name" => $payment_form['name']
        ];
    }

    public function getAttributeValue($params): array
    {
        $payment_forms = $params['visit']->request->getEntity('customentity', $_ENV['DICT_PAYMENT_TYPES']);

        $default = [];

        foreach ($payment_forms['rows'] as $payment_form){

            if($payment_form['name'] == "Наличный расчет")
                $default = $payment_form;

            if($payment_form['code'] == $params['visit']->payment_form)
                return $this->getPaymentFormParams($payment_form);
        }

        return $this->getPaymentFormParams($default);
    }

    public function getAttributeParams(): array
    {
        return [
            "meta" => [
                "href" => $_ENV['MYSTORE_API_URL']."customerorder/metadata/attributes/".$_ENV['ATTR_PAYMENT_TYPE'],
                "type" => "attributemetadata",
                "mediaType" => "application/json"
            ],
            "id" => $_ENV['ATTR_PAYMENT_TYPE'],
            "name" => "Форма оплаты",
            "type" => "customentity"
        ];
    }

    public static function getAttribute($params = []): array
    {
        $payment_form = new self;
        $attribute =  $payment_form->getAttributeParams();
        $attribute['value'] = $payment_form->getAttributeValue($params);
        return $attribute;
    }

}