<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <form method="GET" action="{{ route('admin.reports') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div class="md:col-span-3 flex gap-2">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
                            Tampilkan Laporan
                        </button>
                        <a href="{{ route('admin.reports') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg transition">
                            Reset
                        </a>
                        <button type="button" onclick="window.print()"
                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition ml-auto">
                            🖨️ Print / Export PDF
                        </button>
                    </div>
                </form>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6 print:grid-cols-5">
                <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-blue-600">
                    <p class="text-sm text-gray-600">Total Transaksi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $summary['total_orders'] }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-green-600">
                    <p class="text-sm text-gray-600">Lunas</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $summary['paid_orders'] }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-yellow-600">
                    <p class="text-sm text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $summary['pending_orders'] }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-purple-600">
                    <p class="text-sm text-gray-600">Total Penumpang</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $summary['total_passengers'] }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-indigo-600">
                    <p class="text-sm text-gray-600">Total Revenue</p>
                    <p class="text-xl font-bold text-gray-900">Rp
                        {{ number_format($summary['total_revenue'], 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Report Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Detail Transaksi</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order
                                        Code</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kapal
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Penumpang</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($orders as $index => $order)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 text-sm font-mono text-gray-900">{{ $order->order_code }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            {{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $order->user->name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $order->schedule->ship->name }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $order->total_ticket }}</td>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">Rp
                                            {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            @if ($order->status === 'paid')
                                                <span
                                                    class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">Paid</span>
                                            @elseif($order->status === 'pending')
                                                <span
                                                    class="px-2 py-1 text-xs font-semibold rounded bg-yellow-100 text-yellow-800">Pending</span>
                                            @else
                                                <span
                                                    class="px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-800">Failed</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-12 text-center text-gray-500">
                                            Tidak ada data untuk periode yang dipilih
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .print\:grid-cols-5 {
                grid-template-columns: repeat(5, minmax(0, 1fr));
            }

            nav,
            header,
            .no-print {
                display: none !important;
            }

            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</x-app-layout>
