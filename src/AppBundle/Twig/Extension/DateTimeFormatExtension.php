<?php

namespace AppBundle\Twig\Extension;

/*
 * Returns date time object formatted
 */
class DateTimeFormatExtension extends \Twig_Extension
{
    public function __construct()
    {
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('format_date_time', [$this, 'formatDateTime'], [])
        ];
    }

    public function formatDateTime($dateTime, $format = "Y-m-d H:i:s")
    {
        if (!($dateTime instanceof \DateTime)) {
            $dateTime = new \DateTime($dateTime);
        }

        return $dateTime->format($format);
    }

    public function getName()
    {
        return 'twig_format_date_time_extension';
    }
}
