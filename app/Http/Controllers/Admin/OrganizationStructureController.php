<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationStructure;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class OrganizationStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = OrganizationStructure::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'order');
        $sortOrder = $request->get('sort_order', 'asc');

        if ($sortBy === 'order') {
            $query->ordered();
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $structures = $query->paginate(15)->withQueryString();

        return view('admin.structures.index', compact('structures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $nextOrder = OrganizationStructure::getNextOrder();
        return view('admin.structures.create', compact('nextOrder'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:50', 'unique:organization_structures,nip'],
            'position' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'order' => ['required', 'integer', 'min:1'],
            'is_active' => ['boolean']
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('structures', 'public');
            $validated['photo'] = $photoPath;
        }

        // Check if order exists and adjust if necessary
        if (OrganizationStructure::orderExists($validated['order'])) {
            OrganizationStructure::adjustOrdersForInsert($validated['order']);
        }

        OrganizationStructure::create($validated);

        return redirect()->route('admin.structures.index')
            ->with('success', 'Struktur organisasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OrganizationStructure $structure): View
    {
        return view('admin.structures.show', compact('structure'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrganizationStructure $structure): View
    {
        return view('admin.structures.edit', compact('structure'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrganizationStructure $structure): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:50', Rule::unique('organization_structures')->ignore($structure->id)],
            'position' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'order' => ['required', 'integer', 'min:1'],
            'is_active' => ['boolean']
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            $structure->deletePhoto();

            // Store new photo
            $photoPath = $request->file('photo')->store('structures', 'public');
            $validated['photo'] = $photoPath;
        }

        $oldOrder = $structure->order;
        $newOrder = $validated['order'];

        // Adjust orders if position changed
        if ($oldOrder !== $newOrder) {
            if (OrganizationStructure::orderExists($newOrder, $structure->id)) {
                OrganizationStructure::adjustOrdersForUpdate($oldOrder, $newOrder);
            }
        }

        $structure->update($validated);

        return redirect()->route('admin.structures.index')
            ->with('success', 'Struktur organisasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrganizationStructure $structure): RedirectResponse
    {
        // Delete photo file if exists
        $structure->deletePhoto();

        $structure->delete();

        return redirect()->route('admin.structures.index')
            ->with('success', 'Struktur organisasi berhasil dihapus.');
    }

    /**
     * Handle bulk actions
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'action' => ['required', 'in:activate,deactivate,delete'],
            'selected_ids' => ['required', 'array', 'min:1'],
            'selected_ids.*' => ['exists:organization_structures,id']
        ]);

        $selectedIds = $validated['selected_ids'];
        $action = $validated['action'];

        switch ($action) {
            case 'activate':
                OrganizationStructure::whereIn('id', $selectedIds)->update(['is_active' => true]);
                $message = 'Struktur organisasi berhasil diaktifkan.';
                break;
            case 'deactivate':
                OrganizationStructure::whereIn('id', $selectedIds)->update(['is_active' => false]);
                $message = 'Struktur organisasi berhasil dinonaktifkan.';
                break;
            case 'delete':
                OrganizationStructure::whereIn('id', $selectedIds)->delete();
                $message = 'Struktur organisasi berhasil dihapus.';
                break;
        }

        return redirect()->route('admin.structures.index')->with('success', $message);
    }
}
