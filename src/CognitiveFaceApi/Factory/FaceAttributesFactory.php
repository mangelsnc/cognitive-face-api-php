<?php

namespace CognitiveFaceApi\Factory;

use CognitiveFaceApi\Resource\FaceAttributes;
use CognitiveFaceApi\Resource\HeadPose;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FaceAttributesFactory
{
    /**
     * @param $faceAttributesData
     * @return FaceAttributes
     * @throws \Exception
     */
    public static function createFromArray($faceAttributesData)
    {
        try {
            $faceAttributesData = self::isValidData($faceAttributesData);
        } catch (\Exception $e) {
            throw $e;
        }

        $faceAttributes = new FaceAttributes(
            $faceAttributesData['smile'],
            $faceAttributesData['gender'],
            HeadPoseFactory::createFromArray($faceAttributesData['headPose']),
            $faceAttributesData['smile'],
            FacialHairFactory::createFromArray($faceAttributesData['facialHair']),
            $faceAttributesData['glasses']
        );

        return $faceAttributes;
    }

    /**
     * @param $faceAttributesData
     * @return array
     */
    private static function isValidData($faceAttributesData)
    {
        $resolver = new OptionsResolver();

        $resolver->setRequired([
            'age',
            'gender',
            'headPose',
            'smile',
            'facialHair',
            'glasses'
        ]);

        return $resolver->resolve($faceAttributesData);
    }
}