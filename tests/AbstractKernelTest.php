<?php

namespace App\Tests;

use App\Kernel;
use App\CommandBus\Command;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Dotenv\Dotenv;

abstract class AbstractKernelTest extends KernelTestCase
{
    private static $firstRun = true;
    /** @var Connection */
    private $connection;
    /** @var EntityManager */
    protected $em;

    protected function setUp()
    {
        if (file_exists(__DIR__.'/../.env')) {
            (new Dotenv())->load(__DIR__.'/../.env');
        } else {
            (new Dotenv())->load(__DIR__.'/../.env.dist');
        }

        self::bootKernel(['environment' => getenv('APP_ENV')]);
        $this->em = self::$container->get('doctrine.orm.entity_manager');
        $this->connection = self::$container->get('doctrine.orm.entity_manager')->getConnection();
        if (self::$firstRun) {
            $this->resetDb();
            self::$firstRun = false;
        }

        $this->connection->beginTransaction();
    }

    public function tearDown()
    {
        try {
            $this->connection->rollBack();
        } catch (ConnectionException $exception) {
        }
        parent::tearDown();
    }

    protected function resetDb()
    {
        try {
            $this->connection->rollBack();
        } catch (ConnectionException $exception) {
        }
    }

    protected function runCommand(string $commandName, array $options = []) : void
    {
        $options['command'] = $commandName;
        $application = new Application(self::$kernel);
        $application->setAutoExit(false);
        $input = new ArrayInput($options);
        $output = new BufferedOutput();
        $application->run($input, $output);
    }

    protected function getContainer(): ContainerInterface
    {
        return self::$container;
    }

    protected function handleCommand(Command $command): void
    {
        self::$container->get('command_bus')->handle($command);
    }

    protected static function getKernelClass() : string
    {
        return Kernel::class;
    }
}
