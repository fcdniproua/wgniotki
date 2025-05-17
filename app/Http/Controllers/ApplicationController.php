<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationReceived;
use App\Models\Application;
use App\Models\Client;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
        $this->sendZohoMail(
            $request->email,
            'Dzięki za wypełnienie formularza',
            view('emails.application_received', compact('application'))->render()
        );

//        $this->sendZohoMail(
//            'bezwgniotek@gmail.com',
//            'Otrzymano nowe zgłoszenie.',
//            view('emails.application_received_me', compact('application'))->render()
//        );

        return response()->json($application, 201);
    }

    private function sendZohoMail($toEmail, $subject, $content)
    {
        $client = new \GuzzleHttp\Client();
        $domain = env('ZOHO_API_DOMAIN');
        $refreshToken = env('ZOHO_REFRESH_TOKEN');
        $token = null;
        // Якщо токена в сесії немає, отримуємо новий
//        $token = session('zoho_access_token');
        if (! $token) {
            try {
                $res = $client->post("{$domain}/oauth/v2/token", [
                    'form_params' => [
                        'grant_type'    => 'refresh_token',
                        'client_id'     => env('ZOHO_CLIENT_ID'),
                        'client_secret' => env('ZOHO_CLIENT_SECRET'),
                        'refresh_token' => $refreshToken,
                    ],
                ]);
                $data = json_decode($res->getBody(), true);
                $token = $data['access_token'] ?? null;
                if (! $token) {
                    \Log::error('Zoho: не вдалося отримати access_token');
                    return false;
                }
                // Зберігаємо токен у сесію
                session(['zoho_access_token' => $token]);
            } catch (\Exception $e) {
                \Log::error('Помилка при оновленні токена Zoho: ' . $e->getMessage());
                return false;
            }

        }

        // Отримати accountId
        try {
            $res = $client->get('https://mail.zoho.eu/api/accounts', [
                'headers' => [
                    'Authorization' => "Zoho-oauthtoken {$token}",
                ]
            ]);

            $accounts = json_decode($res->getBody(), true);
            $accountId = $accounts['data'][0]['accountId'] ?? null;

            if (! $accountId) {
                \Log::error('Zoho: не вдалося отримати accountId');
                return false;
            }
        } catch (\Exception $e) {
            var_dump($e->getMessage());die();
            App::error('Помилка при отриманні акаунтів Zoho: ' . $e->getMessage());
            return false;
        }

        // Надсилання листа
        try {

            $response = $client->post("https://mail.zoho.eu/api/accounts/{$accountId}/messages", [
                'headers' => [
                    'Authorization' => "Zoho-oauthtoken {$token}",
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'fromAddress' => 'support@usuwanie-wgniecen.pro', // Замінити на справжній Zoho емейл
                    'toAddress' => $toEmail,
                    'subject' => $subject,
                    'content' => $content,
                ],
            ]);

            return $response->getStatusCode() === 200;
        } catch (\Exception $e) {
            var_dump($e->getMessage());die();
            \Log::error('Помилка при надсиланні листа через Zoho: ' . $e->getMessage());
            return false;
        }
    }


}