<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Konfirmasi Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="text-center mb-8">
                        <div class="inline-block p-3 bg-blue-100 rounded-full mb-4">
                            <span class="text-3xl">💳</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Selesaikan Pembayaran</h3>
                        <p class="text-gray-600">Kode Order: <span
                                class="font-mono font-bold">{{ $order->order_code }}</span></p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6 mb-8 border border-gray-100">
                        <div class="flex justify-between mb-2 text-sm text-gray-600">
                            <span>Ship:</span>
                            <span class="font-bold text-gray-800">{{ $order->schedule->ship->name }}</span>
                        </div>
                        <div class="flex justify-between mb-2 text-sm text-gray-600">
                            <span>Tickets:</span>
                            <span class="font-bold text-gray-800">{{ $order->total_ticket }} Tiket</span>
                        </div>
                        <div class="pt-4 mt-4 border-t flex justify-between">
                            <span class="text-lg font-bold">Total:</span>
                            <span class="text-xl font-bold text-blue-600">Rp
                                {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <button id="pay-button"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-lg transition shadow-lg text-lg">
                            Bayar Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.client_key') }}"></script>
        <script type="text/javascript">
            const payButton = document.getElementById('pay-button');
            payButton.onclick = function() {
                window.snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        window.location.href =
                            '{{ route('payment.finish') }}?order_id={{ $order->order_code }}&status=success';
                    },
                    onPending: function(result) {
                        window.location.href =
                            '{{ route('payment.finish') }}?order_id={{ $order->order_code }}&status=pending';
                    },
                    onError: function(result) {
                        window.location.href =
                            '{{ route('payment.finish') }}?order_id={{ $order->order_code }}&status=error';
                    },
                    onClose: function() {
                        alert('Anda belum menyelesaikan pembayaran.');
                    }
                });
            };
        </script>
    @endpush
</x-app-layout>
