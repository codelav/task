<?php

declare(strict_types=1);

namespace App\Booking\Offer;

use App\Booking\Provider\ProviderInterface;

interface OfferEntityInterface
{
    public function getId(): int;
    public function getPrice(): int;
    public function getDuration(): int;
    public function getProvider(): ProviderInterface;
}
