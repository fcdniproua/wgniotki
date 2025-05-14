<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationReceived;
use App\Models\Application;
use App\Models\Client;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{

    public function getApplications()
    {

        return response()->json( Application::with(['client', 'photos'])->get());
    }

    public function index()
    {
        return response()->json( Application::with('client')->get());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'service' => 'required|string|max:255',
            'brand' => 'nullable|string',
            'model' => 'nullable|string',
            'message' => 'nullable|string',
            'status' => 'nullable|in:new,in_progress,completed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $application = Application::create($validator->validated());
        $application->load('client');

        if ($request->hasFile('photos')) {
            $photos = [];
            $storagePath = 'img/applications_photo';

            // Створюємо папку, якщо її немає
            if (!Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->makeDirectory($storagePath);
            }

            foreach ($request->file('photos') as $photo) {
                // Генеруємо унікальне ім'я файлу
                $filename = time() . '_' . Str::random(10) . '.' . $photo->getClientOriginalExtension();

                // Зберігаємо фото
                $path = $photo->storeAs($storagePath, $filename, 'public');

                // Зберігаємо інформацію про фото
                $photos[] = [
                    'service_id' => $application->service,
                    'path' => $path,
                    'slider_1' => 0,
                    'slider_2' => 0,
                    'slider_tag' => '',
                    'is_gallery' => 0,
                    'original_name' => $photo->getClientOriginalName(),
                    'size' => $photo->getSize(),
                    'mime_type' => $photo->getMimeType()
                ];
            }

            // Зберігаємо фото в базу даних (припускаючи, що у вас є зв'язок і модель для фото)
            $application->photos()->createMany($photos);
        }

        return response()->json($application, 201);
    }

    public function show(Application $application)
    {
        $application->load('client');
        return response()->json($application);
    }

    public function update(Request $request, Application $application)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'sometimes|exists:clients,id',
            'service' => 'sometimes|string|max:255',
            'message' => 'nullable|string',
            'status' => 'sometimes|in:new,in_progress,completed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $application->update($validator->validated());
        $application->load('client');

        if ($request->hasFile('photos')) {
            $photos = [];
            $storagePath = 'img/applications_photo';

            // Створюємо папку, якщо її немає
            if (!Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->makeDirectory($storagePath);
            }

            foreach ($request->file('photos') as $photo) {
                // Генеруємо унікальне ім'я файлу
                $filename = time() . '_' . Str::random(10) . '.' . $photo->getClientOriginalExtension();

                // Зберігаємо фото
                $path = $photo->storeAs($storagePath, $filename, 'public');

                // Зберігаємо інформацію про фото
                $photos[] = [
                    'service_id' => $application->service,
                    'path' => $path,
                    'slider_1' => 0,
                    'slider_2' => 0,
                    'slider_tag' => '',
                    'is_gallery' => 0,
                    'original_name' => $photo->getClientOriginalName(),
                    'size' => $photo->getSize(),
                    'mime_type' => $photo->getMimeType()
                ];
            }

            // Зберігаємо фото в базу даних (припускаючи, що у вас є зв'язок і модель для фото)
            $application->photos()->createMany($photos);
        }

        return response()->json($application);
    }

    public function destroy(Application $application)
    {
        $application->photos()->delete();
        $application->delete();
        return response()->json(null, 204);
    }

    public function sendApplication(Request $request) {
        $client = Client::query()->where('email', '=', $request['email'])->first();
        if (!$client) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:clients,email',
                'phone' => 'nullable|string|max:20',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $client = Client::create($validator->validated());
        }

        $request->merge(['client_id' => $client->id]);
        $appValidator = Validator::make($request->all(), [
            'client_id' => 'sometimes|exists:clients,id',
            'service' => 'sometimes|string|max:255',
            'brand' => 'nullable|string',
            'model' => 'nullable|string',
            'message' => 'nullable|string',
            'status' => 'sometimes|in:new,in_progress,completed',
        ]);
        $application = Application::create($appValidator->validated());
        $application->load('client');

        if ($request->hasFile('photos')) {
            $photos = [];
            $storagePath = 'img/applications_photo';

            // Створюємо папку, якщо її немає
            if (!Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->makeDirectory($storagePath);
            }

            foreach ($request->file('photos') as $photo) {
                // Генеруємо унікальне ім'я файлу
                $filename = time() . '_' . Str::random(10) . '.' . $photo->getClientOriginalExtension();

                // Зберігаємо фото
                $path = $photo->storeAs($storagePath, $filename, 'public');
                // Зберігаємо інформацію про фото
                $photos[] = [
                    'service_id' => $application->service,
                    'path' => $path,
                    'slider_1' => 0,
                    'slider_2' => 0,
                    'slider_tag' => '',
                    'is_gallery' => 0,
                    'original_name' => $photo->getClientOriginalName(),
                    'size' => $photo->getSize(),
                    'mime_type' => $photo->getMimeType()
                ];
            }

            // Зберігаємо фото в базу даних (припускаючи, що у вас є зв'язок і модель для фото)
            $application->photos()->createMany($photos);
        }

        Mail::to($request->email)->send(new ApplicationReceived($application));

        return response()->json($application, 201);
    }
}