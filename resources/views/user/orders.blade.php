<x-main-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Order History</h1>
                        <p class="mt-2 text-gray-600">Track and manage your purchase history</p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <a href="{{ route('user.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m0 0V1a1 1 0 011-1h2a1 1 0 011 1v18a1 1 0 01-1 1H4a1 1 0 01-1-1V4a1 1 0 011-1h2a1 1 0 011 1v3m0 0h8m-8 0V4" />
                            </svg>
                            My Library
                        </a>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="bg-white rounded-lg shadow mb-6" x-data="{ 
                searchTerm: '{{ request('search', '') }}',
                selectedStatus: '{{ request('status', '') }}',
                dateFrom: '{{ request('date_from', '') }}',
                dateTo: '{{ request('date_to', '') }}',
                applyFilters() {
                    const params = new URLSearchParams();
                    if (this.searchTerm) params.append('search', this.searchTerm);
                    if (this.selectedStatus) params.append('status', this.selectedStatus);
                    if (this.dateFrom) params.append('date_from', this.dateFrom);
                    if (this.dateTo) params.append('date_to', this.dateTo);
                    window.location.href = `${window.location.pathname}?${params.toString()}`;
                },
                clearFilters() {
                    this.searchTerm = '';
                    this.selectedStatus = '';
                    this.dateFrom = '';
                    this.dateTo = '';
                    window.location.href = window.location.pathname;
                }
            }">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Search & Filter Orders</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Search Input -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <div class="relative">
                                <input type="text" 
                                       x-model="searchTerm" 
                                       @keyup.enter="applyFilters()"
                                       placeholder="Order ID or product name..." 
                                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select x-model="selectedStatus" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">All Statuses</option>
                                @foreach($availableStatuses as $status)
                                    <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date From -->
                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                            <input type="date" 
                                   x-model="dateFrom"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <!-- Date To -->
                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                            <input type="date" 
                                   x-model="dateTo"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="mt-4 flex flex-wrap gap-3">
                        <button @click="applyFilters()" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z" />
                            </svg>
                            Apply Filters
                        </button>
                        
                        <button @click="clearFilters()" 
                                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Clear All
                        </button>
                    </div>

                    <!-- Active Filters Display -->
                    @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="text-sm font-medium text-gray-700">Active filters:</span>
                            @if(request('search'))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Search: "{{ request('search') }}"
                                </span>
                            @endif
                            @if(request('status'))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Status: {{ ucfirst(request('status')) }}
                                </span>
                            @endif
                            @if(request('date_from'))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    From: {{ request('date_from') }}
                                </span>
                            @endif
                            @if(request('date_to'))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    To: {{ request('date_to') }}
                                </span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Orders Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Orders</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $orders->total() }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $completedOrders = $orders->where('payment_status', 'completed')->count();
                    $totalSpent = $orders->where('payment_status', 'completed')->sum('total_amount');
                @endphp

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Completed Orders</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $completedOrders }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-indigo-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Spent</dt>
                                    <dd class="text-lg font-medium text-gray-900">${{ number_format($totalSpent, 2) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders List -->
            @if($orders->count() > 0)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Orders
                            <span class="ml-2 text-sm text-gray-500">({{ $orders->total() }} total)</span>
                        </h3>
                    </div>

                    <!-- Desktop view -->
                    <div class="hidden md:block">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($orders as $order)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">#{{ $order->id }}</div>
                                                <div class="text-sm text-gray-500">{{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $order->created_at->format('M d, Y') }}</div>
                                                <div class="text-sm text-gray-500">{{ $order->created_at->format('h:i A') }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">
                                                    @foreach($order->items->take(3) as $item)
                                                        <div class="truncate">{{ $item->product->title }}</div>
                                                    @endforeach
                                                    @if($order->items->count() > 3)
                                                        <div class="text-xs text-gray-500">+{{ $order->items->count() - 3 }} more</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">${{ number_format($order->total_amount, 2) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                    @if($order->payment_status === 'completed') bg-green-100 text-green-800
                                                    @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800
                                                    @endif">
                                                    {{ ucfirst($order->payment_status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                @if($order->payment_status === 'completed')
                                                    <a href="{{ route('user.dashboard') }}" class="text-indigo-600 hover:text-indigo-900">View Products</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Mobile view -->
                    <div class="md:hidden">
                        <div class="divide-y divide-gray-200">
                            @foreach($orders as $order)
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">#{{ $order->id }}</div>
                                            <div class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y h:i A') }}</div>
                                        </div>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            @if($order->payment_status === 'completed') bg-green-100 text-green-800
                                            @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <div class="text-sm font-medium text-gray-700 mb-2">Items:</div>
                                        @foreach($order->items as $item)
                                            <div class="text-sm text-gray-600">• {{ $item->product->title }}</div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="text-lg font-medium text-gray-900">${{ number_format($order->total_amount, 2) }}</div>
                                        @if($order->payment_status === 'completed')
                                            <a href="{{ route('user.dashboard') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">View Products</a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $orders->links() }}
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="mx-auto h-24 w-24 text-gray-400">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No orders found</h3>
                    <p class="mt-2 text-gray-500">
                        @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                            Try adjusting your search criteria or clear the filters.
                        @else
                            You haven't placed any orders yet.
                        @endif
                    </p>
                    @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                        <div class="mt-6">
                            <a href="{{ route('user.orders') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700">
                                Clear Filters
                            </a>
                        </div>
                    @else
                        <div class="mt-6">
                            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700">
                                Start Shopping
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-main-layout>