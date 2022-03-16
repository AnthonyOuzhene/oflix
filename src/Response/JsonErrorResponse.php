<?php

namespace App\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonErrorResponse extends Response 
{

    public static function sendError(string $message, int $httpCode = Response::HTTP_NOT_FOUND)
    {

        // TODO comment faire pour mutualiser / simplifier l'envoi d'erreur
        $data = [
            'error' => true,
            'message' => $message,
        ];

        return new JsonResponse(json_encode($data), $httpCode);

    }

}