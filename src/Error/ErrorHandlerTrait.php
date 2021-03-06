<?php

namespace Biztech\CakeSentry\Error;

use Biztech\CakeSentry\Http\Client;
use Cake\Core\InstanceConfigTrait;
use ErrorException;

trait ErrorHandlerTrait
{
    /**
     * Change error messages into ErrorException and write exception log.
     *
     * @param int|string $level The level name of the log.
     * @param array $data Array of error data.
     * @return bool
     */
    protected function _logError($level, array $data): bool
    {
        $error = new ErrorException($data['description'], 0, $data['code'], $data['file'], $data['line']);

        return $this->logException($error);
    }
}
