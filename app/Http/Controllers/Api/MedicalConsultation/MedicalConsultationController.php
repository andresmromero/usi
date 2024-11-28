<?php

namespace App\Http\Controllers\Api\MedicalConsultation;

use App\Http\Controllers\Api\Shared\ResponseApi;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\MedicalConsultation\MedicalConsultationMainController;
use Artisan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class MedicalConsultationController extends Controller
{
    public function generatelink()
    {

        Artisan::call('storage:link');

    }

    public function create(Request $request)
    {
        $responseApi = new ResponseApi();
        $medicalConsultation = new MedicalConsultationMainController();

        try {



            $validationParams = Validator::make(
                $request->all(),

                [
                    'authorization_file' => ['required', 'mimes:pdf', 'max:2048'],
                    'authorization' => ['required', 'string', 'max:255'],
                    'hormed_id' => ['required', 'integer', 'max:10000000'],
                    'tipact_id' => ['required', 'integer', 'max:10000000'],
                    'especi_id' => ['required', 'integer', 'max:10000000'],
                    'feccit' => ['required', 'string', 'max:255'],
                    'fincit' => ['required', 'string', 'max:255'],
                    'tipcit' => ['required', 'integer', 'max:10000000'],
                    'pacien_id' => ['required', 'integer', 'max:10000000'],
                    'medico_id' => ['required', 'integer', 'max:10000000'],
                    'fecpac' => ['required', 'string', 'max:255'], // fecha propuesta por paciente
                    'fecasi' => ['required', 'string', 'max:255'], //fecha actual


                ]

            );


            $validationParams->setAttributeNames(
                [
                    'authorization_file' => 'archivo de autorizacion',
                    'authorization' => 'número de autorización',
                    'hormed_id' => 'turno medico',
                    'tipact_id' => 'tipo de actividad',
                    'especi_id' => 'especialidad',
                    'feccit' => 'fecha inicial de la cita',
                    'fincit' => 'fecha final de la cita',
                    'tipcit' => 'tipo de la cita',
                    'pacien_id' => 'paciente',
                    'medico_id' => 'medico',
                    'fecpac' => 'fecha propuesta por el paciente',
                    'fecasi' => 'fecha de asignación',
                ]
            );

            $customErrors = $responseApi->getParametersErros($validationParams);

            if (count($customErrors) > 0) {
                return $responseApi->response("Se ha encontrado errores en los parametros", [], $customErrors, 191, "ERROR", false, 442);
            }



            $archive_path = $request->authorization_file->store('public/authorization_file');
            $resp = str_replace('public', 'storage', $archive_path);




            $firstMedicalAppointment = $request->input('firstMedicalAppointment') ? 1 : 0;

            $defaultValues = [
                'CMNHORMED' => $request->hormed_id,
                'CMNTIPACT' => $request->tipact_id,
                'GENESPECI' => $request->especi_id,
                'CCMFECCIT' => Carbon::parse($request->feccit)->format('Y-m-d H:i:s'),
                'CCMFINCIT' => Carbon::parse($request->fincit)->format('Y-m-d H:i:s'),
                'CCMESTADO' => 1, // asignado
                'CCMTIPASI' => 4, // internet
                'CCMESTCIT' => $firstMedicalAppointment,
                'CCMTIPCIT' => 0, // normal
                'GENPACIEN' => $request->pacien_id,
                'CCMPACDOC' => '14399048',
                'CCMPACNOM' => 'xxJoxhnxDoexx',
                'CCMPACTEL' => '3209118',
                'CCMOBSERV' => '',
                'SLNFACTUR' => null,
                'GENUSUARIO1' => 569, // superusuario
                'CCMFECASI' => Carbon::parse($request->fecasi)->format('Y-m-d H:i:s'),
                'GENUSUARIO2' => null,
                'CCMFECCAN' => null,
                'CMNCAUCAN' => null,
                'GENUSUARIO3' => null,
                'CCMFECCUM' => null, // averiguar enum
                'SLNSERHOJ' => null,
                'GENMEDICO1' => $request->medico_id,
                'GENMEDICO2' => null,
                'CPNSOLICIC' => null,
                'GENSERIPS' => null,
                'GENARESER' => 187, // area de servicio
                'CCMNUMAUTO' => $request->authorization,
                'CCMTIPATE' => 1, // electiva
                'CCMCONPAC' => 0, // ninguna
                'CMNREMCIT' => null,
                'GENUSUARIO4' => null,
                'CCMFECINA' => null,
                'CCMREFERE' => null,
                'GENDIAGNO' => null,
                'CCMFECPAC' => Carbon::parse($request->fecpac)->format('Y-m-d H:i:s'),
                'CCMESTCOD' => null,
                'CCMESTNOM' => null,
                'CCMFECINCM' => null,
                'CCMOBSINCM' => null,
                'GENUSUARIO5' => null,
                'OptimisticLockField' => 0, // que es OptimisticLockField
                'GENDETCON' => null, // obtener el gendetcon del paciente eps
                'CCMREPUSU' => null, // revisar enum
                'CCMREPINS' => null, // revisar enum
                'CMNCITMED1' => null,
                'CCMCITFRE' => null, // revisar enum
                'CCMCONLLE' => null, // revisar enum
                'CCMFECLLE' => null,
                'GEENENTADM1' => null,
                'GENDETCON1' => null,
                'GENUSUARIO6' => null,
                'CCMCITGRUFRE' => null,
                'HCNORDPRESONC' => null,
                'HCNCONTRDT' => null,
                'CMTELEMED' => null,
                'CMTELEMEDNS' => null,
                'CCMPACTIPDOC' => null,
                'CMTIPASICIT' => null,
                'CMCODCOTIZAN' => null,
                'HCNSOLPNQX' => null,
                'ADNCOMDER' => null,
                'CMVALSERVI' => null,
                'CMVALSERVREA' => null,
                'CMVALFECPAGO' => null,
                'CMTIPOPAGO' => 0, // confirmar enum
                'CMCLAVEPAGO' => null,
                'PYPNPROMCIC' => null,
                'GENPACIENRA' => null,
                'CCMRESPAGO' => null,
                'CCMIDTRANSAC' => null,
                'CCMESTTRAN' => null,
                'CCMIDTRANHIS' => null,
                'CCMURLPAGLIN' => null,
                'CCMEMAILENV' => 0, // revisar el enum
                'CCMEMAIL' => null,
                'CCMTELPRINCIP' => null,
                'ADNINGRESO' => null,
                'TSNMRECIB' => null,
                'CCMIDMAQAUTPAG' => null,
                'CMNSERDET2' => null,
                'GENPLADIA' => null
            ];

            $medicalConsultation->create($defaultValues);


            return $responseApi->response("Cita medica creada", $resp, [], 192, "OK", true, 200);

        } catch (\Exception $e) {
            return $responseApi->response("Error al crear la cita medica", $e->getMessage(), [], 190, "ERROR", false, 500);
        }



    }
}
