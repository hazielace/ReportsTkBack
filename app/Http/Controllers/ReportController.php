<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\structure\Helpers\ResponseHelper;
use App\Http\structure\Repositories\ReportRepository;
use App\Jobs\GenerateReportJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function getReports(){
        $response = ReportRepository::getAllReports();
        if ($response->isEmpty()) {
            return (object) ResponseHelper::json_success(array(), "No se encontraron reportes");
        }
        return (object) ResponseHelper::json_success($response, "Reportes obtenidos exitosamente!");
    }

    public function getReport($id){
        $response = ReportRepository::getReport($id);
        if (!$response) {
            return (object) ResponseHelper::json_success([], "No se encontro enlace de reporte para descargar");
        }

        $filePath = public_path("storage/{$response->report_link}");
        if (!file_exists($filePath)) {
            return (object) ResponseHelper::json_success([], "El archivo no existe");
        }
        return response()->download($filePath);
    }

    public function addReport(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
        if($validator->fails()){
            return (object) ResponseHelper::json_fail($validator);
        }
        GenerateReportJob::dispatch($request->title, $request->start_date, $request->end_date);
        return (object) ResponseHelper::json_success(array(), 'El reporte se está generando . . .');
    }
}
