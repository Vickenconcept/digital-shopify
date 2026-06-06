<x-admin-layout>
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Admin Users</h1>
            <p class="text-gray-600 mt-1">Manage administrator accounts (Super Admin Only)</p>
        </div>
        <a href="{{ route('admin.admin-users.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg shadow-md transition-colors duration-200">
            <i class='bx bx-plus text-xl mr-2'></i>
            Create New Admin
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
            <div class="flex items-center">
                <i class='bx bx-check-circle text-2xl text-green-500 mr-3'></i>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
            <div class="flex items-center">
                <i class='bx bx-error-circle text-2xl text-red-500 mr-3'></i>
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('admin.admin-users.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Name or email..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
            </div>

            <!-- Role Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                <select name="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="super-admin" {{ request('role') == 'super-admin' ? 'selected' : '' }}>Super Admin</option>
                </select>
            </div>

            <!-- Sort -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest First</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                    <option value="email" {{ request('sort') == 'email' ? 'selected' : '' }}>Email A-Z</option>
                </select>
            </div>

            <!-- Actions -->
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white font-semibold rounded-lg transition-colors">
                    <i class='bx bx-search'></i> Filter
                </button>
                <a href="{{ route('admin.admin-users.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-900 font-semibold rounded-lg transition-colors">
                    <i class='bx bx-reset'></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Admin Users Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($admins->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Admin</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Joined</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($admins as $admin)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <!-- Admin Info -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $admin->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $admin->email }}</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Role -->
                                <td class="px-6 py-4">
                                    @foreach($admin->roles as $role)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $role->name === 'super-admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                            <i class='bx {{ $role->name === "super-admin" ? "bx-crown" : "bx-shield" }} mr-1'></i>
                                            {{ ucwords(str_replace('-', ' ', $role->name)) }}
                                        </span>
                                    @endforeach
                                </td>

                                <!-- Joined Date -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-900">{{ $admin->created_at->format('M d, Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $admin->created_at->diffForHumans() }}</p>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.admin-users.show', $admin) }}" 
                                           class="inline-flex items-center px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors text-sm font-medium">
                                            <i class='bx bx-show mr-1'></i> View
                                        </a>

                                        @if($admin->id !== auth()->id() && !$admin->hasRole('super-admin'))
                                            <form method="POST" action="{{ route('admin.admin-users.destroy', $admin) }}" 
                                                  onsubmit="return confirm('Are you sure you want to delete this admin user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-medium">
                                                    <i class='bx bx-trash mr-1'></i> Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $admins->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class='bx bx-user-x text-6xl text-gray-400 mb-4'></i>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Admin Users Found</h3>
                <p class="text-gray-600 mb-6">Get started by creating your first admin user.</p>
                <a href="{{ route('admin.admin-users.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg shadow-md transition-colors">
                    <i class='bx bx-plus text-xl mr-2'></i>
                    Create Admin User
                </a>
            </div>
        @endif
    </div>
</div>

</x-admin-layout>
