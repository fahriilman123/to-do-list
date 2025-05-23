<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function add(Request $request){
        $request->validate([
            'title' => 'required'
        ]);
        Todo::create([
            'title' => $request->title,
        ]);

        return redirect()->back()->with('success', 'Tugas berhasil ditambahkan!');
    }
    public function index()
    {
        // Ambil tugas yang belum dikerjakan
        $todosPending = Todo::where('is_completed', false)->get();

        // Ambil tugas yang sudah dikerjakan
        $todosCompleted = Todo::where('is_completed', true)->get();

        return view('welcome', compact('todosPending', 'todosCompleted'));
}

    public function destroy($id)
    {       
    $todo = Todo::findOrFail($id);
    $todo->delete();

    return redirect()->route('todos.index')->with('success', 'Tugas berhasil dihapus.');
    }
    public function complete(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->is_completed = $request->input('is_completed', false);
        $todo->save();

        return redirect()->back()->with('success', 'Tugas berhasil diperbarui.');
    }



}
