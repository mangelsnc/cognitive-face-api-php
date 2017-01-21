<?php

namespace CognitiveFaceApi\Factory;

use CognitiveFaceApi\Resource\FaceRectangle;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FaceRectangleFactory
{
    /**
     * @param $faceRectangleData
     * @return FaceRectangle
     * @throws \Exception
     */
    public static function createFromArray($faceRectangleData)
    {
        try {
            $faceRectangleData = self::isValidData($faceRectangleData);
        } catch (\Exception $e) {
            throw $e;
        }

        $faceRectangle = new FaceRectangle(
            $faceRectangleData['top'],
            $faceRectangleData['left'],
            $faceRectangleData['width'],
            $faceRectangleData['height']
        );

        return $faceRectangle;
    }

    /**
     * @param $faceRectangleData
     * @return array
     */
    private static function isValidData($faceRectangleData)
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired([
            'top',
            'left',
            'width',
            'height'
        ]);

        return $resolver->resolve($faceRectangleData);
    }
}