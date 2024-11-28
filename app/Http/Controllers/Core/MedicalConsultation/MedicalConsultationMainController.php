<?php

namespace App\Http\Controllers\Core\MedicalConsultation;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class MedicalConsultationMainController extends Controller
{



    public function filterScheduledAppointments($scheduledAppointments)
    {
        try {

            foreach ($scheduledAppointments as $key => $appointment) {
                $existingAppointment = DB::table('CMNCITMED')
                    ->where('CMNHORMED', $appointment['OID'])
                    ->whereRaw("CONVERT(VARCHAR, CCMFECCIT, 120) = ?", [$appointment['CCMFECCIT']])
                    ->whereRaw("CONVERT(VARCHAR, CCMFINCIT, 120) = ?", [$appointment['CCMFINCIT']])
                    ->where('CMNTIPACT', $appointment['CMNTIPACT'])
                    ->where('GENESPECI', $appointment['GENESPECI'])
                    ->where('CCMESTADO', '!=', 0)
                    ->first();

                if ($existingAppointment) {
                    unset($scheduledAppointments[$key]);
                }
            }

            return $scheduledAppointments;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }




    public function filterScheduledAppointmentsWithExlude($scheduledAppointments)
    {
        try {
            $removedAppointments = [];

            foreach ($scheduledAppointments as $key => $appointment) {
                $existingAppointment = DB::table('CMNCITMED')
                    ->where('CMNHORMED', $appointment['OID'])
                    ->whereRaw("CONVERT(VARCHAR, CCMFECCIT, 120) = ?", [$appointment['CCMFECCIT']])
                    ->whereRaw("CONVERT(VARCHAR, CCMFINCIT, 120) = ?", [$appointment['CCMFINCIT']])
                    ->where('CMNTIPACT', $appointment['CMNTIPACT'])
                    ->where('GENESPECI', $appointment['GENESPECI'])
                    ->where('CCMESTADO', '!=', 0)
                    ->first();

                if ($existingAppointment) {
                    $removedAppointments[] = $appointment;
                    unset($scheduledAppointments[$key]);
                }
            }

            return [
                'available' => array_values($scheduledAppointments),
                'removed' => $removedAppointments
            ];
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function create($data)
    {

        $nullableDates = ['CCMFECCAN', 'CCMFECCUM', 'CCMFECINA'];
        foreach ($nullableDates as $nullableDate) {
            if (empty($data[$nullableDate])) {
                $data[$nullableDate] = null;
            }
        }
        // Insertar los datos en la base de datos
        DB::table('CMNCITMED')->insert($data);

        return response()->json(['message' => 'Registro creado con éxito.'], 201);
    }

}
