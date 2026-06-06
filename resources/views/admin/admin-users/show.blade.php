<x-admin-layout>
<div class="container mx-auto px-4 py-6 max-w-5xl">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.admin-users.index') }}" 
               class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
                <i class='bx bx-arrow-back text-2xl'></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Admin User Details</h1>
        </div>
    </div>

    <!-- User Profile Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 h-32"></div>
        <div class="px-6 pb-6">
            <div class="flex items-end -mt-16 mb-6">
                <div class="w-32 h-32 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center text-white text-5xl font-bold border-4 border-white shadow-lg">
                    {{ strtoupper(substr($adminUser->name, 0, 1)) }}
                </div>
            </div>
            
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $adminUser->name }}</h2>
                    <p class="text-gray-600 mb-3">{{ $adminUser->email }}</p>
                    
                    <div class="flex items-center gap-2 mb-4">
                        @foreach($adminUser->roles as $role)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                {{ $role->name === 'super-admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                <i class='bx {{ $role->name === "super-admin" ? "bx-crown" : "bx-shield" }} mr-1'></i>
                                {{ ucwords(str_replace('-', ' ', $role->name)) }}
                            </span>
                        @endforeach
                    </div>
                </div>

                @if($adminUser->id !== auth()->id() && !$adminUser->hasRole('super-admin'))
                    <form method="POST" action="{{ route('admin.admin-users.destroy', $adminUser) }}" 
                          onsubmit="return confirm('Are you sure you want to delete this admin user? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg transition-colors">
                            <i class='bx bx-trash mr-2'></i>
                            Delete Admin
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <!-- Products Created -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-2">
                <i class='bx bx-book text-3xl text-blue-500'></i>
                <span class="text-2xl font-bold text-gray-900">{{ $adminUser->digitalProducts->count() }}</span>
            </div>
            <p class="text-sm text-gray-600 font-medium">Products Created</p>
        </div>

        <!-- Blog Posts -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-2">
                <i class='bx bx-news text-3xl text-green-500'></i>
                <span class="text-2xl font-bold text-gray-900">{{ $adminUser->blogs->count() }}</span>
            </div>
            <p class="text-sm text-gray-600 font-medium">Blog Posts</p>
        </div>

        <!-- Orders -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-2">
                <i class='bx bx-cart text-3xl text-purple-500'></i>
                <span class="text-2xl font-bold text-gray-900">{{ $adminUser->orders->count() }}</span>
            </div>
            <p class="text-sm text-gray-600 font-medium">Orders</p>
        </div>

        <!-- Member Since -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-2">
                <i class='bx bx-calendar text-3xl text-orange-500'></i>
                <span class="text-sm font-bold text-gray-900">{{ $adminUser->created_at->format('M Y') }}</span>
            </div>
            <p class="text-sm text-gray-600 font-medium">Member Since</p>
        </div>
    </div>

    <!-- Account Information -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Basic Info -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <i class='bx bx-info-circle text-xl text-gray-600 mr-2'></i>
                Account Information
            </h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">User ID</p>
                    <p class="font-semibold text-gray-900">#{{ $adminUser->id }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Full Name</p>
                    <p class="font-semibold text-gray-900">{{ $adminUser->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Email Address</p>
                    <p class="font-semibold text-gray-900">{{ $adminUser->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Role</p>
                    @foreach($adminUser->roles as $role)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                            {{ $role->name === 'super-admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                            <i class='bx {{ $role->name === "super-admin" ? "bx-crown" : "bx-shield" }} mr-1'></i>
                            {{ ucwords(str_replace('-', ' ', $role->name)) }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Activity Info -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <i class='bx bx-time text-xl text-gray-600 mr-2'></i>
                Activity Timeline
            </h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Account Created</p>
                    <p class="font-semibold text-gray-900">{{ $adminUser->created_at->format('F d, Y') }}</p>
                    <p class="text-xs text-gray-500">{{ $adminUser->created_at->diffForHumans() }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Last Updated</p>
                    <p class="font-semibold text-gray-900">{{ $adminUser->updated_at->format('F d, Y') }}</p>
                    <p class="text-xs text-gray-500">{{ $adminUser->updated_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity (if applicable) -->
    @if($adminUser->digitalProducts->count() > 0 || $adminUser->blogs->count() > 0)
        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <i class='bx bx-history text-xl text-gray-600 mr-2'></i>
                Recent Contributions
            </h3>
            
            <div class="space-y-4">
                @if($adminUser->digitalProducts->count() > 0)
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Latest Products</h4>
                        <ul class="space-y-2">
                            @foreach($adminUser->digitalProducts->take(5) as $product)
                                <li class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <div class="flex items-center">
                                        <i class='bx bx-book text-blue-500 mr-3'></i>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $product->title }}</p>
                                            <p class="text-xs text-gray-500">{{ $product->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($adminUser->blogs->count() > 0)
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Latest Blog Posts</h4>
                        <ul class="space-y-2">
                            @foreach($adminUser->blogs->take(5) as $blog)
                                <li class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <div class="flex items-center">
                                        <i class='bx bx-news text-green-500 mr-3'></i>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $blog->title }}</p>
                                            <p class="text-xs text-gray-500">{{ $blog->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        {{ $blog->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $blog->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
</x-admin-layout>

