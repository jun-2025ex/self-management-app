<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;

class RecordController extends Controller
{
    public function index()
    {
        $records = Record::orderBy('date')->get();
        return view('record', compact('records'));
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $record = Record::create([
            'category' => $request->category,
            'date' => $request->date,
            'content' => $request->content,
            'value' => $request->value,
        ]);

        return response()->json($record);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            Record::whereIn('id', $ids)->delete();
        }

        return response()->json(['success' => true]);
    }
}
