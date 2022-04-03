<?php

declare(strict_types=1);

namespace App\Booking\Provider\Adapter;

use App\Booking\Exception\BookingConfirmationFailed;
use App\Booking\Offer\Entity\Offer as OfferEntity;
use App\Booking\Offer\OfferRequestParameters;
use App\Booking\Provider\ProviderInterface;
use App\Client\Second\SecondClient;
use Psr\Log\LoggerInterface;

class SecondProvider implements ProviderInterface
{
    protected $name;

    protected $client;

    protected $logger;

    public function __construct(string $name, SecondClient $client, LoggerInterface $logger)
    {
        $this->name   = $name;
        $this->client = $client;
        $this->logger = $logger;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param \App\Booking\Offer\OfferRequestParameters $params
     * @return \App\Booking\Offer\Entity\Offer[]
     */
    public function getOffers(OfferRequestParameters $params): array
    {
        $offers = $this->client->getOffers($this->transformParams($params));

        return $this->hydrateResponse($offers);
    }

    /**
     * @param int $offerId
     * @return string
     * @throws \App\Booking\Exception\BookingConfirmationFailed
     */
    public function confirm(int $offerId): string
    {
        $response = $this->client->confirmBooking($offerId);

        if ($response['status'] === 'ok') {
            return $response['reference'];
        }

        $this->logger->notice(
            '[FirstClient] Booking confirmation error',
            ['response' => $response, 'offer' => $offerId]
        );

        throw new BookingConfirmationFailed($response['error'] ?? 'Could not confirm order #' . $offerId);
    }

    /**
     * @param array $response
     * @return \App\Booking\Offer\Entity\Offer[]
     */
    protected function hydrateResponse(array $response): array
    {
        $offers = [];

        foreach ($response['data'] as $offer) {
            $offers[] = new OfferEntity($offer['id'], $offer['price'], $offer['duration'], $this);
        }

        return $offers;
    }

    /**
     * Makes some transformations to adopt search query
     *
     * @param \App\Booking\Offer\OfferRequestParameters $parameters
     * @return string
     */
    protected function transformParams(OfferRequestParameters $parameters): string
    {
        return 'search params' . $parameters->criteria;
    }
}
