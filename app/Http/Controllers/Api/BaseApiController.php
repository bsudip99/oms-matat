<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseApiController extends Controller
{

  public function success(
    string $message = 'Success',
    $data = null,
    $pagination = null,
    int $code = Response::HTTP_OK
  ): JsonResponse {

    $responseData = [
      'success' => true,
      'message' => $message ?? Response::$statusTexts[$code],
    ];

    /** Checks if data is null */
    if ($data !== null) {
      $responseData['data'] = $data;
    }
    
    return response()->json($responseData, $code);
  }

  public function failure(
    string $message = 'Fail',
    $data = null,
    int $code = Response::HTTP_BAD_REQUEST
  ): JsonResponse {

    $responseData = [
      'success' => false,
      'message' => $message ?? Response::$statusTexts[$code],
    ];

    /** Checks if data is null */
    if ($data !== null) {
      $responseData['data'] = $data;
    }
    
    return response()->json($responseData, $code);
  }

}
