<?php
declare(strict_types=1);

namespace Biztech\CakeSentry\Test\TestCase\Log\Engine;

use Biztech\CakeSentry\Http\Client;
use Biztech\CakeSentry\Log\Engine\SentryLog;
use Cake\Core\Configure;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

final class SentryLogTest extends TestCase
{
    /** @var SentryLog */
    private $subject;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        Configure::write('Sentry.dsn', 'https://yourtoken@example.com/yourproject/1');
        $subject = new SentryLog([]);

        $clientMock = $this->createMock(Client::class);
        $this->subject = $subject;

        $clientProp = $this->getClientProp();
        $clientProp->setValue($this->subject, $clientMock);
    }

    /**
     * Test for log()
     */
    public function testLog()
    {
        $level = E_USER_ERROR;
        $message = 'something wrong';
        $context = [];

        $client = $this->getClientProp()->getValue($this->subject);
        $client->expects($this->once())
            ->method('capture')
            ->with($level, $message, $context);

        $this->subject->log($level, $message, $context);
    }

    /**
     * Helper access subject::$client(reflection)
     *
     * @return ReflectionProperty Client reflection
     */
    private function getClientProp()
    {
        $clientProp = new ReflectionProperty($this->subject, 'client');
        $clientProp->setAccessible(true);

        return $clientProp;
    }
}
