<?php

namespace App\Entity;

use App\Repository\MeteoDataRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeteoDataRepository::class)]
class MeteoData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 1)]
    private ?string $highestTemperature = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 1)]
    private ?string $lowestTemperature = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: '0')]
    private ?string $averageWindSpeed = null;

    #[ORM\Column(length: 100)]
    private ?string $overcast = null;

    #[ORM\Column(length: 50)]
    private ?string $precipitationKind = null;

    #[ORM\Column(length: 100)]
    private ?string $precipitationIntensity = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 2, scale: 2)]
    private ?string $humidity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHighestTemperature(): ?string
    {
        return $this->highestTemperature;
    }

    public function setHighestTemperature(string $highestTemperature): self
    {
        $this->highestTemperature = $highestTemperature;

        return $this;
    }

    public function getLowestTemperature(): ?string
    {
        return $this->lowestTemperature;
    }

    public function setLowestTemperature(string $lowestTemperature): self
    {
        $this->lowestTemperature = $lowestTemperature;

        return $this;
    }

    public function getAverageWindSpeed(): ?string
    {
        return $this->averageWindSpeed;
    }

    public function setAverageWindSpeed(string $averageWindSpeed): self
    {
        $this->averageWindSpeed = $averageWindSpeed;

        return $this;
    }

    public function getOvercast(): ?string
    {
        return $this->overcast;
    }

    public function setOvercast(string $overcast): self
    {
        $this->overcast = $overcast;

        return $this;
    }

    public function getPrecipitationKind(): ?string
    {
        return $this->precipitationKind;
    }

    public function setPrecipitationKind(string $precipitationKind): self
    {
        $this->precipitationKind = $precipitationKind;

        return $this;
    }

    public function getPrecipitationIntensity(): ?string
    {
        return $this->precipitationIntensity;
    }

    public function setPrecipitationIntensity(string $precipitationIntensity): self
    {
        $this->precipitationIntensity = $precipitationIntensity;

        return $this;
    }

    public function getHumidity(): ?string
    {
        return $this->humidity;
    }

    public function setHumidity(string $humidity): self
    {
        $this->humidity = $humidity;

        return $this;
    }
}
