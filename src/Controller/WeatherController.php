<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Location;use App\Repository\MeteoDataRepository;

class WeatherController extends AbstractController
{
    public function cityAction(Location $city, MeteoDataRepository $meteoDataRepository): Response
    {
        $meteoDatas = $meteoDataRepository->findByLocation($city);
        
        return $this->render('weather/city.html.twig', [
            'location' => $city,
            'meteoDatas' => $meteoDatas,
        ]);
    }
}