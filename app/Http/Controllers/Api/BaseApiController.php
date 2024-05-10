<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseApiController extends Controller
{

  public function success(
    string $message = null,
    $data = null,
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
}
