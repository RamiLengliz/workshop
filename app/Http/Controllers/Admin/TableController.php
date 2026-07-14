<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TableCafe;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $tables = TableCafe::orderBy('number')->get();

        return view('admin.tables.index', compact('tables'));
    }

    public function create()
    {
        return view('admin.tables.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'number' => 'required|integer|min:1|unique:table_cafes,number',
            'status' => 'required|in:free,occupied',
        ]);

        TableCafe::create($data);

        return redirect()->route('admin.tables.index')->with('success', 'Table ajoutée.');
    }

    public function edit(TableCafe $table)
    {
        return view('admin.tables.edit', compact('table'));
    }

    public function update(Request $request, TableCafe $table)
    {
        $data = $request->validate([
            'number' => 'required|integer|min:1|unique:table_cafes,number,' . $table->id,
            'status' => 'required|in:free,occupied',
        ]);

        $table->update($data);

        return redirect()->route('admin.tables.index')->with('success', 'Table mise à jour.');
    }

    public function destroy(TableCafe $table)
    {
        $table->delete();

        return redirect()->route('admin.tables.index')->with('success', 'Table supprimée.');
    }
}
