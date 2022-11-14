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
use App\Repository\LocationRepository;

#[AsCommand(
    name: 'weather:lid',
    description: 'Add a short description for your command',
)]
class WeatherLidCommand extends Command
{
    private $weatherUtil;
    private $locationRepository;

    public function __construct(WeatherUtil $weatherUtil, LocationRepository $locationRepository, string $name = null)
    {
        $this->weatherUtil = $weatherUtil;
        $this->locationRepository = $locationRepository;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('locationId', InputArgument::REQUIRED, 'Id of a location of the wanted measurements')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $locationId = $input->getArgument('locationId');
        $location = $this->locationRepository->findById($locationId)[0];

        $meteoDatas = $this->weatherUtil->getWeatherForLocation($location);
        foreach($meteoDatas as $meteoData)
        {
            $output->writeln($meteoData->getDate()->format("Y-m-d") . ": " . $meteoData->getHighestTemperature());
        }

        return Command::SUCCESS;
    }
}
