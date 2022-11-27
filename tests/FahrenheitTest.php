<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\MeteoData;

class FahrenheitTest extends TestCase
{
    public function dataTestFahrenheit()
    {
        return [[0, 32], [10, 50], [20, 68], [30, 86], [40, 104]];
    }
    
    /**
     * @dataProvider dataTestFahrenheit
     */
    public function testFahrenheit($key, $expectedMessage)
    {
        $meteoData = new MeteoData();
        $meteoData->setHighestTemperature($key);

        $message = $meteoData->getHighestTemperatureF();
        $this->assertEquals($expectedMessage, $message, "Wynik nie jest poprawny");
    }
}
