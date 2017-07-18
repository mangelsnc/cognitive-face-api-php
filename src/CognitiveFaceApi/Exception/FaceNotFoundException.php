<?php

namespace CognitiveFaceApi\Exception;


class FaceNotFoundException extends \Exception
{
    const CODE = 100;
    const MESSAGE = 'Face not found';
    /**
     * FaceNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct(self::MESSAGE, self::CODE);
    }
}
