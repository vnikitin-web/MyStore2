<?php


namespace MyStore2\Entities;
use MyStore2\Fields\Agent;
use MyStore2\Fields\Attributes;
use MyStore2\Fields\Group;
use MyStore2\Fields\Organization;
use MyStore2\Fields\Positions;
use MyStore2\Fields\State;
use MyStore2\Fields\Store;
use MyStore2\Http\Request;

class Order
{
    private Request $request;
    private Visit $visit;
    public bool $is_posted = false;
    public string $order_id = '';
    public array $order_data = [];
    public string $state_id = '';
    private array $fields;
    private bool $applicable = false;

    public function __construct($request, $visit)
    {
        $this->request = $request;
        $this->visit = $visit;
        $this->setOrderData();
    }

    public function saveOrder($result)
    {
        if(!$this->is_posted){
            $this->request->postCRM($_ENV['API2_CRM_URL'], [
                'action' => 'MyStore/saveOrder',
                'visit_id' => $this->visit->visit_id,
                'order_id' => $result['id']
            ]);
        }
    }

    private function updateOrder()
    {
        return $this->request->putEntity('customerorder', $this->order_id, $this->fields);
    }

    private function createOrder()
    {
        return $this->request->postEntity('customerorder', $this->fields);
    }

    public function add(){
        return ($this->is_posted) ? $this->updateOrder() : $this->createOrder();
    }

    private function setOrderID($order_id)
    {
        $this->order_id = $order_id;
    }

    private function getIdFromHref($href): string
    {
        $elements = explode('/', $href);
        return $elements[count($elements) - 1];
    }

    public function setOrderData()
    {
        $orders = $this->request->getEntity(
            'customerorder',
            '',
            '?search=crm_'.$this->visit->visit_id
        );

        if($orders['meta']['size'] > 0){
            $this->is_posted = true;
            $this->order_id = $orders['rows'][0]['id'];
            $this->order_data = $orders['rows'][0];
            $this->state_id = $this->getIdFromHref($this->order_data['state']['meta']['href']);
            $this->applicable = $orders['rows'][0]['applicable'];

        }
    }

    private function getMoment()
    {
        return ($this->is_posted) ? $this->order_data['moment'] : date('Y-m-d H:i:s');
    }

    private function setParams(): array
    {
        $params = [];
        $params['visit'] = $this->visit;

        if($this->is_posted){
            $params['order'] = $this;
        }

        return $params;
    }

    public function setOrderFields()
    {
        $params = $this->setParams();

        $this->fields = [
            "name" => "crm_".$this->visit->visit_id,
            "organization" => Organization::getField($params),
            "moment" => $this->getMoment(),
            "applicable" => false,
            "vatEnabled" => false,
            "group" => Group::getField($params),
            "agent" => Agent::getField($params),
            "state" => State::getField($params),
            "attributes" => Attributes::getAttributes($params),
            "positions" => Positions::getPositions($params),
            "store" => Store::getField($params),
            "applicable" => $this->applicable
        ];

        //print_r($params['visit']->visit_data);
        //print_r($this->fields);

    }

}