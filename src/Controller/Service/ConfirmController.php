<?php
declare(strict_types=1);
namespace App\Controller\Service;

use App\Controller\BaseController;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Booking of the selected offer
 */
class ConfirmController extends BaseController
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * Sets dependencies
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Offer booking confirmation
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse(['confirm' => $request->getClientIp()]);
    }
}
