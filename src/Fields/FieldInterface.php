<?php

namespace MyStore2\Fields;

interface FieldInterface
{
    public function setHref(): void;
    public function setField(): void;
    public static function getField(): array;
}