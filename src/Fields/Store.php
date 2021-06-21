<?php


namespace MyStore2\Fields;


class Store
{

    private string $href;
    private array $field;

    public function setHref($is_dostavista): void
    {
        $this->href = $_ENV['MYSTORE_API_URL']."store/".$_ENV['FIELD_DEFAULT_STORE'];

        if($is_dostavista)
            $this->href = $_ENV['MYSTORE_API_URL']."store/".$_ENV['FIELD_STORE_FF'];
    }

    public function setField(): void
    {
        $this->field = [
            "meta" => [
                "href" => $this->href,
                "type" => "store",
                "mediaType" => "application/json"
            ]
        ];
    }

    public static function getField($params): array
    {
        $store = new self;
        $store->setHref($params['visit']->is_dostavista);
        $store->setField();
        return $store->field;
    }
}