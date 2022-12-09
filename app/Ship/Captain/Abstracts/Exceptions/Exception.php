<?php

namespace App\Ship\Captain\Abstracts\Exceptions;

use Exception as BaseException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException as SymfonyHttpException;

abstract class Exception extends SymfonyHttpException
{
    protected MessageBag $errors;

    protected const DEFAULT_STATUS_CODE = Response::HTTP_INTERNAL_SERVER_ERROR;

    protected string $environment;

    /**
     * Exception constructor.
     *
     * @param null            $message
     * @param null            $errors
     * @param null            $statusCode
     * @param int             $code
     * @param \Exception|null $previous
     * @param array           $headers
     */
    public function __construct(
        $message = null,
        $errors = null,
        $statusCode = null,
        $code = 0,
        ?BaseException $previous = null,
        $headers = []
    ) {

        // detect and set the running environment
        $this->environment = Config::get('app.env');

        $message = $this->prepareMessage($message);
        $error = $this->prepareError($errors);
        $statusCode = $this->prepareStatusCode($statusCode);

//        $this->logTheError($statusCode, $message, $code);

        parent::__construct($statusCode, $message, $previous, $headers, $code);

        $this->code = $this->evaluateErrorCode();
    }

    public function debug(string $error, bool $force = false): static
    {
        if ($error instanceof BaseException) {
            $error = $error->getMessage();
        }

        if ($this->environment != 'testing' || $force === true) {
            Log::error('[DEBUG] ' . $error);
        }

        return $this;
    }

    public function getErrors(): string
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return ! $this->errors->isEmpty();
    }

    private function logTheError(int $statusCode, string $message, int $code): void
    {
        // if not testing environment, log the error message
        if ($this->environment == 'testing') {
            return;
        }

        Log::error(
            '[ERROR] ' .
                'Status Code: ' . $statusCode . ' | ' .
                'Message: ' . $message . ' | ' .
                'Errors: ' . $this->errors . ' | ' .
                'Code: ' . $code
        );
    }

    private function prepareError($errors = null): ?MessageBag
    {
        return is_null($errors) ? new MessageBag() : $this->prepareArrayError($errors);
    }

    private function prepareArrayError(array $errors = [])
    {
        return is_array($errors) ? new MessageBag($errors) : $errors;
    }

    private function prepareMessage(?string $message = null): ?string
    {
        return is_null($message) && property_exists($this, 'message') ? $this->message : $message;
    }

    private function prepareStatusCode(?int $statusCode = null): ?int
    {
        return is_null($statusCode) ? $this->findStatusCode() : $statusCode;
    }

    private function findStatusCode(): int
    {
        return property_exists($this, 'httpStatusCode') ? $this->httpStatusCode : self::DEFAULT_STATUS_CODE;
    }

    public function overrideCustomData(string $customData): static
    {
        $this->customData = $customData;

        return $this;
    }

    public function useErrorCode(): int
    {
        return $this->code;
    }

    private function evaluateErrorCode(): int
    {
        $code = $this->useErrorCode();

        if (is_array($code)) {
            $code = 400;
        }

        return $code;
    }
}
