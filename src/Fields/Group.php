<?php


namespace MyStore2\Fields;


class Group implements FieldInterface
{
    private string $href;
    private array $field;

    public function setHref(): void
    {
        $this->href = $_ENV['MYSTORE_API_URL']."group/".$_ENV['FIELD_DEFAULT_GROUP'];
    }

    public function setField(): void
    {
        $this->field = [
            "meta" => [
                "href" => $this->href,
                "type" => "group",
                "mediaType" => "application/json"
            ]
        ];
    }

    public static function getField($params = []): array
    {
        $group = new self;
        $group->setHref();
        $group->setField();
        return $group->field;
    }
}