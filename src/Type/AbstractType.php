<?php

namespace OutlineManagerClient\Type;

class AbstractType
{
    public function __construct(array $values)
    {
        foreach ($values as $key => $value) {
            $this->$key = $value;
        }
    }
}
