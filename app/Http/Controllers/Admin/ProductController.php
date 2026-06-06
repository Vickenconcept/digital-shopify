<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DigitalProductRequest;
use App\Models\Category;
use App\Models\DigitalProduct;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DigitalProduct::with(['category', 'user']);

        // Apply search filter
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Apply category filter
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Apply type filter
        if ($request->has('type') && $request->type) {
            $query->where('file_type', $request->type);
        }

        // Apply status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        // Apply featured filter
        if ($request->has('featured') && $request->featured !== '') {
            $query->where('is_featured', $request->featured);
        }

        // Apply sorting
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'title':
                $query->orderBy('title');
                break;
            case 'price_low':
                $query->orderBy('price');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'oldest':
                $query->oldest();
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        // Get filter options
        $categories = Category::orderBy('name')->get();
        $availableTypes = DigitalProduct::distinct()->pluck('file_type');

        return view('admin.products.index', compact('products', 'categories', 'availableTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DigitalProductRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($data['title']);

        if ($request->hasFile('file')) {
            $fileData = $this->fileUploadService->uploadDigitalContent($request->file('file'), $data['file_type']);
            $data = array_merge($data, $fileData);
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_path'] = $this->fileUploadService->uploadThumbnail($request->file('thumbnail'));
        }

        if ($request->hasFile('preview')) {
            $data['preview_path'] = $this->fileUploadService->uploadPreview($request->file('preview'), $data['file_type']);
        }

        $product = DigitalProduct::create($data);

        // Send email notification
        try {
            $adminEmail = \App\Support\MailRecipients::admin();
            $productUrl = route('products.show', $product->slug);
            
            Mail::raw("A new product has been created.\n\nProduct Details:\nTitle: {$product->title}\nPrice: " . ($product->is_free ? 'Free' : '$' . number_format($product->price, 2)) . "\nType: {$product->file_type}\nStatus: " . ($product->is_active ? 'Active' : 'Inactive') . "\n\nView Product: {$productUrl}\n\nCreated by: " . auth()->user()->name, function ($message) use ($adminEmail, $product) {
                $message->to($adminEmail)
                    ->subject('New Product Created: ' . $product->title);
            });
        } catch (\Exception $e) {
            Log::error('Failed to send product creation email: ' . $e->getMessage());
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = DigitalProduct::findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DigitalProduct $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DigitalProductRequest $request, DigitalProduct $product)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);

        // If product is marked as free, ensure price is null
        if ($data['is_free']) {
            $data['price'] = null;
        }

        if ($request->hasFile('file')) {
            $fileData = $this->fileUploadService->uploadDigitalContent($request->file('file'), $data['file_type']);
            $data = array_merge($data, $fileData);
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_path'] = $this->fileUploadService->uploadThumbnail($request->file('thumbnail'));
        }

        if ($request->hasFile('preview')) {
            $data['preview_path'] = $this->fileUploadService->uploadPreview($request->file('preview'), $data['file_type']);
        }

        $product->update($data);

        // Send email notification
        try {
            $adminEmail = \App\Support\MailRecipients::admin();
            $productUrl = route('products.show', $product->slug);
            
            Mail::raw("A product has been updated.\n\nProduct Details:\nTitle: {$product->title}\nPrice: " . ($product->is_free ? 'Free' : '$' . number_format($product->price, 2)) . "\nType: {$product->file_type}\nStatus: " . ($product->is_active ? 'Active' : 'Inactive') . "\n\nView Product: {$productUrl}\n\nUpdated by: " . auth()->user()->name, function ($message) use ($adminEmail, $product) {
                $message->to($adminEmail)
                    ->subject('Product Updated: ' . $product->title);
            });
        } catch (\Exception $e) {
            Log::error('Failed to send product update email: ' . $e->getMessage());
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DigitalProduct $product)
    {
        $productTitle = $product->title;
        $product->delete();

        // Send email notification
        try {
            $adminEmail = \App\Support\MailRecipients::admin();
            
            Mail::raw("A product has been deleted.\n\nProduct Details:\nTitle: {$productTitle}\n\nDeleted by: " . auth()->user()->name . "\nDeleted at: " . now()->format('Y-m-d H:i:s'), function ($message) use ($adminEmail, $productTitle) {
                $message->to($adminEmail)
                    ->subject('Product Deleted: ' . $productTitle);
            });
        } catch (\Exception $e) {
            Log::error('Failed to send product deletion email: ' . $e->getMessage());
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Toggle the status of the product.
     */
    public function toggleStatus(DigitalProduct $product)
    {
        $product->update([
            'is_active' => !$product->is_active
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $product->is_active,
            'message' => 'Product status updated successfully.'
        ]);
    }

    /**
     * Bulk delete products.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'product_ids' => 'required|string'
        ]);

        $productIds = explode(',', $request->product_ids);
        $productIds = array_filter($productIds, 'is_numeric'); // Remove any non-numeric values

        if (empty($productIds)) {
            return response()->json(['error' => 'No valid products selected for deletion.'], 400);
        }

        $deletedCount = DigitalProduct::whereIn('id', $productIds)->delete();

        return response()->json(['success' => "Successfully deleted {$deletedCount} product(s)."]);
    }
}
