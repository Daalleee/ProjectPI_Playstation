<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$u = App\Models\UnitPS::first();
echo "ID: " . $u->id . "\n";
echo "STOCK (DB): " . $u->getAttributes()['stock'] . "\n";
echo "STOK (DB): " . ($u->getAttributes()['stok'] ?? 'NULL') . "\n";
echo "KONDISI (DB): " . ($u->getAttributes()['kondisi'] ?? 'NULL') . "\n";
echo "STATUS (DB): " . ($u->getAttributes()['status'] ?? 'NULL') . "\n";
echo "STOK (Accessor): " . $u->stok . "\n";
