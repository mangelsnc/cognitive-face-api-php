<?php

namespace CognitiveFaceApi\Factory;

use CognitiveFaceApi\Resource\FacialHair;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FacialHairFactory
{
    /**
     * @param $facialHairData
     * @return FacialHair
     * @throws \Exception
     */
    public static function createFromArray($facialHairData)
    {
        try {
            $facialHairData = self::isValidData($facialHairData);
        } catch (\Exception $e) {
            throw $e;
        }

        $facialHair = new FacialHair(
            $facialHairData['moustache'],
            $facialHairData['beard'],
            $facialHairData['sideburns']
        );

        return $facialHair;
    }

    /**
     * @param $facialHairData
     * @return array
     */
    private static function isValidData($facialHairData)
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired([
            'moustache',
            'beard',
            'sideburns'
        ]);

        return $resolver->resolve($facialHairData);
    }
}