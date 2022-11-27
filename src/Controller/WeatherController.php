<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Location;
use App\Service\WeatherUtil;

class WeatherController extends AbstractController
{
    public function cityAction(string $country, string $city, WeatherUtil $weatherUtil): Response
    {
        $meteoDatas = $weatherUtil->getWeatherForCountryAndCity($country, $city);
        
        return $this->render('weather/city.html.twig', [
            'country' => $country,
            'city' => $city,
            'meteoDatas' => $meteoDatas,
        ]);
    }
}