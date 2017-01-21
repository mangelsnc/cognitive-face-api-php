<?php

namespace CognitiveFaceApi\Factory;

use CognitiveFaceApi\Resource\HeadPose;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HeadPoseFactory
{
    /**
     * @param $headPoseData
     * @return HeadPose
     * @throws \Exception
     */
    public static function createFromArray($headPoseData)
    {
        try {
            $headPoseData = self::isValidData($headPoseData);
        } catch (\Exception $e) {
            throw $e;
        }

        $headPose = new HeadPose(
            $headPoseData['roll'],
            $headPoseData['yaw'],
            $headPoseData['pitch']
        );

        return $headPose;
    }

    /**
     * @param $headPoseData
     * @return array
     */
    private static function isValidData($headPoseData)
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired([
            'roll',
            'yaw',
            'pitch'
        ]);

        return $resolver->resolve($headPoseData);
    }
}