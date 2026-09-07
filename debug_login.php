<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::where('username', 'admin')->first();
if (! $user) {
    echo "USER_NOT_FOUND\n";
    exit(1);
}

echo "USER_EXISTS\n";
echo "username=" . $user->username . "\n";
echo "role=" . $user->id_role . "\n";
echo "status=" . $user->status . "\n";
echo "password_hash=" . $user->password . "\n";
echo "hash_check=" . (Illuminate\Support\Facades\Hash::check('12345678', $user->password) ? 'true' : 'false') . "\n";

$ok = Auth::attempt([
    'username' => 'admin',
    'password' => '12345678',
    'id_role' => 1,
    'status' => 1,
]);
echo "attempt=" . ($ok ? 'true' : 'false') . "\n";
if ($ok) {
    echo "authenticated_user_id=" . Auth::id() . "\n";
}
