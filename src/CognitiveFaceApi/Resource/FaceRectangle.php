<?php

namespace CognitiveFaceApi\Resource;

class FaceRectangle
{
    /**
     * @var int
     */
    private $top;

    /**
     * @var int
     */
    private $left;

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * FaceRectangle constructor.
     * @param int $top
     * @param int $left
     * @param int $width
     * @param int $height
     */
    public function __construct($top, $left, $width, $height)
    {
        $this->top = intval($top);
        $this->left = intval($left);
        $this->width = intval($width);
        $this->height = intval($height);
    }

    /**
     * @return int
     */
    public function getTop()
    {
        return $this->top;
    }

    /**
     * @return int
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    public function toArray()
    {
        return  [
            'top' => $this->top,
            'left' => $this->left,
            'width' => $this->width,
            'height' => $this->height,
        ];
    }
}