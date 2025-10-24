<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HeroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Hero::with('user')->ordered();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
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

        $heroes = $query->paginate(10)->withQueryString();

        return view('admin.heroes.index', compact('heroes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.heroes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
            'show_title' => 'boolean',
            'order_position' => 'nullable|integer|min:0',
            'button1_text' => 'nullable|string|max:100',
            'button1_url' => 'nullable|url|max:255',
            'button1_style' => 'nullable|in:primary,secondary',
            'button2_text' => 'nullable|string|max:100',
            'button2_url' => 'nullable|url|max:255',
            'button2_style' => 'nullable|in:primary,secondary',
        ]);

        $data = $request->only([
            'title', 'description', 'is_active', 'show_title', 'order_position',
            'button1_text', 'button1_url', 'button1_style',
            'button2_text', 'button2_url', 'button2_style'
        ]);

        $data['user_id'] = Auth::id();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('heroes', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        // Set default order position
        if (empty($data['order_position'])) {
            $data['order_position'] = Hero::max('order_position') + 1;
        }

        Hero::create($data);

        return redirect()->route('admin.heroes.index')
                        ->with('success', 'Hero berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hero $hero)
    {
        return view('admin.heroes.show', compact('hero'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hero $hero)
    {
        return view('admin.heroes.edit', compact('hero'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hero $hero)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
            'show_title' => 'boolean',
            'order_position' => 'nullable|integer|min:0',
            'button1_text' => 'nullable|string|max:100',
            'button1_url' => 'nullable|url|max:255',
            'button1_style' => 'nullable|in:primary,secondary',
            'button2_text' => 'nullable|string|max:100',
            'button2_url' => 'nullable|url|max:255',
            'button2_style' => 'nullable|in:primary,secondary',
        ]);

        $data = $request->only([
            'title', 'description', 'is_active', 'show_title', 'order_position',
            'button1_text', 'button1_url', 'button1_style',
            'button2_text', 'button2_url', 'button2_style'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($hero->image && Storage::disk('public')->exists($hero->image)) {
                Storage::disk('public')->delete($hero->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('heroes', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        $hero->update($data);

        return redirect()->route('admin.heroes.index')
                        ->with('success', 'Hero berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hero $hero)
    {
        // Delete image if exists
        if ($hero->image && Storage::disk('public')->exists($hero->image)) {
            Storage::disk('public')->delete($hero->image);
        }

        $hero->delete();

        return redirect()->route('admin.heroes.index')
                        ->with('success', 'Hero berhasil dihapus!');
    }

    /**
     * Toggle hero status.
     */
    public function toggleStatus(Hero $hero)
    {
        $hero->update(['is_active' => !$hero->is_active]);

        $status = $hero->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Hero berhasil {$status}!");
    }
}
