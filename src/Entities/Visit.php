<?php

namespace MyStore2\Entities;
use MyStore2\Http\Request;
use Exception;

class Visit
{
    public Request $request;
    public int $visit_id;
    public array $visit_data;
    public string $client_phone;
    public string $client_address;
    public int $visit_status;
    public int $visit_accept;
    public string $visit_dealer;
    public string $visit_date;
    public string $client_name;
    public string $region;
    public string $area;
    public string $punct;
    public string $city;
    public string $street;
    public string $house;
    public string $flat;
    public string $entrance;
    public int $is_paid;
    public int $payment_status;
    public bool $is_dostavista;
    public array $products;

    public function __construct($request, $visit_id)
    {
        $this->request = $request;
        $this->visit_id = $visit_id;
        $this->visit_data = $this->getVisitData();
        $this->client_phone = $this->getAgentPhone();
        $this->client_address = $this->getAgentAddress();
        $this->visit_status = $this->visit_data['order_info']['STATUS'];
        $this->visit_accept = $this->visit_data['order_info']['ACCEPT'];
        $this->visit_dealer = $this->visit_data['order_info']['diler'];
        $this->visit_date = $this->getVisitDate($this->visit_data['order_info']['VISIT_DATE']);
        $this->client_name = $this->visit_data['order_info']['FIO'];
        $this->region = $this->visit_data['address_fields']['REGION'];
        $this->area = $this->visit_data['address_fields']['AREA'];
        $this->punct = $this->visit_data['address_fields']['PUNCT'];
        $this->city = $this->visit_data['address_fields']['CITY'];
        $this->street = $this->visit_data['address_fields']['STREET'];
        $this->house = $this->visit_data['address_fields']['HOUSE'];
        $this->flat = $this->visit_data['address_fields']['FLAT'];
        $this->entrance = $this->visit_data['address_fields']['ENTRANCE'];
        $this->is_paid = $this->visit_data['order_info']['IS_PAID'];
        $this->payment_status = $this->visit_data['order_info']['CRM_PAYMENT_STATUS'];
        $this->is_dostavista = $this->is_dostavista($this->visit_data['order_info']['dostavista_order']);
        $this->products = $this->visit_data['items'];


    }

    private function is_dostavista($visit_param)
    {
        return $visit_param == 'yes';
    }

    private function getVisitDate(int $visit_date)
    {
        return ($visit_date > 0) ? date('Y-m-d H:i:s', $visit_date + 86400) : '';
    }

    private function getAgentAddress()
    {
       return (array_key_exists('db_address', $this->visit_data)) ?  $this->visit_data['db_address'] : $this->visit_data['new_address'];
    }

    private function getAgentPhone()
    {
        return (intval($this->visit_data['new_phone']) == 0) ? $this->visit_data['db_phone'] : $this->visit_data['new_phone'];
    }

    public function hasVisit($visit_id): bool
    {
        return !is_null($visit_id);
    }

    /**
     * @throws Exception
     */
    public function setVisitID($visit_id)
    {
        if($this->hasVisit($visit_id))
            $this->visit_id = $visit_id;
        else
            throw new \Exception('Заявок на текущий момент нет');

    }

    private function getVisitData()
    {
        return $this->request->postCRM($_ENV['VISIT_DATA_URL'], [
            'visit_id' => $this->visit_id
        ]);
    }
}