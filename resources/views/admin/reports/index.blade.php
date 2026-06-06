<x-admin-layout>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Reports</h1>
            <p class="text-sm text-gray-500 mt-1">Revenue, product performance, and payment health.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.exports.orders', ['date_from' => $from->toDateString()]) }}"
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                <i class="bx bx-download"></i> Export orders
            </a>
            <a href="{{ route('admin.exports.customers') }}"
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                <i class="bx bx-download"></i> Export customers
            </a>
        </div>
    </div>

    <form method="GET" class="flex flex-wrap gap-2">
        @foreach(['7' => '7 days', '30' => '30 days', '90' => '90 days', '365' => '1 year'] as $value => $label)
            <button type="submit" name="period" value="{{ $value }}"
                    class="px-4 py-2 text-sm font-medium rounded-lg {{ $period === $value ? 'bg-orange-500 text-white' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50' }}">
                {{ $label }}
            </button>
        @endforeach
    </form>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <p class="text-xs font-semibold text-gray-500 uppercase">Revenue</p>
            <p class="text-2xl font-bold text-green-600 mt-1">${{ number_format($stats['revenue'], 2) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <p class="text-xs font-semibold text-gray-500 uppercase">Completed orders</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['orders']) }}</p>
            <p class="text-xs text-gray-500 mt-1">Avg ${{ number_format($stats['avg_order'], 2) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <p class="text-xs font-semibold text-gray-500 uppercase">Failed payments</p>
            <p class="text-2xl font-bold text-red-600 mt-1">{{ number_format($stats['failed']) }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ $stats['failure_rate'] }}% failure rate</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <p class="text-xs font-semibold text-gray-500 uppercase">Refunds</p>
            <p class="text-2xl font-bold text-orange-600 mt-1">{{ number_format($stats['refunded']) }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ $stats['refund_rate'] }}% refund rate</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900">Revenue (last 6 months)</h2>
            </div>
            <div class="p-6 space-y-3">
                @foreach($revenueByMonth as $row)
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">{{ $row['label'] }}</span>
                        <span class="font-semibold text-gray-900">${{ number_format($row['revenue'], 2) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900">Top products</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Sales</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($topProducts as $product)
                            <tr>
                                <td class="px-6 py-3 text-gray-900">{{ $product->title }}</td>
                                <td class="px-6 py-3 text-right">{{ $product->sales_count }}</td>
                                <td class="px-6 py-3 text-right font-medium">${{ number_format($product->revenue ?? 0, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-6 py-8 text-center text-gray-500">No sales in this period.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
        <p class="text-sm text-gray-600">
            <strong>{{ number_format($stats['pending']) }}</strong> pending checkout(s) in the selected period.
        </p>
    </div>
</div>
</x-admin-layout>
