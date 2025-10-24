<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with('user')->latest('created_at');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status === 'published') {
                $query->where('is_published', true);
            } elseif ($status === 'draft') {
                $query->where('is_published', false);
            }
        }

        $news = $query->paginate(10)->withQueryString();

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'boolean',
        ]);

        $data = $request->only(['title', 'content', 'excerpt', 'is_published']);
        $data['user_id'] = Auth::id();

        // Generate slug
        $data['slug'] = Str::slug($request->title);

        // Handle published_at
        if ($request->boolean('is_published')) {
            $data['published_at'] = now();
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('news', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        News::create($data);

        return redirect()->route('admin.news.index')
                        ->with('success', 'Berita berhasil ditambahkan!');
    }

    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'boolean',
        ]);

        $data = $request->only(['title', 'content', 'excerpt', 'is_published']);

        // Update slug if title changed
        if ($news->title !== $request->title) {
            $data['slug'] = Str::slug($request->title);
        }

        // Handle published_at
        if ($request->boolean('is_published') && !$news->is_published) {
            $data['published_at'] = now();
        } elseif (!$request->boolean('is_published')) {
            $data['published_at'] = null;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($news->image && Storage::disk('public')->exists($news->image)) {
                Storage::disk('public')->delete($news->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('news', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        $news->update($data);

        return redirect()->route('admin.news.index')
                        ->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(News $news)
    {
        // Delete image if exists
        if ($news->image && Storage::disk('public')->exists($news->image)) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
                        ->with('success', 'Berita berhasil dihapus!');
    }

    public function bulkPublish(Request $request)
    {
        $request->validate([
            'selected_ids' => 'required|string',
        ]);

        $ids = explode(',', $request->selected_ids);
        $ids = array_filter($ids); // Remove empty values

        if (empty($ids)) {
            return redirect()->route('admin.news.index')
                            ->with('error', 'Tidak ada berita yang dipilih.');
        }

        // Update selected news to published
        $updatedCount = News::whereIn('id', $ids)
                           ->where('is_published', false)
                           ->update([
                               'is_published' => true,
                               'published_at' => now(),
                           ]);

        return redirect()->route('admin.news.index')
                        ->with('success', "Berhasil mengubah {$updatedCount} berita menjadi Published!");
    }

    public function bulkDraft(Request $request)
    {
        $request->validate([
            'selected_ids' => 'required|string',
        ]);

        $ids = explode(',', $request->selected_ids);
        $ids = array_filter($ids); // Remove empty values

        if (empty($ids)) {
            return redirect()->route('admin.news.index')
                            ->with('error', 'Tidak ada berita yang dipilih.');
        }

        // Update selected news to draft
        $updatedCount = News::whereIn('id', $ids)
                           ->where('is_published', true)
                           ->update([
                               'is_published' => false,
                               'published_at' => null,
                           ]);

        return redirect()->route('admin.news.index')
                        ->with('success', "Berhasil mengubah {$updatedCount} berita menjadi Draft!");
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'selected_ids' => 'required|string',
        ]);

        $ids = explode(',', $request->selected_ids);
        $ids = array_filter($ids); // Remove empty values

        if (empty($ids)) {
            return redirect()->route('admin.news.index')
                            ->with('error', 'Tidak ada berita yang dipilih.');
        }

        // Get news with images to delete
        $newsToDelete = News::whereIn('id', $ids)->get();

        // Delete images
        foreach ($newsToDelete as $news) {
            if ($news->image && Storage::disk('public')->exists($news->image)) {
                Storage::disk('public')->delete($news->image);
            }
        }

        // Delete news records
        $deletedCount = News::whereIn('id', $ids)->delete();

        return redirect()->route('admin.news.index')
                        ->with('success', "Berhasil menghapus {$deletedCount} berita!");
    }

    /**
     * Handle bulk actions for news
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:publish,draft,delete',
            'selected_news' => 'required|array',
            'selected_news.*' => 'exists:news,id',
        ]);

        $newsItems = News::whereIn('id', $request->selected_news);

        switch ($request->action) {
            case 'publish':
                $newsItems->update([
                    'is_published' => true,
                    'published_at' => now()
                ]);
                $message = 'Berita terpilih berhasil dipublikasikan!';
                break;

            case 'draft':
                $newsItems->update([
                    'is_published' => false,
                    'published_at' => null
                ]);
                $message = 'Berita terpilih berhasil diubah menjadi draft!';
                break;

            case 'delete':
                // Delete associated images before deleting news
                foreach ($newsItems->get() as $news) {
                    if ($news->image && Storage::disk('public')->exists($news->image)) {
                        Storage::disk('public')->delete($news->image);
                    }
                }
                $deletedCount = $newsItems->delete();
                $message = "Berhasil menghapus {$deletedCount} berita!";
                break;
        }

        return redirect()
            ->back()
            ->with('success', $message);
    }
}
