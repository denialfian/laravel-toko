<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\PositionRequest;
use App\Models\Position;
use Illuminate\Http\Request;

class ApiPositionController extends ApiController
{
    public function index(Request $request)
    {
        $keyword = $request->search;

        $query = Position::where(function ($q) use ($keyword) {
            if (!empty($keyword)) {
                $q->where('name', 'like', '%' . $keyword . '%');
            }
        });

        return $this->successResponse($this->bootstrapTableFormat($query, $request), 'ok');
    }

    public function store(PositionRequest $request)
    {
        $resp = Position::create([
            'name' => $request->name,
            'level' => $request->level,
        ]);

        return $this->successResponse($resp, 'ok');
    }

    public function show($id)
    {
        $resp = Position::where('id', $id)->firstOrFail();

        return $this->successResponse($resp, 'ok');
    }

    public function update(PositionRequest $request, $id)
    {
        $row = Position::where('id', $id)->firstOrFail();

        $row->update([
            'name' => $request->name,
            'level' => $request->level,
        ]);

        return $this->successResponse($row, 'ok');
    }

    public function destroy($id)
    {
        $resp = Position::where('id', $id)->firstOrFail()->delete();

        return $this->successResponse($resp, 'ok');
    }
}
