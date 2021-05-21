<?php


namespace MyStore2\Fields;


class Organization implements FieldInterface
{
    private string $href;
    private array $field;

    public function setHref(): void
    {
        $this->href = $_ENV['MYSTORE_API_URL']."organization/".$_ENV['FIELD_DEFAULT_ORGANIZATION'];
    }

    public function setField(): void
    {
        $this->field = [
            "meta" => [
                "href" => $this->href,
                "type" => "organization",
                "mediaType" => "application/json"
            ]
        ];
    }

    public static function getField($params = []): array
    {
        $organization = new self;
        $organization->setHref();
        $organization->setField();
        return $organization->field;
    }
}