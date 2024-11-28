<?php

namespace App\Http\Controllers\Api\MedicalConsultation;

use App\Http\Controllers\Api\Shared\ResponseApi;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\GeneralSecurity\SpecialtyMainController;
use App\Http\Controllers\Core\MedicalConsultation\MedicalConsultationMainController;
use App\Http\Controllers\Core\MedicalConsultation\MedicalTurnMainController;
use App\Http\Controllers\Core\MedicalConsultation\TypeActivityMainController;
use Illuminate\Http\Request;
use Validator;

class MedicalTurnController extends Controller
{
    public function getAvailableMedicalTurn(Request $request)
    {



        $responseApi = new ResponseApi();
        $specialtyMain = new SpecialtyMainController();

        $availableMedicalTurnGroupParams = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'medical_center_id' => $request->medical_center_id,
            'type_activity_id' => $request->type_activity_id,
            'status' => $request->status,
            'status_turn_completed' => $request->status_turn_completed,
            'specialty_id' => $request->specialty_id,
            'reserved' => $request->reserved,
            'type_turn' => $request->type_turn
        ];




        $medicalTurn = new MedicalTurnMainController();
        $typeActivity = new TypeActivityMainController();
        $medicalConsultation = new MedicalConsultationMainController();


        try {



            $validationParams = Validator::make(
                $request->all(),

                [
                    'start_date' => ['required', 'string', 'max:255'],
                    'end_date' => ['required', 'string', 'max:255'],
                    'medical_center_id' => ['required', 'integer', 'max:10000000'],
                    'type_activity_id' => ['required', 'integer', 'max:10000000'],
                    'status' => ['required', 'integer', 'max:10000000'],
                    'status_turn_completed' => ['required', 'integer', 'max:10000000'],
                    'specialty_id' => ['required', 'integer', 'max:10000000'],
                    'reserved' => ['required', 'integer', 'max:10000000'],
                    'type_turn' => ['required', 'integer', 'max:10000000']

                ]

            );


            $validationParams->setAttributeNames(
                [
                    'start_date' => ' fecha inicial',
                    'end_date' => ' fecha final',
                    'medical_center_id' => ' centro medico',
                    'type_activity_id' => ' tipo de actividad',
                    'status' => ' estado del turno',
                    'status_turn_completed' => ' el estado',
                    'specialty_id' => ' especialidad',
                    'reserved' => ' estado de reserva',
                    'type_turn' => 'tipo de turno'
                ]
            );
            $customErrors = $responseApi->getParametersErros($validationParams);
            if (count($customErrors) > 0) {
                return $responseApi->response("Se ha encontrado errores en los parametros", [], $customErrors, 181, "ERROR", false, 442);
            }
            $rangeMedicalTurn = $medicalTurn->getMedicalTurnGroup($availableMedicalTurnGroupParams);
            $intervalsBetweenMedicalTurn = $typeActivity->getDurationFromTypesActivity($availableMedicalTurnGroupParams["type_activity_id"]);
            $scheduledAppointments = $medicalTurn->generateScheduledAppointments($rangeMedicalTurn, $intervalsBetweenMedicalTurn);
            $availableTurn = $medicalConsultation->filterScheduledAppointments($scheduledAppointments);
            return $responseApi->response("Turnos medicos disponibles obtenidas correctamente", $availableTurn, [], 182, "OK", true, 200);
        } catch (\Exception $e) {
            return $responseApi->response("Error al obtener los turnos medicos disponibles", $e->getMessage(), [], 180, "ERROR", false, 500);
        }
    }
}

