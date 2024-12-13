<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddPatientRequest;
use App\Repositories\PatientRepositoryInterface;
use Illuminate\Http\JsonResponse;


/**
* @OA\Info(
* title="Ke Klinik REST ful API Documentation",
* version="1.0.0",
* description="Description endpoint rest full api project ke klinik"
* )
*/
class PatientController extends Controller
{
    protected $patientRepository;

    public function __construct(PatientRepositoryInterface $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    /**
     * @OA\Post(
     *     path="/api/patient",
     *     tags={"Patients"},
     *     summary="Add new Patient",
     *     description="Endpoint to add new patien with name",
     *     operationId="addPatient",
     *     @OA\RequestBody(
     *          required=true,
     *          description="Request addPatient needed field name",
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
     *          description="Patient add successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="Patient add successfully"),
     *              @OA\Property(property="statusCode", type="integer", example="201"),
     *              @OA\Property(
     *                 property="data",
     *                 type="object",
        *              @OA\Property(property="id", type="integer", example="1325"),
        *              @OA\Property(property="name", type="string", example="abimantra"),
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
    public function addPatient(AddPatientRequest $addPatientRequest): JsonResponse
    {
        $addPatientRequest->validated();
        $rules = [
            'name' => $addPatientRequest->name,
        ];
        $patient = $this->patientRepository->addPatient($rules);

        return response()->json([
            'success' => true,
            'message' => 'Patient add successfully',
            'data' => $patient,
        ]);
    }
}
