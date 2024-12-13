<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddAppointmentRequest;
use App\Http\Requests\EditAppointmentRequest;
use App\Jobs\AddCheckupProgress;
use App\Models\Appointment;
use App\Repositories\AppointmentRepositoryInterface;
use Illuminate\Http\JsonResponse;

class AppointmentController extends Controller
{
    protected $appointmentRepository;

    public function __construct(AppointmentRepositoryInterface $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

     /**
     * @OA\Post(
     *     path="/api/appointment",
     *     tags={"Appointments"},
     *     summary="Add new Appointment",
     *     description="Endpoint to add new appointment with patient_id & diagnose_id",
     *     operationId="addAppointment",
     *     @OA\RequestBody(
     *          required=true,
     *          description="Request addAppointment needed patient_id & diagnose_id",
     *          @OA\JsonContent(
     *              required={"patient_id", "diagnose_id"},
     *              @OA\Property(
     *                  property="patient_id",
     *                  type="integer",
     *                  description="validation field patient_id: required, integer"
     *              ),
     *              @OA\Property(
     *                  property="diagnose_id",
     *                  type="integer",
     *                  description="validation field diagnose_id: required, integer"
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=201,
     *          description="Appointment add successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="Appointment add successfully"),
     *              @OA\Property(property="statusCode", type="integer", example="201"),
     *              @OA\Property(
     *                 property="data",
     *                 type="object",
        *              @OA\Property(property="id", type="integer", example="3325"),
        *              @OA\Property(property="patient_id", type="integer", example="3456"),
        *              @OA\Property(property="diagnose_id", type="integer", example="3475"),
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
    public function addAppointment(AddAppointmentRequest $addAppointmentRequest): JsonResponse
    {
        $addAppointmentRequest->validated();
        $rules = [
            'patient_id' => $addAppointmentRequest->patient_id,
            'diagnose_id' => $addAppointmentRequest->diagnose_id,
        ];
        $appointment = $this->appointmentRepository->addAppointment($rules);

        $findAppointment = $this->appointmentRepository->getDetailAppointment($appointment->id);

        $findAppointmentServiceId = json_decode($findAppointment->diagnose->service, true);

        AddCheckupProgress::dispatch([
            'appointment_id' => $appointment->id,
            'service_id' => $findAppointmentServiceId['id'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Appointment add successfully',
            'statusCode' => 201,
            'data' => $appointment,
        ], 201);
    }

     /**
     * @OA\Get(
     *     path="/api/appointment/{id}",
     *     tags={"Appointments"},
     *     summary="Get detail Appointment by id",
     *     description="Endpoint to get detail appointment with id appointment",
     *     operationId="getDetailAppointment",
     *     @OA\Parameter(
     *          name="id",
     *          description="id appointment",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Appointment add successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="Get detail appointmen successfully"),
     *              @OA\Property(property="statusCode", type="integer", example="200"),
     *              @OA\Property(
     *                 property="data",
     *                 type="object",
        *              example="{}"
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *      response=404,
     *      description="Appointment not found",
     *      @OA\JsonContent(
     *          @OA\Property(property="success", type="boolean", example="false"),
     *          @OA\Property(property="message", type="string", example="Appointment not found"),
     *          @OA\Property(property="statusCode", type="integer", example="404"),
     *          @OA\Property(property="data", type="object", example="[]")
     *      )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function getDetailAppointment(string $id): JsonResponse
    {
        $detailAppointment = $this->appointmentRepository->getDetailAppointment($id);

        if(!$detailAppointment) {
            return response()->json([
                'success' => false,
                'message' => 'Appointment not found:(',
                'statusCode' => 404,
                'data' => [],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get detail appointment successfully',
            'statusCode' => 200,
            'data' => $detailAppointment,
        ], 200);
    }

    /**
     * @OA\Patch(
     *     path="/api/appointment/{id}",
     *     tags={"Appointments"},
     *     summary="Edit Appointment",
     *     description="Endpoint to edit appointment with patient_id, diagnose_id & status",
     *     operationId="editAppointment",
     *     @OA\Parameter(
     *          name="id",
     *          description="id appointment",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          description="Request addAppointment needed patient_id, diagnose_id & status",
     *          @OA\JsonContent(
     *              required={"patient_id", "diagnose_id", "status"},
     *              @OA\Property(
     *                  property="patient_id",
     *                  type="integer",
     *                  description="validation field patient_id: required, integer"
     *              ),
     *              @OA\Property(
     *                  property="diagnose_id",
     *                  type="integer",
     *                  description="validation field diagnose_id: required, integer"
     *              ),
     *              @OA\Property(
     *                  property="status",
     *                  type="integer",
     *                  description="validation field service: required, only 0 or 1"
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Appointment edit successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="Appointment edit successfully"),
     *              @OA\Property(property="statusCode", type="integer", example="200"),
     *              @OA\Property(
     *                 property="data",
     *                 type="object",
        *              example="{}"
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
     *      description="Appointment not found",
     *      @OA\JsonContent(
     *          @OA\Property(property="success", type="boolean", example="false"),
     *          @OA\Property(property="message", type="string", example="Appointment not found"),
     *          @OA\Property(property="statusCode", type="integer", example="404"),
     *          @OA\Property(property="data", type="object", example="[]")
     *      )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function editAppointment(EditAppointmentRequest $editAppointmentRequest, string $id): JsonResponse
    {
        $editAppointmentRequest->validated();

        $appointment = $this->appointmentRepository->getDetailAppointment($id);

        if(!$appointment) {
            return response()->json([
                'success' => false,
                'message' => 'Appointment not found:(',
                'statusCode' => 404,
                'data' => [],
            ], 404);
        }

        $rules = [
            'patient_id' => $editAppointmentRequest->patient_id,
            'diagnose_id' => $editAppointmentRequest->diagnose_id,
            'status' => $editAppointmentRequest->status,
        ];

        $editAppointment = $this->appointmentRepository->editAppointment($rules, $id);

        return response()->json([
            'success' => true,
            'message' => 'Appointment edit successfully',
            'statusCode' => 200,
            'data' => $editAppointment,
        ], 200);
    }
}
