<?php

/*
 *
 * @author: Tharuka Lakshan
 * @date  : 30/04/19
 *
 */

namespace App\Util;


 class ApiWrapper
{
    static function wrapApiResponse($data, $type, $http_type)
    {
        $response = ['data'=>$data, 'type'=>$type];
        return response()->json($response,  $http_type);
    }
}
