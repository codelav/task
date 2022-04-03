<?php

declare(strict_types=1);

namespace App\Controller\Service;

use App\Booking\BookingServiceInterface;
use App\Controller\BaseController;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Booking of the selected offer
 */
final class ConfirmController extends BaseController
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
     * Offer booking confirmation
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        if (!$request->get('id')) {
            return new JsonResponse(['message' => 'id parameter is required'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $reference = $this->bookingService->confirm($request->get('id'));
        } catch (\Throwable $e) {
            $this->logger->error('Unable confirm booking', ['id' => $request->get('id'), 'exception' => $e]);

            return new JsonResponse(['message' => 'Unable confirm booking. Try later'], 500);
        }

        return new JsonResponse(['reference' => $reference]);
    }
}
