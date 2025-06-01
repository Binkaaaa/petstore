<div class="p-6 max-w-6xl mx-auto space-y-6 bg-white rounded-2xl shadow-md mt-10">
  <!-- Header -->
  <div class="flex items-center justify-between">
    <h2 class="text-3xl font-extrabold text-gray-900">Registered Users</h2>
    <a href="{{ route('admin.dashboard') }}"
       class="inline-flex items-center px-4 py-2 bg-black text-white border border-black rounded-lg hover:bg-white hover:text-black transition font-semibold">
      Back to Dashboard
    </a>
  </div>

  <!-- Session Message -->
  @if (session()->has('message'))
    <div class="px-4 py-3 rounded-lg bg-green-100 text-green-800 shadow-sm font-semibold">
      {{ session('message') }}
    </div>
  @endif

  <!-- Users Table -->
  <div class="overflow-x-auto bg-white rounded-xl shadow">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Name</th>
          <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Email</th>
          <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Registered At</th>
          <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase">Actions</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-100 font-medium">
        @forelse($users as $user)
          <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4 text-gray-800 font-semibold">{{ $user->name }}</td>
            <td class="px-6 py-4 text-gray-800 font-semibold">{{ $user->email }}</td>
            <td class="px-6 py-4 text-gray-700 font-semibold">{{ $user->created_at->format('Y-m-d') }}</td>
            <td class="px-6 py-4 text-center">
              <button
                onclick="confirm('Are you sure you want to delete this user?') || event.stopImmediatePropagation()"
                wire:click="deleteUser({{ $user->id }})"
                class="border border-red-600 px-3 py-1 rounded hover:bg-red-600 hover:text-white text-red-600 font-semibold transition">
                Delete
              </button>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="px-6 py-4 text-center text-gray-500 font-semibold">No users found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
