<?php
require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

function createOrUpdateUser($username, $name, $nip, $roleId, $password)
{
    $user = \App\Models\User::where('username', $username)->first();
    if (! $user) {
        $user = new \App\Models\User();
    }

    $user->nama = $name;
    $user->nip = $nip;
    $user->username = $username;
    $user->password = Illuminate\Support\Facades\Hash::make($password);
    $user->id_role = $roleId;
    $user->status = 1;
    $user->save();

    echo "User created/updated: {$user->username} | role={$user->id_role} | id={$user->id}\n";
}

createOrUpdateUser('admin', 'Direktur Test', '0000000001', 1, '12345678');
createOrUpdateUser('pengawas', 'Pengawas Test', '0000000002', 2, '12345678');
createOrUpdateUser('keperawatan', 'Keperawatan Test', '0000000003', 3, '12345678');
