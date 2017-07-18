<?php

namespace CognitiveFaceApi\Exception;

use CognitiveFaceApi\Component\FaceManager;

class InvalidMatchModeException extends \Exception
{
    const CODE = 100;

    /**
     * InvalidMatchModeException constructor.
     */
    public function __construct()
    {
        $message = sprintf(
            'Invalid match mode. Valid Modes: %s',
            implode(', ', FaceManager::getMatchModes())
        );

        parent::__construct($message, self::CODE);
    }
}
