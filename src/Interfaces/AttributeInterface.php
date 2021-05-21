<?php

namespace MyStore2\Interfaces;

interface AttributeInterface
{
    public function getAttributeValue($params);
    public function getAttributeParams(): array;
    public static function getAttribute(array $params): array;
}