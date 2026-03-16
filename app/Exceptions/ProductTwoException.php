<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ProductTwoException extends Exception
{

    /**
     * Report the exception.
     */
    public function report(): void
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(): JsonResponse
    {
        return response()->json(['error' => $this->getMessage()], 400);
    }
}
