<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    protected $statusCode = Response::HTTP_OK;

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function respond($data, $headers = [])
    {
        return response($data, $this->getStatusCode(), $headers);
    }

    public function respondWithData($data)
    {
        return $this->respond([
            'data' => $data,
        ]);
    }

    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message'     => $message,
                'status_code' => $this->getStatusCode(),
            ]
        ]);
    }

    public function respondSuccess($message = '')
    {
        return $this->respond(compact('message'));
    }

    public function respondCreatedSuccessfully($message = '')
    {
        return $this->setStatusCode(Response::HTTP_CREATED)->respond(compact('message'));
    }

    public function respondNotFound($message = 'Not Found.')
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respondWithError($message);
    }

    public function respondValidationFailed($message = 'Validation failed for the resource.')
    {
        return $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)->respondWithError($message);
    }

    public function respondInternalError($message = 'Internal Error.')
    {
        return $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

    public function validateApiRequestFails(Request $request, $rules = [])
    {
        return Validator::make($request->all(), $rules)->fails();
    }
}
