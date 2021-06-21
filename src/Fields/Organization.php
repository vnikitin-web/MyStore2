<?php


namespace MyStore2\Fields;


class Organization implements \MyStore2\Interfaces\FieldInterface
{
    private string $href;
    private array $field;
    private string $organization_id;

    public function setHref(): void
    {
        $this->href = $_ENV['MYSTORE_API_URL']."organization/".$this->organization_id;
    }

    private function setOrganizationID($supplier)
    {

        switch ($supplier){
            case 2:
                $this->organization_id = $_ENV['FIELD_ORGANIZATION_GTK'];
                break;
            case 3:
                $this->organization_id = $_ENV['FIELD_ORGANIZATION_ODINOKOV'];
                break;
            default:
                $this->organization_id = $_ENV['FIELD_DEFAULT_ORGANIZATION'];
                break;
        }

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
        $organization->setOrganizationID($params['visit']->supplier);
        $organization->setHref();
        $organization->setField();
        return $organization->field;
    }
}
