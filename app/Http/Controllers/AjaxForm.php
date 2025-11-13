<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;

class AjaxForm extends Controller
{
    public function index()
    {
        return view('ajaxform');
    }

    public function insert(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'location' => 'required|string|max:150',
        ]);

        Record::create($request->only('name', 'location'));

        return response()->json([
            'status' => 'success',
            'message' => 'Data inserted successfully!',
            'data' => $request->all(),
        ]);
    }

    public function fetch()
    {
        $records = Record::all();

        return response()->json([
            'status' => 'success',
            'data' => $records,
        ]);
    }

    public function edit($id)
    {
        $record = Record::find($id);

        if (!$record) {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not found!',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $record,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'location' => 'required|string|max:150',
        ]);

        $record = Record::find($id);

        if (!$record) {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not found!',
            ], 404);
        }

        $record->update($request->only('name', 'location'));

        return response()->json([
            'status' => 'success',
            'message' => 'Data updated successfully!',
            'data' => $record,
        ]);
    }

    public function delete($id)
    {
        $record = Record::find($id);

        if (!$record) {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not found!',
            ], 404);
        }

        $record->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data deleted successfully!',
        ]);
    }
}