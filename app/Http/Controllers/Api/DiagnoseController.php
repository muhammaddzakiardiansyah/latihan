<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddDiagnoseRequest;
use App\Repositories\DiagnoseRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DiagnoseController extends Controller
{
    protected $diagnoseRepository;

    public function __construct(DiagnoseRepositoryInterface $diagnoseRepository)
    {
        $this->diagnoseRepository = $diagnoseRepository;
    }

    /**
     * @OA\Post(
     *     path="/api/diagnose",
     *     tags={"Diagnoses"},
     *     summary="Add new Diagnose",
     *     description="Endpoint to add new diagnose with name & service",
     *     operationId="addDiagnose",
     *     @OA\RequestBody(
     *          required=true,
     *          description="Request addDiagnose needed field name & service",
     *          @OA\JsonContent(
     *              required={"name", "service"},
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *                  description="validation field name: required, string, unique"
     *              ),
     *              @OA\Property(
     *                  property="service",
     *                  type="string",
     *                  description="validation field service: required, string, valid json"
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=201,
     *          description="Diagnose add successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="Diagnose add successfully"),
     *              @OA\Property(property="statusCode", type="integer", example="201"),
     *              @OA\Property(
     *                 property="data",
     *                 type="object",
        *              @OA\Property(property="id", type="integer", example="3325"),
        *              @OA\Property(property="name", type="string", example="Ringan"),
        *              @OA\Property(property="service", type="string", example="{name: 'Obat'}"),
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
    public function addDiagnose(AddDiagnoseRequest $addDiagnoseRequest): JsonResponse
    {
        $addDiagnoseRequest->validated();
        $rules = [
            'name' => $addDiagnoseRequest->name,
            'service' => $addDiagnoseRequest->service,
        ];
        $diagnose = $this->diagnoseRepository->addDiagnose($rules);

        return response()->json([
            'success' => true,
            'message' => 'Diagnose add successfully',
            'statusCode' => 201,
            'data' => $diagnose,
        ]);
    }
}
