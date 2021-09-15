<?php

namespace App\Http\Controllers;

class ApiController extends Controller
{
    public function bootstrapTableFormat($query, $request){
        $modelQueryData = $query;
        $modelQueryCount = $query;

        $limit = isset($request->limit) ? $request->limit : 10;
        $offset = isset($request->offset) ? $request->offset : 0;
        $order = isset($request->order) ? $request->order : 'ASC';
        $sort = isset($request->sort) ? $request->sort : 'id';

        $response = [
            'total' => $modelQueryCount->count(),
            'rows'  => $modelQueryData->offset($offset)->limit($limit)->orderBy($sort, $order)->get(),
        ];

        return $response;
    }

    public function successResponse($result, $message, $code = 200)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
            'status_code' => $code,
        ];

        return response()->json($response, 200);
    }

    public function errorResponse($result, $message, $code = 500)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
            'status_code' => $code,
        ];

        return response()->json($response, $code);
    }
}
