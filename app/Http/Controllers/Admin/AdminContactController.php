<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'google_maps_embed' => 'nullable|string',
            'office_hours_open' => 'nullable|string|max:10',
            'office_hours_close' => 'nullable|string|max:10',
            'office_days' => 'nullable|string|max:100',
        ]);

        Contact::create($validated);

        // Clear footer contact cache
        Cache::forget('footer_contact');

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'Kontak berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        return view('admin.contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'google_maps_embed' => 'nullable|string',
            'office_hours_open' => 'nullable|string|max:10',
            'office_hours_close' => 'nullable|string|max:10',
            'office_days' => 'nullable|string|max:100',
        ]);

        $contact->update($validated);

        // Clear footer contact cache
        Cache::forget('footer_contact');

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'Kontak berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        // Clear footer contact cache
        Cache::forget('footer_contact');

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'Kontak berhasil dihapus!');
    }
}
