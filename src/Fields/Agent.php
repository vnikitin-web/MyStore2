<?php


namespace MyStore2\Fields;
use MyStore2\Fields\AgentGroup;

class Agent implements FieldInterface
{
    private string $href;
    private array $field;
    private bool $has_agent = false;
    private string $agent_id = '';
    private array $agent_data = [];


    public function setHref():void
    {
        $this->href = $_ENV['MYSTORE_API_URL']."counterparty/".$this->agent_id;
    }

    public function setField():void
    {
        $this->field = [
            "meta" => [
                "href" => $this->href,
                "type" => "counterparty",
                "mediaType" => "application/json"
            ]
        ];

    }

    private function createAgent($params)
    {

        $this->agent_data = $params['visit']->request->postEntity(
            'counterparty',
            [
                "name" => $params['visit']->visit_data['order_info']['FIO'],
                "phone" => $params['visit']->client_phone,
                "actualAddress" => $params['visit']->client_address,
                "group" => AgentGroup::getField($params),
                "companyType"  => "individual",
                "tags" => [
                    'da maestri'
                ]
            ]
        );

        $this->agent_id = $this->agent_data['id'];

    }

    private function setAgentData($params)
    {
        $agents = $params['visit']->request->getEntity('counterparty', '', '?filter=phone='.$params['visit']->client_phone);
        if($agents['meta']['size'] > 0){
            $this->has_agent = true;
            $this->agent_id = $agents['rows'][0]['id'];
            $this->agent_data = $agents['rows'][0];
        }else{
            $this->createAgent($params);
        }
    }

    public static function getField($params = []): array
    {
        $agent = new self;
        $agent->setAgentData($params);
        $agent->setHref();
        $agent->setField();
        return $agent->field;

    }
}