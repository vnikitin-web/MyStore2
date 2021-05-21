<?php

namespace MyStore2\Interfaces;

interface FieldInterface
{
    public function setHref(): void;
    public function setField(): void;
    public static function getField(): array;
}