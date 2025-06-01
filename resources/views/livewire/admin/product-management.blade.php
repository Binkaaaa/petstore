<div class="p-6 space-y-6">
  <!-- Header -->
  <div class="flex items-center justify-between">
    <h2 class="text-3xl font-bold text-gray-900">Product Management</h2>
    <div class="flex space-x-3">
      <a href="{{ route('admin.dashboard') }}"
         class="inline-flex items-center px-4 py-2 bg-white text-black border border-black rounded-lg hover:bg-black hover:text-white transition">
        ← Dashboard
      </a>
      <button wire:click="toggleForm"
              class="inline-flex items-center px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition">
        {{ $showForm ? 'Close Form' : 'Add Product' }}
      </button>
    </div>
  </div>

  <!-- Modal Form -->
  @if($showForm)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-8">
        <h3 class="text-2xl font-semibold mb-6">
          {{ $editMode ? 'Edit Product' : 'Add Product' }}
        </h3>
        <form wire:submit.prevent="{{ $editMode ? 'updateProduct' : 'addProduct' }}" class="space-y-4">
          <input type="text" wire:model="name" placeholder="Name"
                 class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-black" />
          <textarea wire:model="description" placeholder="Description"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-black"></textarea>
          <div class="grid grid-cols-2 gap-4">
            <input type="number" wire:model="price" placeholder="Price"
                   class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-black" />
            <input type="number" wire:model="stock" placeholder="Stock"
                   class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-black" />
          </div>
          <select wire:model="category_id"
                  class="w-full border border-gray-300 p-3 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-black">
            <option value="">-- Select Category --</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
          </select>
          @if ($image)
            <img src="{{ $image->temporaryUrl() }}" class="h-24 w-24 object-cover rounded-lg mb-4" />
          @endif
          <input
            type="file"
            wire:model="image"
            wire:key="image-input-{{ $iteration }}"
            class="w-full text-black"
          />


          <div class="flex justify-end space-x-3 pt-4">
            <button type="button" wire:click="toggleForm"
                    class="px-5 py-2 bg-gray-200 text-black rounded-lg hover:bg-gray-300 transition">
              Cancel
            </button>
            <button type="submit"
                    class="px-5 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition">
              {{ $editMode ? 'Update' : 'Save' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  @endif

    <!-- Products Table -->
  <div class="overflow-x-auto bg-white rounded-xl shadow">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Image</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
          <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Price</th>
          <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Stock</th>
          <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($products as $product)
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4">
              @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     class="h-16 w-16 rounded-lg object-cover" />
              @else
                <span class="text-gray-400 italic">No Image</span>
              @endif
            </td>
            <td class="px-6 py-4">{{ $product->name }}</td>
            <td class="px-6 py-4 text-gray-700">{{ Str::limit($product->description, 50) }}</td>
            <td class="px-6 py-4">{{ $product->category->name }}</td>
            <td class="px-6 py-4 text-right">${{ number_format($product->price, 2) }}</td>
            <td class="px-6 py-4 text-right">{{ $product->stock }}</td>
            <td class="px-6 py-4 text-center space-x-2">
                <button
                    wire:click="editProduct({{ $product->id }})"
                    class="inline-flex items-center justify-center px-4 py-2 g-white text-black border border-black rounded hover:bg-black hover:text-white transition w-24"
                >
                    Edit
                </button>
                <button
                    onclick="confirm('Are you sure you want to delete this product?') || event.stopImmediatePropagation()"
                    wire:click="deleteProduct({{ $product->id }})"
                    class="inline-flex items-center justify-center px-4 py-2 bg-white text-black border border-black rounded hover:bg-black hover:text-white transition w-24"
                >
                    Delete
                </button>
                </td>

          </tr>
        @endforeach
      </tbody>
    </table>
    </div>

</div>