<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddServiceRequest;
use App\Repositories\ServiceRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ServiceController extends Controller
{
    protected $serviceRepository;

    public function __construct(ServiceRepositoryInterface $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * @OA\Post(
     *     path="/api/service",
     *     tags={"Services"},
     *     summary="Add new Service",
     *     description="Endpoint to add new service with name",
     *     operationId="addService",
     *     @OA\RequestBody(
     *          required=true,
     *          description="Request addService needed field name",
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *                  description="validation field name: required, string, unique"
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=201,
     *          description="Service add successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="Service add successfully"),
     *              @OA\Property(property="statusCode", type="integer", example="201"),
     *              @OA\Property(
     *                 property="data",
     *                 type="object",
        *              @OA\Property(property="id", type="integer", example="9345"),
        *              @OA\Property(property="name", type="string", example="Kontrol"),
        *              @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-09 07:59:39"),
        *              @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-09 07:59:39")
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *      response=422,
     *      description="Unprocessable content",
     *      @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="message field error"),
     *          @OA\Property(property="errors", type="object", example="{}")
     *      )
     *     ),
     *     @OA\Response(
     *      response=404,
     *      description="Route not found",
     *      @OA\JsonContent(
     *          @OA\Property(property="success", type="boolean", example="false"),
     *          @OA\Property(property="message", type="string", example="Route not found"),
     *          @OA\Property(property="statusCode", type="integer", example="404")
     *      )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function addService(AddServiceRequest $addServiceRequest): JsonResponse
    {
        $addServiceRequest->validated();
        $rules = [
            'name' => $addServiceRequest->name,
        ];
        $service = $this->serviceRepository->addService($rules);

        return response()->json([
            'success' => true,
            'message' => 'Service add successfully',
            'statusCode' => 201,
            'data' => $service,
        ], 201);
    }
}
