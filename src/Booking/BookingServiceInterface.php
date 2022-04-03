<?php

declare(strict_types=1);

namespace App\Booking;

use App\Booking\Offer\OfferRequestParameters;

/**
 * Service providing booking
 */
interface BookingServiceInterface
{
    /**
     * Finds available offers
     *
     * @param \App\Booking\Offer\OfferRequestParameters $parameters
     * @return array
     */
    public function findOffers(OfferRequestParameters $parameters): array;

    /**
     * Confirms specified offer
     *
     * @param string $id
     * @return string
     */
    public function confirm(string $id): string;
}
