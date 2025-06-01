<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductManagement extends Component
{
    use WithFileUploads;

    public $categories;     // for the <select> dropdown

    public $showForm         = false;
    public $editMode         = false;
    public $productId        = null;
    public $name;
    public $description;
    public $price;
    public $stock;
    public $category_id;
    public $image;            // TemporaryUploadedFile, if present
    public $existingImage;    // existing filename when editing
    public $iteration = 0;    // to reset file input

    protected $rules = [
        'name'        => 'required|string|max:255',
        'description' => 'nullable|string',
        'price'       => 'required|numeric|min:0',
        'stock'       => 'required|integer|min:0',
        'category_id' => 'nullable|exists:categories,id',
        'image' => 'nullable|mimes:jpg,jpeg,png,webp,avif|max:5120'

    ];

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function toggleForm()
    {
        $this->resetForm();
        $this->showForm = ! $this->showForm;
    }

    protected function resetForm()
    {
        $this->reset([
            'name',
            'description',
            'price',
            'stock',
            'category_id',
            'image',
            'existingImage',
            'productId',
            'editMode',
        ]);

        // Increment to force <input type="file"> to clear
        $this->iteration++;
    }

    public function addProduct()
    {
        // DEBUG: log that we made it here
        info("addProduct() called. name={$this->name}, price={$this->price}");

        $this->validate();

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('products', 'public');
            info("Stored image at: $imagePath");
        }

        // Hard‐code user_id 1 for debugging; be sure user #1 exists
        $userId = Auth::id() ?? 1;
        info("Using user_id=$userId");

        Product::create([
            'name'        => $this->name,
            'description' => $this->description,
            'price'       => $this->price,
            'stock'       => $this->stock,
            'category_id' => $this->category_id,
            'image'       => $imagePath,
            'user_id'     => $userId,
        ]);

        session()->flash('success', 'Product added successfully.');

        $this->resetForm();
        $this->showForm = false;
    }

    public function editProduct($id)
    {
        $this->resetForm();
        $this->editMode = true;
        $this->showForm = true;

        $product = Product::findOrFail($id);

        $this->productId     = $product->id;
        $this->name          = $product->name;
        $this->description   = $product->description;
        $this->price         = $product->price;
        $this->stock         = $product->stock;
        $this->category_id   = $product->category_id;
        $this->existingImage = $product->image;
    }

    public function updateProduct()
    {
        $this->validate();

        $product = Product::findOrFail($this->productId);

        if ($this->image) {
            // Delete old file if you want:
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $storedPath         = $this->image->store('products', 'public');
            $product->image     = $storedPath;
            info("Replaced image, new path: $storedPath");
        }

        $product->update([
            'name'        => $this->name,
            'description' => $this->description,
            'price'       => $this->price,
            'stock'       => $this->stock,
            'category_id' => $this->category_id,
            // ‘image’ was already set above if we uploaded a new one
        ]);

        session()->flash('success', 'Product updated successfully.');

        $this->resetForm();
        $this->showForm = false;
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        session()->flash('success', 'Product deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.product-management', [
            'products'   => Product::with('category')->paginate(20),
            'categories' => $this->categories,
        ]);
    }
}
