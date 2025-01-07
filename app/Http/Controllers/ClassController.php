<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'subject' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = auth()->user();
        if ($user->role !== 'teacher') {
            return response()->json(['message' => 'Hanya guru yang dapat membuat kelas'], 403);
        }

        $class = Classes::create([
            'name' => $request->name,
            'subject' => $request->subject,
            'description' => $request->description,
            'teacher_id' => $user->id,
            'code' => substr(str_shuffle($characters = 'abcdefghijklmnopqrstuvwxyz0123456789'), 0, 8),
        ]);

        return response()->json($class, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = auth()->user();
        if ($user->role == 'teacher') {
            $classes = Classes::where('teacher_id', $user->id)->get();
        } elseif ($user->role == 'student') {
            $classes = $user->classes()->get();
        } else {
            return response()->json(['message' => 'Invalid user role'], 403);
        }
        return response()->json($classes);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = auth()->user();
        if ($user->role !== 'teacher') {
            return response()->json(['message' => 'Hanya guru yang dapat mengedit kelas'], 403);
        }

        $class = Classes::findOrFail($id);
        $class->update($request->all());
        return response()->json($class);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = auth()->user();
        if ($user->role !== 'teacher') {
            return response()->json(['message' => 'Hanya guru yang dapat menghapus kelas'], 403);
        }

        $class = Classes::findOrFail($id);
        $class->delete();
        return response()->json(['message' => 'Class deleted successfully']);
    }

    /**
     * Join a class using the class code
     * .
     */
    public function join(Request $request, $code)
    {
        $class = Classes::where('code', $code)->first();
        if (!$class) {
            return response()->json(['message' => 'Kelas tidak ditemukan'], 404);
        }
    
        $user = auth()->user();
        if ($user->role !== 'student') {
            return response()->json(['message' => 'Hanya siswa yang dapat bergabung dengan kelas'], 403);
        }
    
        if ($user->classes()->where('class_id', $class->id)->exists()) {
            return response()->json(['message' => 'Anda sudah bergabung dengan kelas ini'], 400);
        }
    
        $user->classes()->attach($class->id);
        return response()->json(['message' => 'Anda telah bergabung dengan kelas ini']);
    }

    /**
     * Leave a class using the class code.
     * .
     */
    public function leave(Request $request, $code)
    {
        $class = Classes::where('code', $code)->first();
        if (!$class) {
            return response()->json(['message' => 'Kelas tidak ditemukan'], 404);
        }
    
        $user = auth()->user();
        if ($user->role !== 'student') {
            return response()->json(['message' => 'Hanya siswa yang dapat keluar dari kelas'], 403);
        }
    
        if (!$user->classes()->where('class_id', $class->id)->exists()) {
            return response()->json(['message' => 'Anda tidak bergabung dengan kelas ini'], 400);
        }
    
        $user->classes()->detach($class->id);
        return response()->json(['message' => 'Anda telah keluar dari kelas ini']);
    }
}
