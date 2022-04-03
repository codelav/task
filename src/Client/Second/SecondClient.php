<?php

declare(strict_types=1);

namespace App\Client\Second;

/**
 * Might be included like an independent composer package
 */
class SecondClient
{
    /**
     * Booking confirmation reference
     */
    protected const BOOKING_REFERENCE = '000004444F';

    public function __construct(array $config)
    {
        // setting up this client using config
    }

    /**
     * Mocked request getting real offers from real provider
     *
     * @param string $condition
     * @return array
     */
    public function getOffers(string $condition): array
    {
        return ['status' => 'ok', 'data' => [
            ['id' => 200500, 'price' => 600100, 'duration' => 25],
            ['id' => 200501, 'price' => 600101, 'duration' => 26],
            ['id' => 200502, 'price' => 600102, 'duration' => 27],
        ]];
    }

    /**
     * Mocked booking confirmation
     *
     * @param int $offerId
     * @return array
     */
    public function confirmBooking(int $offerId): array
    {
        return ['status' => 'ok', 'reference' => self::BOOKING_REFERENCE];
    }
}
