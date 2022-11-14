<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\WeatherUtil;

#[AsCommand(
    name: 'weather:cac',
    description: 'Add a short description for your command',
)]
class WeatherCacCommand extends Command
{
    private $weatherUtil;

    public function __construct(WeatherUtil $weatherUtil, string $name = null)
    {
        $this->weatherUtil = $weatherUtil;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('country', InputArgument::REQUIRED, 'Country of the wanted measurements')
            ->addArgument('city', InputArgument::REQUIRED, 'City of the wanted measurements')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $country = $input->getArgument('country');
        $city = $input->getArgument('city');

        $meteoDatas = $this->weatherUtil->getWeatherForCountryAndCity($country, $city);
        foreach($meteoDatas as $meteoData)
        {
            $output->writeln($meteoData->getDate()->format("Y-m-d") . ": " . $meteoData->getHighestTemperature());
        }


        return Command::SUCCESS;
    }
}
