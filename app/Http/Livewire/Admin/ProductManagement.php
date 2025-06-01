<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class ProductManagement extends Component
{
    use WithFileUploads;

    public $products;
    public $categories;
    public $name, $description, $price, $stock, $image, $category_id;
    public $editMode = false;
    public $productId;
    public $showForm = false; // <-- Added to toggle form display

    public function mount()
    {
        $this->categories = Category::all();
        $this->products = Product::with('category')->get();
    }

    public function render()
    {
        return view('livewire.admin.product-management');
    }

    public function resetForm()
    {
        $this->name = null;
        $this->description = null;
        $this->price = null;
        $this->stock = null;
        $this->image = null;
        $this->category_id = null;
        $this->productId = null;
        $this->editMode = false;
    }
    public $iteration = 0;


    public function toggleForm()
    {
        $this->resetForm();
        $this->showForm = ! $this->showForm;

        // Force Livewire to re-render the file input
        $this->iteration++;
    }

    
public function addProduct()
{
    $this->validate([
        'name'        => 'required',
        'description' => 'required',
        'price'       => 'required|numeric',
        'stock'       => 'required|integer',
        'category_id' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:20480',

    ]);

    // Store the file on the "public" disk if present:
    $imagePath = null;
    if ($this->image) {
        $imagePath = $this->image->store('products', 'public');
    }

    // **DEBUG:** dump the path (or null) so you can confirm

    // If you see a string like "products/abc123.jpg", Laravel has stored it correctly.
    // If you get `null`, Livewire never sent the file payload.

    Product::create([
        'name'        => $this->name,
        'description' => $this->description,
        'price'       => $this->price,
        'stock'       => $this->stock,
        'category_id' => $this->category_id,
        'image'       => $imagePath,
        'user_id'     => Auth::guard('admin')->id(), 
    ]);

    $this->resetForm();
    $this->showForm   = false;
    $this->products   = Product::with('category')->get();
}


    public function editProduct($id)
    {
        $this->resetForm();

        $product = Product::findOrFail($id);
        $this->productId = $id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->category_id = $product->category_id;

        $this->editMode = true;
        $this->showForm = true;
    }

    public function updateProduct()
    {
        $product = Product::findOrFail($this->productId);

        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:20480',
        ]);

        if ($this->image) {
            $imagePath = $this->image->store('products', 'public');
            $product->image = $imagePath;
        }
        $product->update([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'category_id' => $this->category_id,
            
        ]);

        $this->resetForm();
        $this->showForm = false;
        $this->products = Product::with('category')->get();
    }

    public function deleteProduct($id)
    {
        Product::destroy($id);
        $this->products = Product::with('category')->get();
    }
    public function showByCategory($categoryId)
    {
        // Get the category by ID
        $category = Category::findOrFail($categoryId);

        // Get products of that category
        $products = Product::where('category_id', $categoryId)->get();

        // Pass both to the view
        return view('products.by-category', compact('category', 'products'));
    }

}
