<?php

namespace CognitiveFaceApi\Factory;

use CognitiveFaceApi\Resource\Face;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FaceFactory
{
    /**
     * @param $faceData
     * @return Face
     * @throws \Exception
     */
    public static function createFromArray($faceData)
    {
        try {
            $faceData = self::isValidData($faceData);
        } catch (\Exception $e) {
            throw $e;
        }

        $faceRectangle = new Face(
            $faceData['faceId'],
            $faceData['faceRectangle'],
            $faceData['faceAttributes']
        );

        return $faceRectangle;
    }

    /**
     * @param $faceData
     * @return array
     */
    private static function isValidData($faceData)
    {
        $resolver = new OptionsResolver();

        $resolver->setRequired('faceId');

        $resolver->setDefaults([
            'faceRectangle' => null,
            'faceAttributes' => null,
        ]);

        $resolver->setAllowedTypes('faceRectangle', 'array');
        $resolver->setAllowedTypes('faceAttributes', 'array');

        return $resolver->resolve($faceData);
    }
}