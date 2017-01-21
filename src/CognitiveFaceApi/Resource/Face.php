<?php

namespace CognitiveFaceApi\Resource;

use CognitiveFaceApi\Factory\FaceAttributesFactory;
use CognitiveFaceApi\Factory\FaceRectangleFactory;

class Face
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var FaceRectangle
     */
    private $faceRectangle;

    /**
     * @var FaceAttributes
     */
    private $faceAttributes;


    public function __construct($id, $faceRectangle = null, $faceAttributes = null)
    {
        $this->id = $id;

        if (null != $faceRectangle) {
            $this->faceRectangle = FaceRectangleFactory::createFromArray($faceRectangle);
        }

        if (null != $faceAttributes) {
            $this->faceAttributes = FaceAttributesFactory::createFromArray($faceAttributes);
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return FaceRectangle
     */
    public function getFaceRectangle()
    {
        return $this->faceRectangle;
    }

    /**
     * @return FaceAttributes
     */
    public function getFaceAttributes()
    {
        return $this->faceAttributes;
    }

    public function toArray()
    {
        $array = [];
        $array['id'] = $this->getId();

        if (null != $this->getFaceRectangle()) {
            $array['faceRectangle'] = $this->getFaceRectangle()->toArray();
        }

        if (null != $this->getFaceAttributes()) {
            $array['faceRectangle'] = $this->getFaceAttributes()->toArray();
        }

        return $array;
    }
}