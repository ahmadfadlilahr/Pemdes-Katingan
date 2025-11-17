<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Agenda;
use App\Models\Hero;
use App\Models\Document;
use App\Models\Gallery;
use App\Models\VisionMission;
use App\Models\OrganizationStructure;
use App\Models\WelcomeMessage;
use App\Models\Contact;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Display the home page.
     */
    public function home()
    {
        // Get latest active heroes for slider
        $heroes = Hero::where('is_active', true)
            ->orderBy('order_position', 'asc')
            ->take(5)
            ->get();

        // Get active welcome message
        $welcomeMessage = WelcomeMessage::getActive();

        // Get contact information for quick info sidebar
        $contact = Contact::first();

        // Get latest published news (4 items)
        $latestNews = News::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->take(4)
            ->get();

        // Get upcoming agenda (5 items)
        $upcomingAgenda = Agenda::where('is_active', true)
            ->where('start_date', '>=', now()->toDateString())
            ->orderBy('start_date', 'asc')
            ->take(5)
            ->get();

        // Get latest public documents (4 items)
        $latestDocuments = Document::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // Get latest gallery images (6 items)
        $latestGallery = Gallery::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Calculate stats for published content
        $stats = [
            'news' => News::where('is_published', true)->count(),
            'agenda' => Agenda::where('is_active', true)->count(),
            'gallery' => Gallery::where('is_active', true)->count(),
            'documents' => Document::where('is_active', true)->count(),
        ];

        return view('public.home', compact(
            'heroes',
            'welcomeMessage',
            'contact',
            'latestNews',
            'upcomingAgenda',
            'latestDocuments',
            'latestGallery',
            'stats'
        ));
    }

    /**
     * Display news page.
     */
    public function news(Request $request)
    {
        // Get search query
        $search = $request->input('search');

        // Query published news
        $query = News::where('is_published', true);

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        // Get paginated results
        $news = $query->orderBy('published_at', 'desc')
            ->paginate(9);

        // Get latest news for sidebar
        $latestNews = News::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        return view('public.news', compact('news', 'latestNews'));
    }

    /**
     * Display single news detail.
     */
    public function newsShow($slug)
    {
        // Get the news by slug
        $news = News::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Get related news (same author or recent)
        $relatedNews = News::where('is_published', true)
            ->where('id', '!=', $news->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('public.news-show', compact('news', 'relatedNews'));
    }

    /**
     * Display agenda page.
     */
    public function agenda(Request $request)
    {
        // Get search query
        $search = $request->input('search');
        $status = $request->input('status'); // upcoming, ongoing, completed

        // Query active agenda
        $query = Agenda::where('is_active', true);

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%');
            });
        }

        // Apply status filter
        if ($status) {
            $now = now();
            if ($status === 'upcoming') {
                $query->where('start_date', '>', $now->toDateString());
            } elseif ($status === 'ongoing') {
                $query->where('start_date', '<=', $now->toDateString())
                      ->where('end_date', '>=', $now->toDateString());
            } elseif ($status === 'completed') {
                $query->where('end_date', '<', $now->toDateString());
            }
        }

        // Get paginated results
        $agendas = $query->orderBy('start_date', 'asc')
            ->paginate(9);

        // Get upcoming agenda for sidebar
        $upcomingAgenda = Agenda::where('is_active', true)
            ->where('start_date', '>=', now()->toDateString())
            ->orderBy('start_date', 'asc')
            ->take(5)
            ->get();

        return view('public.agenda', compact('agendas', 'upcomingAgenda'));
    }

    /**
     * Display single agenda detail.
     */
    public function agendaShow($id)
    {
        // Get the agenda by ID
        $agenda = Agenda::where('id', $id)
            ->where('is_active', true)
            ->firstOrFail();

        // Get related agenda (upcoming events)
        $relatedAgenda = Agenda::where('is_active', true)
            ->where('id', '!=', $agenda->id)
            ->where('start_date', '>=', now()->toDateString())
            ->orderBy('start_date', 'asc')
            ->take(3)
            ->get();

        return view('public.agenda-show', compact('agenda', 'relatedAgenda'));
    }

    /**
     * Display documents page.
     */
    public function documents(Request $request)
    {
        // Get search query
        $search = $request->input('search');
        $category = $request->input('category');

        // Query active documents
        $query = Document::where('is_active', true);

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Apply category filter
        if ($category) {
            $query->where('category', $category);
        }

        // Get paginated results
        $documents = $query->orderBy('created_at', 'desc')
            ->paginate(12);

        // Get document categories for filter
        $categories = Document::where('is_active', true)
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        // Get popular documents (most downloaded)
        $popularDocuments = Document::where('is_active', true)
            ->orderBy('download_count', 'desc')
            ->take(5)
            ->get();

        return view('public.documents', compact('documents', 'categories', 'popularDocuments'));
    }

    /**
     * Display single document detail.
     */
    public function documentShow($id)
    {
        $document = Document::where('id', $id)
            ->where('is_active', true)
            ->firstOrFail();

        // Get related documents (same category)
        $relatedDocuments = Document::where('is_active', true)
            ->where('id', '!=', $document->id)
            ->when($document->category, function($query) use ($document) {
                return $query->where('category', $document->category);
            })
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('public.documents-show', compact('document', 'relatedDocuments'));
    }

    /**
     * Preview document in browser.
     */
    public function documentPreview($id)
    {
        $document = Document::where('id', $id)
            ->where('is_active', true)
            ->firstOrFail();

        // Build the correct file path
        $filePath = storage_path('app/public/' . $document->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File dokumen tidak ditemukan. Silakan hubungi administrator.');
        }

        // Get file extension
        $extension = strtolower($document->file_type);

        // Return file for inline viewing (not download)
        return response()->file($filePath, [
            'Content-Type' => mime_content_type($filePath),
            'Content-Disposition' => 'inline; filename="' . $document->file_name . '"',
        ]);
    }

    /**
     * Download document.
     */
    public function documentDownload($id)
    {
        $document = Document::where('id', $id)
            ->where('is_active', true)
            ->firstOrFail();

        // Build the correct file path
        // File stored in storage/app/public/documents/
        $filePath = storage_path('app/public/' . $document->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File dokumen tidak ditemukan. Silakan hubungi administrator.');
        }

        // Increment download count
        $document->incrementDownloadCount();

        // Return file download with proper headers
        return response()->download($filePath, $document->file_name, [
            'Content-Type' => mime_content_type($filePath),
        ]);
    }

    /**
     * Display gallery page.
     */
    public function gallery(Request $request)
    {
        // Get search query
        $search = $request->input('search');

        // Query active galleries
        $query = Gallery::where('is_active', true);

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Get paginated results
        $galleries = $query->ordered()->paginate(12);

        // Get latest galleries for sidebar
        $latestGalleries = Gallery::where('is_active', true)
            ->ordered()
            ->take(6)
            ->get();

        return view('public.gallery', compact('galleries', 'latestGalleries'));
    }

    /**
     * Display contact page.
     */
    public function contact()
    {
        return view('public.contact');
    }

    /**
     * Display vision & mission page.
     */
    public function visionMission()
    {
        // Get active vision & mission
        $visionMission = VisionMission::getActive();

        return view('public.vision-mission', compact('visionMission'));
    }

    /**
     * Display organization structure page.
     */
    public function organizationStructure()
    {
        // Get all active organization members ordered by position
        $structures = OrganizationStructure::active()
            ->ordered()
            ->get();

        // Group structures by order (hierarchy levels)
        $groupedStructures = $structures->groupBy('order');

        return view('public.organization-structure', compact('structures', 'groupedStructures'));
    }

    /**
     * Display programs page.
     */
    public function programs()
    {
        return view('public.programs');
    }
}
