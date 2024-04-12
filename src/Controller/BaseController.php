<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractController
{

    protected function apiResponse($data, int $status = Response::HTTP_OK, array $headers = []): JsonResponse
    {
        return new JsonResponse($data, $status, $headers);
    }

    protected function apiError($message, int $status = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        $data = [
            'error' => $message,
            'code' => $status
        ];
        return $this->apiResponse($data, $status);
    }

    protected function getRequestData(Request $request)
    {
        return json_decode($request->getContent(), true);
    }
}