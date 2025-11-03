<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WelcomeMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminWelcomeMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $welcomeMessages = WelcomeMessage::latest()->paginate(10);
        return view('admin.welcome-messages.index', compact('welcomeMessages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.welcome-messages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'message' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('welcome-messages/photos', 'public');
        }

        // Handle signature upload
        if ($request->hasFile('signature')) {
            $validated['signature'] = $request->file('signature')->store('welcome-messages/signatures', 'public');
        }

        WelcomeMessage::create($validated);

        return redirect()->route('admin.welcome-messages.index')
            ->with('success', 'Kata sambutan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(WelcomeMessage $welcomeMessage)
    {
        return view('admin.welcome-messages.show', compact('welcomeMessage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WelcomeMessage $welcomeMessage)
    {
        return view('admin.welcome-messages.edit', compact('welcomeMessage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WelcomeMessage $welcomeMessage)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'message' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($welcomeMessage->photo) {
                Storage::disk('public')->delete($welcomeMessage->photo);
            }
            $validated['photo'] = $request->file('photo')->store('welcome-messages/photos', 'public');
        }

        // Handle signature upload
        if ($request->hasFile('signature')) {
            // Delete old signature
            if ($welcomeMessage->signature) {
                Storage::disk('public')->delete($welcomeMessage->signature);
            }
            $validated['signature'] = $request->file('signature')->store('welcome-messages/signatures', 'public');
        }

        $welcomeMessage->update($validated);

        return redirect()->route('admin.welcome-messages.index')
            ->with('success', 'Kata sambutan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WelcomeMessage $welcomeMessage)
    {
        // Delete associated files
        if ($welcomeMessage->photo) {
            Storage::disk('public')->delete($welcomeMessage->photo);
        }
        if ($welcomeMessage->signature) {
            Storage::disk('public')->delete($welcomeMessage->signature);
        }

        $welcomeMessage->delete();

        return redirect()->route('admin.welcome-messages.index')
            ->with('success', 'Kata sambutan berhasil dihapus!');
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(WelcomeMessage $welcomeMessage)
    {
        $welcomeMessage->update([
            'is_active' => !$welcomeMessage->is_active
        ]);

        return redirect()->back()
            ->with('success', 'Status berhasil diubah!');
    }
}
