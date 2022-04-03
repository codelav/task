<?php

declare(strict_types=1);

namespace App\Client\First;

/**
 * Might be included like an independent composer package
 */
class FirstClient
{
    /**
     * Booking confirmation reference
     */
    protected const BOOKING_REFERENCE = '234sdfFAS333';

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
    public function findOffers(string $condition): array
    {
        return ['status' => 'ok', 'data' => [
            ['id' => 100500, 'price' => 500100, 'duration' => 15],
            ['id' => 100501, 'price' => 500101, 'duration' => 16],
            ['id' => 100502, 'price' => 500102, 'duration' => 17],
        ]];
    }

    /**
     * Mocked booking confirmation
     *
     * @param int $offerId
     * @return array
     */
    public function book(int $offerId): array
    {
        return ['status' => 'ok', 'reference' => self::BOOKING_REFERENCE];
    }
}
