<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Agenda::with('user');

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->byStatus($request->status);
        }

        // Search functionality
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Sort by
        $sortBy = $request->get('sort_by', 'start_date');
        $sortOrder = $request->get('sort_order', 'desc');

        if ($sortBy === 'default') {
            $agendas = $query->ordered()->paginate(10);
        } else {
            $agendas = $query->orderBy($sortBy, $sortOrder)->paginate(10);
        }

        // Update statuses before displaying
        Agenda::updateStatuses();

        return view('admin.agenda.index', compact('agendas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.agenda.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug: Log semua input yang diterima
        Log::info('Store agenda request data:', $request->all());
        Log::info('Request has files:', [
            'has_image' => $request->hasFile('image'),
            'has_document' => $request->hasFile('document'),
            'all_files' => $request->allFiles()
        ]);

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'location' => 'nullable|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'start_time' => 'nullable|date_format:H:i',
                'end_time' => 'nullable|date_format:H:i',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'document' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
                'status' => ['required', Rule::in(['draft', 'scheduled', 'cancelled'])],
                'is_active' => 'boolean',
            ]);

            Log::info('Validated data:', $validated);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed:', $e->errors());
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Terjadi kesalahan validasi. Periksa kembali data yang dimasukkan.');
        }

        $validated['user_id'] = Auth::id();

        // Handle image upload
        if ($request->hasFile('image')) {
            Log::info('Image file detected:', [
                'name' => $request->file('image')->getClientOriginalName(),
                'size' => $request->file('image')->getSize(),
                'mime' => $request->file('image')->getMimeType()
            ]);
            $imagePath = $request->file('image')->store('agenda/images', 'public');
            $validated['image'] = $imagePath;
            Log::info('Image stored at:', ['path' => $imagePath]);
        } else {
            Log::info('No image file in request');
        }

        // Handle document upload
        if ($request->hasFile('document')) {
            Log::info('Document file detected:', [
                'name' => $request->file('document')->getClientOriginalName(),
                'size' => $request->file('document')->getSize(),
                'mime' => $request->file('document')->getMimeType()
            ]);
            $documentPath = $request->file('document')->store('agenda/documents', 'public');
            $validated['document'] = $documentPath;
            Log::info('Document stored at:', ['path' => $documentPath]);
        } else {
            Log::info('No document file in request');
        }

        try {
            Log::info('Creating agenda with data:', $validated);
            $agenda = Agenda::create($validated);
            Log::info('Agenda created successfully:', ['id' => $agenda->id]);

            return redirect()
                ->route('admin.agenda.index')
                ->with('success', 'Agenda berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Error creating agenda:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan agenda: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Agenda $agenda)
    {
        return view('admin.agenda.show', compact('agenda'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agenda $agenda)
    {
        return view('admin.agenda.edit', compact('agenda'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agenda $agenda)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'document' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'status' => ['required', Rule::in(['draft', 'scheduled', 'ongoing', 'completed', 'cancelled'])],
            'is_active' => 'boolean',
            'remove_image' => 'nullable|boolean',
            'remove_document' => 'nullable|boolean',
        ]);

        // Handle remove image
        if ($request->has('remove_image') && $request->remove_image) {
            if ($agenda->image) {
                Storage::disk('public')->delete($agenda->image);
                $validated['image'] = null;
            }
        }

        // Handle remove document
        if ($request->has('remove_document') && $request->remove_document) {
            if ($agenda->document) {
                Storage::disk('public')->delete($agenda->document);
                $validated['document'] = null;
            }
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($agenda->image) {
                Storage::disk('public')->delete($agenda->image);
            }
            $validated['image'] = $request->file('image')->store('agenda/images', 'public');
        }

        // Handle new document upload
        if ($request->hasFile('document')) {
            // Delete old document if exists
            if ($agenda->document) {
                Storage::disk('public')->delete($agenda->document);
            }
            $validated['document'] = $request->file('document')->store('agenda/documents', 'public');
        }

        $agenda->update($validated);

        return redirect()
            ->route('admin.agenda.index')
            ->with('success', 'Agenda berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agenda $agenda)
    {
        // Delete associated files
        if ($agenda->image) {
            Storage::disk('public')->delete($agenda->image);
        }

        if ($agenda->document) {
            Storage::disk('public')->delete($agenda->document);
        }

        $agenda->delete();

        return redirect()
            ->route('admin.agenda.index')
            ->with('success', 'Agenda berhasil dihapus!');
    }

    /**
     * Update agenda positions.
     */
    public function updatePositions(Request $request)
    {
        $request->validate([
            'positions' => 'required|array',
            'positions.*' => 'required|integer|exists:agendas,id',
        ]);

        foreach ($request->positions as $position => $id) {
            Agenda::where('id', $id)->update(['order_position' => $position + 1]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Toggle agenda status.
     */
    public function toggleStatus(Agenda $agenda)
    {
        $agenda->update(['is_active' => !$agenda->is_active]);

        $status = $agenda->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()
            ->back()
            ->with('success', "Agenda berhasil {$status}!");
    }

    /**
     * Manually update agenda status.
     */
    public function updateStatus(Request $request, Agenda $agenda)
    {
        $request->validate([
            'status' => ['required', Rule::in(['draft', 'scheduled', 'ongoing', 'completed', 'cancelled'])],
        ]);

        $agenda->update(['status' => $request->status]);

        return redirect()
            ->back()
            ->with('success', 'Status agenda berhasil diperbarui!');
    }

    /**
     * Bulk actions.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate,draft,scheduled,cancelled',
            'agenda_ids' => 'required|array',
            'agenda_ids.*' => 'exists:agendas,id',
        ]);

        $agendas = Agenda::whereIn('id', $request->agenda_ids);

        switch ($request->action) {
            case 'delete':
                foreach ($agendas->get() as $agenda) {
                    if ($agenda->image) {
                        Storage::disk('public')->delete($agenda->image);
                    }
                    if ($agenda->document) {
                        Storage::disk('public')->delete($agenda->document);
                    }
                }
                $agendas->delete();
                $message = 'Agenda terpilih berhasil dihapus!';
                break;

            case 'activate':
                $agendas->update(['is_active' => true]);
                $message = 'Agenda terpilih berhasil diaktifkan!';
                break;

            case 'deactivate':
                $agendas->update(['is_active' => false]);
                $message = 'Agenda terpilih berhasil dinonaktifkan!';
                break;

            case 'draft':
            case 'scheduled':
            case 'cancelled':
                $agendas->update(['status' => $request->action]);
                $message = "Status agenda terpilih berhasil diperbarui menjadi {$request->action}!";
                break;
        }

        return redirect()
            ->back()
            ->with('success', $message);
    }
}
