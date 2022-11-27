<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Location;
use App\Service\WeatherUtil;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\MeteoData;
use Symfony\Component\HttpFoundation\JsonResponse;

class WeatherApiController extends AbstractController
{
    #[Route('/weather/api', name: 'app_weather_api2')]
    public function cityAction(Request $request, WeatherUtil $weatherUtil): Response
    {
        $payload = $request->getContent();
        $payload = json_decode($payload, true);

        $meteoDatas = $weatherUtil->getWeatherForCountryAndCity($payload['country'], $payload['city']);

        switch($payload['type'])
        {
            case 'json':
                $tab = ['city' => [], 'date' => [], 'highestTemperature' => []];
                foreach($meteoDatas as $meteoData)
                {
                    array_push($tab['city'], $meteoData->getLocation()->getCity());
                    array_push($tab['date'], $meteoData->getDate()->format('Y-m-d'));
                    array_push($tab['highestTemperature'], $meteoData->getHighestTemperature());
                }

                return new JsonResponse($tab);

            case 'csv':
                $tab = [];
                foreach($meteoDatas as $meteoData)
                {
                    $row = [];
                    $row['city'] = $meteoData->getLocation()->getCity();
                    $row['date'] = $meteoData->getDate()->format('Y-m-d');
                    $row['highestTemperature'] = $meteoData->getHighestTemperature();
                    array_push($tab, implode(',', $row));
                }
                $csv = "city,date,highestTemperature\n";
                $csv .= implode("\n", $tab);

                return new Response($csv);
        }
    }


    #[Route('/weather/api/{type}', name: 'app_weather_api')]
    public function cityActionTwig(Request $request, WeatherUtil $weatherUtil, string $type): Response
    {
        $meteoDatas = $weatherUtil->getWeatherForCountryAndCity($request->get('country'), $request->get('city'));

        switch($type)
        {
            case 'json':
                $tab = ['city' => [], 'date' => [], 'highestTemperature' => []];
                foreach($meteoDatas as $meteoData)
                {
                    array_push($tab['city'], $meteoData->getLocation()->getCity());
                    array_push($tab['date'], $meteoData->getDate()->format('Y-m-d'));
                    array_push($tab['highestTemperature'], $meteoData->getHighestTemperature());
                }

                return $this->render('weather_api/weather.json.twig', [
                    'meteoDatas' => $tab,
                ]);

            case 'csv':
                $tab = [];
                foreach($meteoDatas as $meteoData)
                {
                    $row = [];
                    $row['city'] = $meteoData->getLocation()->getCity();
                    $row['date'] = $meteoData->getDate()->format('Y-m-d');
                    $row['highestTemperature'] = $meteoData->getHighestTemperature();
                    array_push($tab, implode(',', $row));
                }
                $csv = "city,date,highestTemperature\n";
                $csv .= implode("\n", $tab);

                return $this->render('weather_api/weather.csv.twig', [
                    'meteoDatas' => $csv,
                ]);
        }
    }
}
