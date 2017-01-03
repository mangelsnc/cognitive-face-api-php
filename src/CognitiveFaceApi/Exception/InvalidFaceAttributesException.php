<?php

namespace CognitiveFaceApi\Exception;

class InvalidFaceAttributesException extends \Exception
{
    const CODE = 100;

    public function __construct($attributes)
    {
        $attributes = str_replace(',', ', ', $attributes);
        $message = sprintf('One or many of these attributes are not valid: %s', $attributes);

        parent::__construct($message, self::CODE);
    }
}
