<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Scan QR Tiket') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Scanner Section -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                        Scanner Kamerea
                    </h3>
                    
                    <div id="reader" class="rounded-xl overflow-hidden border-4 border-gray-50 bg-gray-50" style="width: 100%"></div>
                    
                    <div id="manual-input" class="mt-6">
                        <p class="text-sm text-gray-500 mb-2">Atau masukkan kode tiket secara manual:</p>
                        <div class="flex gap-2">
                            <input type="text" id="ticket_code_input" class="flex-1 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: TKT-XXXXXX">
                            <button id="validate_btn" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition shadow-md">
                                Validasi
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Result Section -->
                <div class="space-y-6">
                    <div id="result-container" class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-8 border border-gray-100 hidden">
                        <div id="result-content">
                            <!-- Success/Error icon will be injected here -->
                            <div id="status-icon" class="mb-6 flex justify-center"></div>
                            
                            <h3 id="status-message" class="text-2xl font-bold text-center mb-8"></h3>
                            
                            <div id="passenger-info" class="space-y-4 bg-gray-50 p-6 rounded-xl border border-gray-100">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wider">Nama</p>
                                        <p id="p-name" class="font-bold text-gray-900"></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wider">NIK</p>
                                        <p id="p-nik" class="font-bold text-gray-900"></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wider">Kapal</p>
                                        <p id="p-ship" class="font-bold text-gray-900"></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wider">Tujuan</p>
                                        <p id="p-route" class="font-bold text-gray-900"></p>
                                    </div>
                                </div>
                            </div>

                            <button onclick="resetScanner()" class="mt-8 w-full bg-gray-100 hover:bg-gray-200 text-gray-900 font-bold py-3 rounded-xl transition">
                                Scan Berikutnya
                            </button>
                        </div>
                    </div>

                    <div id="placeholder-container" class="bg-white overflow-hidden shadow-md sm:rounded-2xl p-8 border border-gray-100 flex flex-col items-center justify-center text-center py-20">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500 font-medium">Menunggu scan tiket...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 10, qrbox: {width: 250, height: 250} }, /* verbose= */ false);
        
        function onScanSuccess(decodedText, decodedResult) {
            // handle the scanned code as you like, for example:
            console.log(`Code matched = ${decodedText}`, decodedResult);
            validateTicket(decodedText);
            html5QrcodeScanner.clear();
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
            // console.warn(`Code scan error = ${error}`);
        }

        html5QrcodeScanner.render(onScanSuccess, onScanFailure);

        document.getElementById('validate_btn').addEventListener('click', function() {
            const code = document.getElementById('ticket_code_input').value;
            if (code) {
                validateTicket(code);
            }
        });

        function validateTicket(code) {
            fetch('{{ route('admin.validate-ticket') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ ticket_code: code })
            })
            .then(response => response.json())
            .then(data => {
                showResult(data);
            })
            .catch(error => {
                console.error('Error:', error);
                showResult({ success: false, message: 'Terjadi kesalahan sistem.' });
            });
        }

        function showResult(data) {
            const container = document.getElementById('result-container');
            const placeholder = document.getElementById('placeholder-container');
            const iconContainer = document.getElementById('status-icon');
            const statusMessage = document.getElementById('status-message');
            const passengerInfo = document.getElementById('passenger-info');
            
            placeholder.classList.add('hidden');
            container.classList.remove('hidden');

            if (data.success) {
                iconContainer.innerHTML = `<div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>`;
                statusMessage.textContent = 'VALID';
                statusMessage.className = 'text-2xl font-bold text-center mb-8 text-green-600';
                
                // Fill passenger info
                document.getElementById('p-name').textContent = data.passenger.name;
                document.getElementById('p-nik').textContent = data.passenger.nik;
                document.getElementById('p-ship').textContent = data.passenger.order.schedule.ship.name;
                document.getElementById('p-route').textContent = `${data.passenger.order.schedule.origin_port.name} → ${data.passenger.order.schedule.destination_port.name}`;
                passengerInfo.classList.remove('hidden');
            } else {
                iconContainer.innerHTML = `<div class="w-20 h-20 bg-red-100 text-red-600 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>`;
                statusMessage.textContent = data.message;
                statusMessage.className = 'text-xl font-bold text-center mb-8 text-red-600';
                
                if (data.passenger) {
                    document.getElementById('p-name').textContent = data.passenger.name;
                    document.getElementById('p-nik').textContent = data.passenger.nik;
                    document.getElementById('p-ship').textContent = data.passenger.order.schedule.ship.name;
                    document.getElementById('p-route').textContent = `${data.passenger.order.schedule.origin_port.name} → ${data.passenger.order.schedule.destination_port.name}`;
                    passengerInfo.classList.remove('hidden');
                } else {
                    passengerInfo.classList.add('hidden');
                }
            }
        }

        function resetScanner() {
            document.getElementById('result-container').classList.add('hidden');
            document.getElementById('placeholder-container').classList.remove('hidden');
            document.getElementById('ticket_code_input').value = '';
            
            // Restart scanner
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        }
    </script>
</x-app-layout>
