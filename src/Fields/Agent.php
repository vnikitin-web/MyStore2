<?php


namespace MyStore2\Fields;
use MyStore2\Fields\AgentGroup;

class Agent implements \MyStore2\Interfaces\FieldInterface
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

    private function getClientType($type)
    {
        if($type == '02')
            return 'legal';

        return 'individual';
    }

    private function getCompany($fio)
    {
        $parts = explode("/", $fio);

        if(count($parts) > 1)
            return trim($parts[1]);

        $code_match = array('-', '"', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '{', '}', '|', ':', '"', '<', '>', '?', '[', ']', ';', "'", ',', '.', '/', '', '~', '`', '=');
        $new_fio = str_replace($code_match, '', $parts[0]);

        return $new_fio;
    }

    private function getCRMID($client_id)
    {
        return [
            "meta" => [
                "href" => $_ENV['MYSTORE_API_URL']."counterparty/metadata/attributes/".$_ENV['ATTR_CLIENT_CRM_ID'],
                "type" => "attributemetadata",
                "mediaType" => "application/json"
            ],
            "id" => $_ENV['ATTR_CLIENT_CRM_ID'],
            "name" => "crm_id",
            "type" => "string",
            "value" => "{$client_id}"
        ];
    }

    private function createAgent($params)
    {

        $new_agent = [
            "name" => $this->getCompany($params['visit']->visit_data['order_info']['FIO']),
            "phone" => $params['visit']->client_phone,
            "actualAddress" => $params['visit']->client_address,
            "group" => AgentGroup::getField($params),
            "companyType"  => $this->getClientType($params['visit']->client_type),
            "tags" => [
                'da maestri'
            ],
            "attributes" => []
        ];

        if($params['visit']->client_id !== 0)
            $new_agent['attributes'][] = $this->getCRMID($params['visit']->client_id);

        $this->agent_data = $params['visit']->request->postEntity(
            'counterparty',
            $new_agent
        );

        $this->agent_id = $this->agent_data['id'];

    }

    private function getFilter($params)
    {
        if($params['visit']->client_id !== 0)
            return "?filter=".$_ENV['MYSTORE_API_URL']."counterparty/metadata/attributes/".$_ENV['ATTR_CLIENT_CRM_ID']."=".$params['visit']->client_id;

        if($params['visit']->visit_inn !== 'empty')
            return '?filter=inn='.$params['visit']->visit_inn;

        if($params['visit']->visit_inn !== 'empty')
            return '?filter=inn='.$params['visit']->client_inn;

        return '?filter=phone='.$params['visit']->client_phone;
    }

    private function setAgentData($params)
    {
        $agents = $params['visit']->request->getEntity('counterparty', '', $this->getFilter($params));

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
