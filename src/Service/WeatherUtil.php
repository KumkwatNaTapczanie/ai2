<?php

namespace App\Service;

use App\Entity\Location;
use App\Entity\MeteoData;
use App\Repository\LocationRepository;
use App\Repository\MeteoDataRepository;

class WeatherUtil
{
    private $locationRepository;
    private $meteoDataRepository;

    public function __construct(LocationRepository $locationRepository, MeteoDataRepository $meteoDataRepository)
    {
        $this->locationRepository = $locationRepository;
        $this->meteoDataRepository = $meteoDataRepository;
    }

    public function getWeatherForCountryAndCity($country, $city)
    {
        $location = $this->locationRepository->findByCountryAndCity($country, $city)[0];
        return $this->getWeatherForLocation($location);
    }

    public function getWeatherForLocation($location)
    {
        return $this->meteoDataRepository->findByLocation($location);
    }
}
