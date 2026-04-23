<?php

use App\Models\Passenger;

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$passengers = Passenger::whereNull('ticket_code')->get();

foreach ($passengers as $passenger) {
    $passenger->ticket_code = 'TKT-' . strtoupper(bin2hex(random_bytes(4)));
    while (Passenger::where('ticket_code', $passenger->ticket_code)->exists()) {
        $passenger->ticket_code = 'TKT-' . strtoupper(bin2hex(random_bytes(4)));
    }
    $passenger->save();
    echo "Generated ticket code for: " . $passenger->name . " -> " . $passenger->ticket_code . "\n";
}

echo "Done.\n";
