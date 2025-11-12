<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Document::with('user');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->get('category'));
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $documents = $query->paginate(15)->withQueryString();

        // Get unique categories for filter
        $categories = Document::select('category')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return view('admin.documents.index', compact('documents', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get existing categories for dropdown suggestions
        $categories = Document::select('category')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('admin.documents.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar|max:10240', // max 10MB
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');

            $validated['file_path'] = $filePath;
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_type'] = $file->getClientOriginalExtension();
            $validated['file_size'] = $file->getSize();
        }

        $validated['user_id'] = Auth::id();
        $validated['is_active'] = $request->has('is_active') ? true : false;

        Document::create($validated);

        return redirect()
            ->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        $document->load('user');
        return view('admin.documents.show', compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        // Get existing categories for dropdown suggestions
        $categories = Document::select('category')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('admin.documents.edit', compact('document', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar|max:10240',
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');

            $validated['file_path'] = $filePath;
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_type'] = $file->getClientOriginalExtension();
            $validated['file_size'] = $file->getSize();
        }

        $validated['is_active'] = $request->has('is_active') ? true : false;

        $document->update($validated);

        return redirect()
            ->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        // Delete file
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()
            ->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil dihapus!');
    }

    /**
     * Download document
     */
    public function download(Document $document)
    {
        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        // Increment download count
        $document->incrementDownloadCount();

        $filePath = Storage::disk('public')->path($document->file_path);

        return response()->download($filePath, $document->file_name);
    }

    /**
     * Toggle document status
     */
    public function toggleStatus(Document $document)
    {
        $document->update([
            'is_active' => !$document->is_active
        ]);

        $status = $document->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()
            ->back()
            ->with('success', "Dokumen berhasil {$status}!");
    }

    /**
     * Bulk actions for documents
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'selected_documents' => 'required|array',
            'selected_documents.*' => 'exists:documents,id',
        ]);

        $documents = Document::whereIn('id', $request->selected_documents);

        switch ($request->action) {
            case 'activate':
                $documents->update(['is_active' => true]);
                $message = 'Dokumen terpilih berhasil diaktifkan!';
                break;

            case 'deactivate':
                $documents->update(['is_active' => false]);
                $message = 'Dokumen terpilih berhasil dinonaktifkan!';
                break;

            case 'delete':
                foreach ($documents->get() as $document) {
                    if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                        Storage::disk('public')->delete($document->file_path);
                    }
                }
                $deletedCount = $documents->delete();
                $message = "Berhasil menghapus {$deletedCount} dokumen!";
                break;
        }

        return redirect()
            ->back()
            ->with('success', $message);
    }
}
