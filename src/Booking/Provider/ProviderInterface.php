<?php

declare(strict_types=1);

namespace App\Booking\Provider;

use App\Booking\Offer\OfferRequestParameters;

/**
 * Provides requirements for provider implementation
 */
interface ProviderInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * Receives available offers from provider
     *
     * @param \App\Booking\Offer\OfferRequestParameters $params
     * @return \App\Booking\Offer\OfferEntityInterface[]
     */
    public function getOffers(OfferRequestParameters $params): array;

    /**
     * Confirms booking and returns booking reference
     *
     * @param int $offerId
     * @return string
     */
    public function confirm(int $offerId): string;
}
