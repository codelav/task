<?php

declare(strict_types=1);

namespace App\Controller\Service;

use App\Booking\BookingServiceInterface;
use App\Booking\Offer\OfferRequestParameters;
use App\Controller\BaseController;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Providing offers by search query
 */
final class OffersController extends BaseController
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \App\Booking\BookingServiceInterface
     */
    private $bookingService;

    /**
     * Sets dependencies
     *
     * @param \Psr\Log\LoggerInterface             $logger
     * @param \App\Booking\BookingServiceInterface $bookingService
     */
    public function __construct(LoggerInterface $logger, BookingServiceInterface $bookingService)
    {
        $this->logger         = $logger;
        $this->bookingService = $bookingService;
    }

    /**
     * Provides all available offers
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        if (!$request->get('criteria')) {
            return new JsonResponse(['message' => 'Criteria parameter is required'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $params = OfferRequestParameters::fromRequest($request);
            $offers = $this->bookingService->findOffers($params);
        } catch (\Throwable $e) {
            $this->logger->error('Unable get offers', ['request_data' => $request->request->all(), 'exception' => $e]);

            return new JsonResponse(['message' => 'Unable get offers'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(['offers' => $offers]);
    }
}
