<?php

namespace App\Http\structure\Helpers;

use Illuminate\Support\Facades\DB;

class ResponseHelper
{
    public static function json_fail_puts($validator, $mensaje = null)
    {
        $data = [
            "status" =>  false,
            "message" => (isset($mensaje)) ? $mensaje : "danger",
            "length" => 0,
            "data" => $validator->errors()->all(),
        ];
        return response()->json($data);
    }

    public static function json_fail($validator, $mensaje = null)
    {
        $data = [
            "status" =>  false,
            "message" => (isset($mensaje)) ? $mensaje : "danger",
            "length" => 0,
            "data" =>  $validator->errors(),
        ];
        return response()->json($data);
    }

    public static function json_failnoV($data, $mensaje = null)
    {
        $data = [
            "status" =>  false,
            "message" => (isset($mensaje)) ? $mensaje : "danger",
            "length" => 0,
            "data" => $data,
        ];
        return response()->json($data);
    }

    public static function json_successnoV($data, $mensaje = null)
    {
        $data = [
            "status" =>  false,
            "message" => (isset($mensaje)) ? $mensaje : "success",
            "length" => 0,
            "data" => $data,
        ];
        return response()->json($data);
    }


    public static function json_success($data, $mensaje = null)
    {
        $response = [
            "status" =>  true,
            "message" => (isset($mensaje)) ? $mensaje : "success",
            "length" => count($data),
            "data" => $data,
        ];
        return response()->json($response);
    }

    public static function json_success2($data, $mensaje = null)
    {
        $response = [
            "status" =>  true,
            "message" => (isset($mensaje)) ? $mensaje : "Se procedio correctamente",
            "length" => count($data),
            "data" => $data,
        ];
        return response()->json($response);
    }


    public static function json_token_login($user, $token, $mensaje)
    {
        return response()->json([
            "status" => true,
            "message" => (isset($mensaje)) ? $mensaje : "success",
            "token" => $token,
            "token_type" => 'Bearer',
            "data" => $user
        ]);
    }

    public static function execResponse($command)
    {
        $platform = "";
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $platform = "Windows";
        } else {
            $platform = "Linux";
        }

        if ($platform == "Windows") {
            $ch = curl_init();
            // set url
            curl_setopt($ch, CURLOPT_URL, $command);
            //curl_setopt($ch, CURLOPT_URL, "http://$ip/tsdialer2/index2.php?controlador=Agent&funcion=finalizarGestion&tipo=2&dni=$dni&anexo=$anexo");
            //return the transfer as a string
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // $output contains the output string
            $data = curl_exec($ch);
            // close curl resource to free up system resources
            curl_close($ch);
        }

        if ($platform == "Linux") {
            $data = exec("/usr/bin/curl -sS '$command'");
        }

        DB::insert("insert into serverLogexec (exec) values ('/usr/bin/curl -sS $command')");
        return $data;
    }

}
