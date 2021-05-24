<?php


namespace MyStore2\Fields;


class State implements FieldInterface
{
    private string $href;
    private array $field;
    private string $state_id;

    public function setHref(): void
    {
        $this->href = $_ENV['MYSTORE_API_URL']."customerorder/metadata/states/".$this->state_id;
    }

    private function getStateID($params): string
    {

        if($params['visit']->visit_status == 3 || $params['visit']->visit_accept == 3){
            return $_ENV['FIELD_CANCEL_STATUS'];
        }

        if(array_key_exists('order', $params)){
            if($params['order']->state_id !== ''){
                return $params['order']->state_id;
            }
        }


        return $_ENV['FIELD_NEW_STATUS'];

    }

    public function setField(): void
    {
        $this->field = [
            "meta" => [
                "href" => $this->href,
                "type" => "state",
                "mediaType" => "application/json"
            ]
        ];
    }

    public static function getField($params = []): array
    {
        $state = new self;
        $state->state_id = $state->getStateID($params);
        $state->setHref();
        $state->setField();
        return $state->field;
    }
}