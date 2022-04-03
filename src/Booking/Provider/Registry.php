<?php

declare(strict_types=1);

namespace App\Booking\Provider;

/**
 * Stores active providers
 */
class Registry
{
    /**
     * @var \App\Booking\Provider\ProviderInterface[]
     */
    protected $providers = [];

    /**
     * Adds a provider to the registry
     *
     * @param string                                  $name
     * @param \App\Booking\Provider\ProviderInterface $provider
     */
    public function add(string $name, ProviderInterface $provider): void
    {
        $this->providers[$name] = $provider;
    }

    /**
     * Gets a provider by name
     *
     * @param string $name
     * @return \App\Booking\Provider\ProviderInterface
     */
    public function get(string $name): ProviderInterface
    {
        return $this->providers[$name] ?? throw new \InvalidArgumentException('Provider does not exist: ' . $name);
    }
}
