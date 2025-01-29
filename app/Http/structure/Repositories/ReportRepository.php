<?php
namespace App\Http\structure\Repositories;

use App\Models\Report;

class ReportRepository{

    public static function getAllReports()
    {   
        return Report::selectRaw("id, title, report_link, DATE_FORMAT(created_at, '%d/%m/%Y') as f_created_at, DATE_FORMAT(updated_at, '%d/%m/%Y') as f_updated_at")->get();
    }

    public static function addReport($request){
        $data = new Report();
        $data->title = $request['title'];
        $data->report_link = $request['report_link'];
        return $data->save();
    }

    public static function getReport($id){
        $data = Report::where('id','=', $id)->first();
        return $data ? $data : [];
    }
}