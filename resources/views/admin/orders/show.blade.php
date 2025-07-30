<x-admin-layout>
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <a href="{{ route('admin.orders.index') }}" 
                   class="inline-flex items-center p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors mr-4">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Order Details</h1>
                            <p class="mt-2 text-sm text-gray-600">View details for order #{{ $order->id }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-500">Order ID: <span class="font-mono">#{{ $order->id }}</span></div>
                            <div class="text-sm text-gray-500">Created: {{ $order->created_at->format('M d, Y') }}</div>
                            <div class="text-sm text-gray-500">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($order->payment_status === 'completed') bg-green-100 text-green-800
                                    @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Items -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-600">Total Items</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $order->items->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Amount -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-600">Total Amount</p>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($order->total_amount, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Payment Status -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 
                            @if($order->payment_status === 'completed') bg-green-100
                            @elseif($order->payment_status === 'pending') bg-yellow-100
                            @else bg-red-100
                            @endif rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 
                                @if($order->payment_status === 'completed') text-green-600
                                @elseif($order->payment_status === 'pending') text-yellow-600
                                @else text-red-600
                                @endif" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                @if($order->payment_status === 'completed')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                @elseif($order->payment_status === 'pending')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                @endif
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-600">Payment Status</p>
                        <p class="text-lg font-bold 
                            @if($order->payment_status === 'completed') text-green-600
                            @elseif($order->payment_status === 'pending') text-yellow-600
                            @else text-red-600
                            @endif">
                            {{ ucfirst($order->payment_status) }}
                        </p>
                        @if($order->paid_at)
                            <p class="text-xs text-gray-500">Paid {{ $order->paid_at->diffForHumans() }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Order Items -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Items List -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Order Items</h3>
                        <p class="mt-1 text-sm text-gray-600">Digital products included in this order.</p>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($order->items as $item)
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-16 w-16">
                                        @if($item->product->thumbnail_path)
                                            <img class="h-16 w-16 rounded-lg object-cover" 
                                                 src="{{ asset('storage/' . $item->product->thumbnail_path) }}" 
                                                 alt="{{ $item->product->title }}">
                                        @else
                                            <div class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-6 flex-1">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="text-lg font-medium text-gray-900">
                                                    <a href="{{ route('admin.products.edit', $item->product) }}" class="hover:text-blue-600">
                                                        {{ $item->product->title }}
                                                    </a>
                                                </h4>
                                                <div class="mt-1 flex items-center space-x-2 text-sm text-gray-500">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                        {{ ucfirst($item->product->file_type) }}
                                                    </span>
                                                    <span>•</span>
                                                    <span>{{ $item->product->category->name }}</span>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-lg font-medium text-gray-900">${{ number_format($item->price, 2) }}</p>
                                                <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <div class="flex justify-between text-base font-medium text-gray-900">
                            <p>Total</p>
                            <p>${{ number_format($order->total_amount, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Payment Information</h3>
                        <p class="mt-1 text-sm text-gray-600">Details about the payment transaction.</p>
                    </div>
                    <div class="p-6">
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($order->payment_method ?? 'N/A') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Payment ID</dt>
                                <dd class="mt-1 text-sm font-mono text-gray-900">{{ $order->payment_id ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Payment Status</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($order->payment_status === 'completed') bg-green-100 text-green-800
                                        @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </dd>
                            </div>
                            @if($order->paid_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Payment Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $order->paid_at->format('M d, Y \a\t g:i A') }}
                                        <span class="text-gray-500">({{ $order->paid_at->diffForHumans() }})</span>
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="space-y-6">
                <!-- Customer Details -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Customer Information</h3>
                        <p class="mt-1 text-sm text-gray-600">Details about the customer who placed this order.</p>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-16 w-16">
                                @if($order->user->profile && $order->user->profile->avatar_path)
                                    <img class="h-16 w-16 rounded-full object-cover border-2 border-gray-200" 
                                         src="{{ asset('storage/' . $order->user->profile->avatar_path) }}" 
                                         alt="{{ $order->user->name }}">
                                @else
                                    <div class="h-16 w-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center border-2 border-gray-200">
                                        <span class="text-2xl font-semibold text-white">
                                            {{ substr($order->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900">
                                    <a href="{{ route('admin.users.show', $order->user) }}" class="hover:text-blue-600">
                                        {{ $order->user->name }}
                                    </a>
                                </h4>
                                <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                                <div class="mt-1 flex items-center space-x-2">
                                    @foreach($order->user->roles as $role)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                            @if($role->name === 'super-admin') bg-purple-100 text-purple-800
                                            @elseif($role->name === 'admin') bg-blue-100 text-blue-800
                                            @elseif($role->name === 'content-creator') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst(str_replace('-', ' ', $role->name)) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 border-t border-gray-200 pt-6">
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $order->user->created_at->format('M d, Y') }}
                                        <span class="text-gray-500">({{ $order->user->created_at->diffForHumans() }})</span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Total Orders</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $order->user->orders->count() }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Total Spent</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        ${{ number_format($order->user->orders->where('payment_status', 'completed')->sum('total_amount'), 2) }}
                                    </dd>
                                </div>
                                @if($order->user->profile)
                                    @if($order->user->profile->phone)
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $order->user->profile->phone }}</dd>
                                        </div>
                                    @endif
                                    @if($order->user->profile->address)
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Address</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                {{ $order->user->profile->address }}<br>
                                                @if($order->user->profile->city || $order->user->profile->state || $order->user->profile->postal_code)
                                                    {{ $order->user->profile->city }}{{ $order->user->profile->state ? ', ' . $order->user->profile->state : '' }}{{ $order->user->profile->postal_code ? ' ' . $order->user->profile->postal_code : '' }}<br>
                                                @endif
                                                @if($order->user->profile->country)
                                                    {{ $order->user->profile->country }}
                                                @endif
                                            </dd>
                                        </div>
                                    @endif
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Order Timeline -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Order Timeline</h3>
                        <p class="mt-1 text-sm text-gray-600">History of order events and updates.</p>
                    </div>
                    <div class="p-6">
                        <div class="flow-root">
                            <ul role="list" class="-mb-8">
                                @if($order->paid_at)
                                    <li>
                                        <div class="relative pb-8">
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                    <div>
                                                        <p class="text-sm text-gray-500">Payment completed</p>
                                                    </div>
                                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                        <time datetime="{{ $order->paid_at->format('Y-m-d\TH:i:s') }}">{{ $order->paid_at->format('M d, Y \a\t g:i A') }}</time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                                <li>
                                    <div class="relative pb-8">
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">Order created</p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    <time datetime="{{ $order->created_at->format('Y-m-d\TH:i:s') }}">{{ $order->created_at->format('M d, Y \a\t g:i A') }}</time>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    @if($order->payment_status !== 'completed')
                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-red-300 rounded-lg shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors"
                                    onclick="return confirm('Are you sure you want to delete this order? This action cannot be undone.')">
                                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete Order
                            </button>
                        </form>
                    @else
                        <span class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-500 bg-gray-50 cursor-not-allowed">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728" />
                            </svg>
                            Cannot Delete (Completed Order)
                        </span>
                    @endif
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.orders.index') }}" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>