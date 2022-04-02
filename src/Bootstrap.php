<?php
declare(strict_types=1);
namespace App;

use App\Controller\Service\OffersController;
use App\Controller\Service\ConfirmController;
use DI\Container;
use DI\ContainerBuilder;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

/**
 * Initialization of required services
 */
class Bootstrap
{
    /**
     * Dependency Injection Container
     *
     * @var \DI\Container
     */
    protected $di;

    /**
     * Application settings
     *
     * @var \App\Config
     */
    protected $config;

    /**
     * Builds DI container
     *
     * @throws \Exception
     */
    public function __construct(Config $config)
    {
        $this->config = $config;

        $builder = new ContainerBuilder();
        $builder->addDefinitions($this->getServices());

        $this->di = $builder->build();
    }

    /**
     * @see \App\Bootstrap::$di
     *
     * @return \DI\Container
     */
    public function getDi(): Container
    {
        return $this->di;
    }

    /**
     * Setting up DI services
     *
     * @return \Closure[]
     */
    protected function getServices(): array
    {
        return [
            OffersController::class  => \DI\autowire(),
            ConfirmController::class => \DI\autowire(),
            LoggerInterface::class   => function () {
                $config = $this->config->get('logger');
                $logger = new Logger('logs');

                $fileHandler = new StreamHandler($config->get('path'), $config->get('level'));
                $fileHandler->setFormatter(new LineFormatter());
                $logger->pushHandler($fileHandler);

                return $logger;
            },

            'logger' => \DI\get(LoggerInterface::class),
        ];
    }
}
