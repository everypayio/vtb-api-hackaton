<?php declare(strict_types=1);

namespace App\State\Exceptions;

use Exception;
use Throwable;

class InvalidStateException extends Exception
{
    /**
     * InvalidStateException constructor.
     *
     * @param string $id
     * @param string $message
     * @param int $code
     * @param ?Throwable $previous
     */
    public function __construct(
        protected readonly string $id,
        string                    $message = 'Invalid state',
        int                       $code = 0,
        ?Throwable                $previous = null,
    )
    {
        parent::__construct($message, $code, $previous);
    }
}
