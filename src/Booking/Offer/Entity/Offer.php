<?php

declare(strict_types=1);

namespace App\Booking\Offer\Entity;

use App\Booking\Offer\OfferEntityInterface;
use App\Booking\Provider\ProviderInterface;

class Offer implements OfferEntityInterface, \JsonSerializable
{
    protected $id;

    protected $price;

    protected $duration;

    protected $provider;

    public function __construct(int $id, int $price, int $duration, ProviderInterface $provider)
    {
        $this->id       = $id;
        $this->price    = $price;
        $this->duration = $duration;
        $this->provider = $provider;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function getProvider(): ProviderInterface
    {
        return $this->provider;
    }

    public function jsonSerialize(): array
    {
        return [
            'id'       => sprintf('%s::%s', $this->provider->getName(), $this->id),
            'price'    => $this->price,
            'duration' => $this->duration,
        ];
    }
}
