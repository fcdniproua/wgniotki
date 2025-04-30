<?php

// app/Http/Controllers/ContactController.php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function getContact()
    {
        $contact = Contact::first();

        if (!$contact) {
            return response()->json([
                'message' => 'Contact data not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'data' => $contact
        ]);
    }

    public function saveContact(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'opening_hours' => 'required|array',
            'map_embed' => 'required|string'
        ]);
        $contact = Contact::firstOrNew();

        $contact->fill($validated);

        $contact->save();

        return response()->json([
            'message' => 'Contact data saved successfully',
            'data' => $contact
        ]);
    }
}