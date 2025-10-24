<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisionMission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisionMissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $visionMissions = VisionMission::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.vision-mission.index', compact('visionMissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vision-mission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vision' => 'required|string',
            'mission' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_active'] = $request->has('is_active');

        // Jika diset aktif, nonaktifkan yang lain
        if ($validated['is_active']) {
            VisionMission::where('is_active', true)->update(['is_active' => false]);
        }

        VisionMission::create($validated);

        return redirect()
            ->route('admin.vision-mission.index')
            ->with('success', 'Visi & Misi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(VisionMission $visionMission)
    {
        $visionMission->load('user');

        return view('admin.vision-mission.show', compact('visionMission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VisionMission $visionMission)
    {
        return view('admin.vision-mission.edit', compact('visionMission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VisionMission $visionMission)
    {
        $validated = $request->validate([
            'vision' => 'required|string',
            'mission' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_active'] = $request->has('is_active');

        // Jika diset aktif, nonaktifkan yang lain
        if ($validated['is_active']) {
            VisionMission::where('is_active', true)
                ->where('id', '!=', $visionMission->id)
                ->update(['is_active' => false]);
        }

        $visionMission->update($validated);

        return redirect()
            ->route('admin.vision-mission.index')
            ->with('success', 'Visi & Misi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VisionMission $visionMission)
    {
        $visionMission->delete();

        return redirect()
            ->route('admin.vision-mission.index')
            ->with('success', 'Visi & Misi berhasil dihapus!');
    }

    /**
     * Toggle the active status of the specified resource.
     */
    public function toggleStatus(VisionMission $visionMission)
    {
        // Jika akan diaktifkan, nonaktifkan yang lain
        if (!$visionMission->is_active) {
            VisionMission::where('is_active', true)->update(['is_active' => false]);
        }

        $visionMission->update([
            'is_active' => !$visionMission->is_active,
            'user_id' => Auth::id(),
        ]);

        $status = $visionMission->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()
            ->route('admin.vision-mission.index')
            ->with('success', "Visi & Misi berhasil {$status}!");
    }

    /**
     * Handle bulk delete action.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|array',
            'selected_items.*' => 'exists:vision_missions,id',
        ]);

        VisionMission::whereIn('id', $request->selected_items)->delete();

        return redirect()
            ->route('admin.vision-mission.index')
            ->with('success', count($request->selected_items) . ' Visi & Misi berhasil dihapus!');
    }

    /**
     * Handle bulk activate action.
     */
    public function bulkActivate(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|array',
            'selected_items.*' => 'exists:vision_missions,id',
        ]);

        // Nonaktifkan semua
        VisionMission::where('is_active', true)->update(['is_active' => false]);

        // Aktifkan yang terakhir dari selected
        $lastId = end($request->selected_items);
        VisionMission::where('id', $lastId)->update(['is_active' => true]);

        return redirect()
            ->route('admin.vision-mission.index')
            ->with('success', 'Visi & Misi terakhir yang dipilih berhasil diaktifkan!');
    }

    /**
     * Handle bulk deactivate action.
     */
    public function bulkDeactivate(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|array',
            'selected_items.*' => 'exists:vision_missions,id',
        ]);

        VisionMission::whereIn('id', $request->selected_items)
            ->update(['is_active' => false]);

        return redirect()
            ->route('admin.vision-mission.index')
            ->with('success', count($request->selected_items) . ' Visi & Misi berhasil dinonaktifkan!');
    }
}
