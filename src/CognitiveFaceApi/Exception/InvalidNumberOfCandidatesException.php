<?php

namespace CognitiveFaceApi\Exception;

class InvalidNumberOfCandidatesException extends \Exception
{
    const CODE = 100;

    /**
     * InvalidNumberOfCandidatesException constructor.
     * @param string $min
     * @param int $max
     */
    public function __construct($min, $max)
    {
        $message = sprintf('The valid range of candidates is [%s - %s]', $min, $max);

        parent::__construct($message, self::CODE);
    }
}
