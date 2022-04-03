<?php

declare(strict_types=1);

namespace App\Booking\Offer;

use Symfony\Component\HttpFoundation\Request;

/**
 * Provides offer search parameters
 */
class OfferRequestParameters
{
    /**
     * @var string
     */
    public $criteria;

    /**
     * Fills properties
     *
     * @param string $criteria
     */
    public function __construct(string $criteria)
    {
        $this->criteria = $criteria;
    }

    /**
     * Creates instance and fills properties from request
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return static
     */
    public static function fromRequest(Request $request): self
    {
        return new self($request->get('criteria'));
    }
}
