<div class="p-6 space-y-8 bg-white max-w-7xl mx-auto">
  <!-- Header -->
  <div class="flex items-center justify-between">
    <h2 class="text-3xl font-bold">Product Management</h2>
    <div class="flex space-x-3">
      <a href="{{ route('admin.dashboard') }}" class="px-5 py-2 border rounded-lg hover:bg-black hover:text-white">
        Back to Dashboard
      </a>
      <button wire:click="toggleForm" class="px-5 py-2 bg-black text-white rounded-lg hover:bg-gray-800">
        {{ $showForm ? 'Close Form' : 'Add Product' }}
      </button>
    </div>
  </div>

  <!-- Flash Messages -->
  @if (session()->has('success'))
    <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-800">
      {{ session('success') }}
    </div>
  @endif
  @if (session()->has('error'))
    <div class="mb-6 px-4 py-3 bg-red-50 border border-red-200 text-red-800">
      {{ session('error') }}
    </div>
  @endif

  <!-- Modal Form -->
  @if($showForm)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
      <div class="bg-white rounded-2xl shadow-lg max-w-lg w-full p-8">
        <h3 class="text-2xl font-semibold mb-6">{{ $editMode ? 'Edit Product' : 'Add Product' }}</h3>
       <form
            wire:submit.prevent="{{ $editMode ? 'updateProduct' : 'addProduct' }}"
            enctype="multipart/form-data"
            class="space-y-6"
          >
          <!-- Name -->
          <div>
            <input type="text" wire:model="name" placeholder="Name"
                   class="w-full border border-gray-300 rounded-lg p-3" />
            @error('name')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Description -->
          <div>
            <textarea wire:model="description" placeholder="Description" rows="4"
                      class="w-full border border-gray-300 rounded-lg p-3"></textarea>
            @error('description')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Price + Stock -->
          <div class="grid grid-cols-2 gap-6">
            <div>
              <input type="number" wire:model="price" placeholder="Price"
                     class="w-full border border-gray-300 rounded-lg p-3" />
              @error('price')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>
            <div>
              <input type="number" wire:model="stock" placeholder="Stock"
                     class="w-full border border-gray-300 rounded-lg p-3" />
              @error('stock')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Category -->
          <div>
            <select wire:model="category_id"
                    class="w-full border border-gray-300 rounded-lg p-3 bg-white">
              <option value="">-- Select Category --</option>
              @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
              @endforeach
            </select>
            @error('category_id')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Image Upload -->
          <div>
            @if ($image)
              <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                   class="h-24 w-24 object-cover rounded-lg mb-4" />
            @endif
            <input type="file" wire:model="image" wire:key="image-input-{{ $iteration }}"
                   class="w-full text-black" />
            @error('image')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Buttons -->
          <div class="flex justify-end space-x-4 pt-4">
            <button type="button" wire:click="toggleForm"
                    class="px-6 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
              Cancel
            </button>
            <button type="submit"
                    class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-800">
              {{ $editMode ? 'Update' : 'Save' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  @endif

  <!-- Products Table -->
  <div class="overflow-x-auto rounded-xl shadow-md border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Image</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Name</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Description</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Category</th>
          <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Price</th>
          <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Stock</th>
          <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Actions</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($products as $product)
          <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4 whitespace-nowrap">
              @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                     class="h-16 w-16 rounded-lg object-cover border" />
              @else
                <span class="text-gray-400 italic">No Image</span>
              @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">{{ $product->name }}</td>
            <td class="px-6 py-4 text-gray-700">{{ Str::limit($product->description, 50) }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $product->category->name }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-gray-900 font-semibold">Rs.{{ number_format($product->price, 2) }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-gray-900 font-semibold">{{ $product->stock }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
              <button wire:click="editProduct({{ $product->id }})"
                      class="border px-3 py-1 rounded border-black hover:bg-black hover:text-white">
                Edit
              </button>
              <button onclick="confirm('Are you sure?')||event.stopImmediatePropagation()"
                      wire:click="deleteProduct({{ $product->id }})"
                      class="border border-red-600 px-3 py-1 rounded hover:bg-red-600 hover:text-white text-red-600">
                Delete
              </button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
