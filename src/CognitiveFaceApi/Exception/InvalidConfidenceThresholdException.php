<?php

namespace CognitiveFaceApi\Exception;


class InvalidConfidenceThresholdException extends \Exception
{
    const CODE = 100;

    /**
     * InvalidConfidenceThresholdException constructor.
     * @param string $min
     * @param int $max
     */
    public function __construct($min, $max)
    {
        $message = sprintf('The valid range for the confidence threshold is [%s - %s]', $min, $max);

        parent::__construct($message, self::CODE);
    }
}
