<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseApiController extends Controller
{


 /**
  * The function `success` in PHP returns a JSON response with a success message, optional data,
  * pagination information, and a specified HTTP status code.
  * 
  * @param string message The `message` parameter in the `success` function is a string that represents
  * a success message. By default, it is set to 'Success', but can be customized by passing a
  * different string when calling the function.
  * @param data The `data` parameter in the `success` function is used to pass any additional data that
  * you want to include in the response. This data can be of any type and will be included in the JSON
  * response if it is not null.
  * @param pagination The `pagination` parameter in the `success` function is used to pass pagination
  * information along with the success response. Pagination typically includes details like the total
  * number of items, the number of items per page, the current page number, and links to navigate
  * between pages.
  * @param int code The `code` parameter in the `success` function represents the HTTP status code that
  * will be returned in the response. By default, it is set to `Response::HTTP_OK`, which corresponds
  * to the HTTP status code `200 OK`. This code indicates that the request has succeeded.
  * 
  * @return JsonResponse The `success` function is returning a JSON response with the following
  * structure:
  * - 'success' key with a boolean value of true
  * - 'message' key with the provided message or the default message based on the HTTP status code
  * - 'data' key with the provided data if it is not null
  * - 'meta' key with the provided pagination information if it is not null
  */
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

    /** Checks if data is null */
    if ($pagination !== null) {
      $responseData['meta'] = $pagination;
    }

    return response()->json($responseData, $code);
  }

  /**
   * The function `failure` returns a JSON response indicating a failure with an optional message,
   * data, and HTTP status code.
   * 
   * @param string message The `message` parameter in the `failure` function is a string that
   * represents the error message to be returned. By default, if no message is provided, it will be set
   * to 'Fail'. This message will be included in the JSON response returned by the function to indicate
   * the reason for the failure
   * @param data The `data` parameter in the `failure` function is used to pass any additional data
   * that you want to include in the response when a failure occurs. This data could be any relevant
   * information that you want to send back along with the failure message. If the `data` parameter is
   * not provided or
   * @param int code The `code` parameter in the `failure` function represents the HTTP status code
   * that will be returned in the JSON response. By default, it is set to `Response::HTTP_BAD_REQUEST`,
   * which corresponds to the HTTP status code `400`. This code indicates that the server could not
   * understand the request
   * 
   * @return JsonResponse A `JsonResponse` object is being returned with the specified data and HTTP
   * status code.
   */
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
