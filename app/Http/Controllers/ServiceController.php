<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function getServices()
    {
        return Service::all();
    }

    // Зберегти/оновити/видалити послуги (POST)
    public function handleServices(Request $request)
    {
        $data = $request->validate([
            'action' => 'required|in:create,update,delete',
            'id' => 'nullable|integer',
            'name' => 'required_if:action,create,update|string|max:255',
            'description' => 'nullable|string'
        ]);

        switch ($data['action']) {
            case 'create':
                $service = Service::create($request->only('name', 'description'));
                return response()->json($service);

            case 'update':
                $service = Service::findOrFail($data['id']);
                $service->update($request->only('name', 'description'));
                return response()->json($service);

            case 'delete':
                Service::findOrFail($data['id'])->delete();
                return response()->json(['success' => true]);
        }
    }
}