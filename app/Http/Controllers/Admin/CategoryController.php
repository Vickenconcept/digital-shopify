<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    protected FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::withCount('digitalProducts');

        // Apply search filter
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Apply status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        // Apply sorting
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'name':
                $query->orderBy('name');
                break;
            case 'products_count':
                $query->orderBy('digital_products_count', 'desc');
                break;
            case 'oldest':
                $query->oldest();
                break;
            default:
                $query->latest();
                break;
        }

        $categories = $query->paginate(12)->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|max:2048|mimes:png,jpg,jpeg,gif,webp,svg,psd',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $this->fileUploadService->uploadFile($request->file('image_path'), 'categories');
        }

        $category = Category::create($validated);

        // Send email notification
        try {
            $adminEmail = \App\Support\MailRecipients::admin();
            
            Mail::raw("A new category has been created.\n\nCategory Details:\nName: {$category->name}\nSlug: {$category->slug}\nStatus: " . ($category->is_active ? 'Active' : 'Inactive') . "\nDescription: " . ($category->description ?? 'No description') . "\n\nCreated by: " . auth()->user()->name, function ($message) use ($adminEmail, $category) {
                $message->to($adminEmail)
                    ->subject('New Category Created: ' . $category->name);
            });
        } catch (\Exception $e) {
            Log::error('Failed to send category creation email: ' . $e->getMessage());
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|max:2048|mimes:png,jpg,jpeg,gif,webp,svg,psd',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $this->fileUploadService->uploadFile($request->file('image_path'), 'categories');
        }

        $category->update($validated);

        // Send email notification
        try {
            $adminEmail = \App\Support\MailRecipients::admin();
            
            Mail::raw("A category has been updated.\n\nCategory Details:\nName: {$category->name}\nSlug: {$category->slug}\nStatus: " . ($category->is_active ? 'Active' : 'Inactive') . "\nDescription: " . ($category->description ?? 'No description') . "\n\nUpdated by: " . auth()->user()->name, function ($message) use ($adminEmail, $category) {
                $message->to($adminEmail)
                    ->subject('Category Updated: ' . $category->name);
            });
        } catch (\Exception $e) {
            Log::error('Failed to send category update email: ' . $e->getMessage());
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $categoryName = $category->name;
        $category->delete();

        // Send email notification
        try {
            $adminEmail = \App\Support\MailRecipients::admin();
            
            Mail::raw("A category has been deleted.\n\nCategory Details:\nName: {$categoryName}\n\nDeleted by: " . auth()->user()->name . "\nDeleted at: " . now()->format('Y-m-d H:i:s'), function ($message) use ($adminEmail, $categoryName) {
                $message->to($adminEmail)
                    ->subject('Category Deleted: ' . $categoryName);
            });
        } catch (\Exception $e) {
            Log::error('Failed to send category deletion email: ' . $e->getMessage());
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus(Category $category)
    {
        $category->update([
            'is_active' => !$category->is_active
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $category->is_active,
            'message' => 'Category status updated successfully.'
        ]);
    }
}
