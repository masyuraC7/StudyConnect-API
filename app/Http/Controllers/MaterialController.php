<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Storage;
use Validator;

class MaterialController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request, $class_id)
{
    $user = auth()->user();
    if ($user->role !== 'teacher') {
        return response()->json(['message' => 'Hanya guru yang dapat membuat materi'], 403);
    }

    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:100',
        'description' => 'nullable|string',
        'attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf,docx|max:8192',
        'scheduled_at' => 'nullable|date_format:Y-m-d H:i',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $attachmentPath = null;
    $attachment = $request->file('attachment');
    if ($attachment) {
        $attachmentName = time() . '_' . $attachment->getClientOriginalName();
        $attachmentPath = $attachment->storeAs('attachments', $attachmentName, 'public');
    }

    $material = Material::create([
        'title' => $request->title,
        'description' => $request->description,
        'attachment_path' => $attachmentPath,
        'class_id' => $class_id,
        'teacher_id' => $user->id,
        'status' => $request->scheduled_at ? 'scheduled' : 'published',
    ]);

    if ($request->scheduled_at) {
        $material->scheduled_at = Carbon::createFromFormat('Y-m-d H:i', $request->scheduled_at);
        $material->save();
    }

    return response()->json($material, 201);
}

    /**
     * Display the specified resource.
     */
    public function show($class_id)
    {
        $materials = Material::where('class_id', $class_id)->get();
        return response()->json($materials);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        if ($user->role !== 'teacher') {
            return response()->json(['message' => 'Hanya guru yang dapat mengedit materi'], 403);
        }

        $material = Material::find($id);
        if (!$material) {
            return response()->json(['message' => 'Materi tidak ditemukan', $material], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf,docx|max:8192',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            $attachmentName = time() . '_' . $attachment->getClientOriginalName();
            $attachmentPath = $attachment->storeAs('attachments', $attachmentName, 'public');
            $material->attachment_path = $attachmentPath;
        }

        $material->title = $request->title;
        $material->description = $request->description;
        $material->save();

        return response()->json($material);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = auth()->user();
        if ($user->role !== 'teacher') {
            return response()->json(['message' => 'Hanya guru yang dapat menghapus materi'], 403);
        }

        $materi = Material::find($id);
        if (!$materi) {
            return response()->json(['message' => 'Materi tidak ditemukan'], 404);
        }
    
        // Hapus file yang terupload
        if ($materi->attachment_path) {
            Storage::delete($materi->attachment_path);
        }
    
        $materi->delete();
        return response()->json(['message' => 'Materi berhasil dihapus']);
    }
}

