<?php


namespace MyStore2\Fields;


class AgentGroup implements FieldInterface
{

    private string $href;
    private array $field;

    public function setHref(): void
    {
        $this->href = $_ENV['FIELD_DEFAULT_AGENT_GROUP'];
    }

    public function setField(): void
    {
        $this->field = [
            "meta" => [
                "href" => $_ENV['MYSTORE_API_URL']."group/".$this->href,
                "type" => "group",
                "mediaType" => "application/json"
            ]
        ];
    }

    public static function getField($params = []): array
    {
        $agent_group = new self;
        $agent_group->setHref();
        $agent_group->setField();
        return $agent_group->field;
    }

}