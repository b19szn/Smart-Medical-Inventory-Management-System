<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Update all user passwords
$users = [
    'admin@smartmedical.com' => 'password',
    'hospital@smartmedical.com' => 'password',
    'staff@smartmedical.com' => 'password',
    'supplier@smartmedical.com' => 'password',
];

foreach ($users as $email => $password) {
    $user = User::where('email', $email)->first();
    if ($user) {
        $user->password = Hash::make($password);
        $user->save();
        echo "Updated password for: $email\n";
    }
}

echo "\nAll passwords updated successfully!\n";
echo "You can now login with:\n";
echo "Email: admin@smartmedical.com\n";
echo "Password: password\n";
