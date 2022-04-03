<?php

declare(strict_types=1);

namespace App\Booking;

use App\Booking\Exception\InvalidOffer;
use App\Booking\Offer\OfferRequestParameters;
use App\Booking\Provider\Registry as ProviderRegistry;
use Psr\Log\LoggerInterface;

class BookingService implements BookingServiceInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var \App\Booking\Provider\Registry
     */
    protected $providerRegistry;

    /**
     * Available providers. Might be get from database
     */
    protected const ENABLED_PROVIDERS = ['first', 'second'];

    /**
     * Sets dependencies
     *
     * @param \Psr\Log\LoggerInterface       $logger
     * @param \App\Booking\Provider\Registry $providerRegistry
     */
    public function __construct(LoggerInterface $logger, ProviderRegistry $providerRegistry)
    {
        $this->logger           = $logger;
        $this->providerRegistry = $providerRegistry;
    }

    /**
     * {@inheritDoc}
     *
     * @param \App\Booking\Offer\OfferRequestParameters $parameters
     * @return array
     */
    public function findOffers(OfferRequestParameters $parameters): array
    {
        $offers = [];

        foreach (self::ENABLED_PROVIDERS as $providerName) {
            $provider = $this->providerRegistry->get($providerName);
            $offers[] = $provider->getOffers($parameters);
        }

        return array_merge(...$offers);
    }

    /**
     * {@inheritDoc}
     *
     * @param string $id
     * @throws \App\Booking\Exception\InvalidOffer
     */
    public function confirm(string $id): string
    {
        [$providerName, $offerId] = explode('::', $id);

        if (!$providerName || !$offerId) {
            throw new InvalidOffer('Invalid offer provided');
        }

        return $this->providerRegistry->get($providerName)->confirm((int) $offerId);
    }
}
