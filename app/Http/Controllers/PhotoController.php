<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $photos = Photo::with('application')->latest()->get();
        return response()->json([
            'success' => true,
            'data' => $photos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request['application_id'] = 1;
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:applications,id',
            'slider_1' => 'required|integer',
            'slider_2' => 'required|integer',
            'slider_tag' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->slider_1 != 0 || $request->slider_2 != 0;
                }),
                'string',
                'max:255'
            ],
            'is_gallery' => 'sometimes|integer',
            'photo' => 'required|file|image|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $file = $request->file('photo');
        $path = $file->store('photos', 'public');
        $photo = Photo::create([
            'application_id' => $request->application_id,
            'service_id' => $request->service_id,
            'slider_1' => $request->slider_1,
            'slider_2' => $request->slider_2,
            'slider_tag' => $request->slider_tag,
            'is_gallery' => $request->is_gallery ?? 0,
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ]);

        return response()->json([
            'success' => true,
            'data' => $photo
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Photo $photo)
    {
        return response()->json([
            'success' => true,
            'data' => $photo->load('application')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Photo $photo)
    {
        $validator = Validator::make($request->all(), [
            'application_id' => 'sometimes|exists:applications,id',
            'slider_1' => 'sometimes|integer',
            'slider_2' => 'sometimes|integer',
            'slider_tag' => [
                Rule::requiredIf(function () use ($request) {
                    return ($request->has('slider_1') && $request->slider_1 != 0) ||
                        ($request->has('slider_2') && $request->slider_2 != 0);
                }),
                'string',
                'max:255'
            ],
            'is_gallery' => 'sometimes|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $photo->update($request->only([
            'application_id',
            'slider_1',
            'slider_2',
            'slider_tag',
            'is_gallery'
        ]));

        return response()->json([
            'success' => true,
            'data' => $photo->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photo $photo)
    {
        Storage::disk('public')->delete($photo->path);
        $photo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Photo deleted successfully.'
        ]);
    }

    /**
     * Get photos by application ID
     */
    public function byApplication(Application $application)
    {
        $photos = $application->photos()->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $photos
        ]);
    }

    public function getPhotoSlider() {
        return [
            'slider_1' => Photo::query()->where('slider_1', '>', 0)->get(),
            'slider_2' => Photo::query()->where('slider_2', '>', 0)->get(),
        ];
    }
}