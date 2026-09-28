<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'id_role',
        'status',
        'akses_menu',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'akses_menu'        => 'array',
    ];

    /**
     * Cek apakah user memiliki akses ke menu tertentu.
     * Super admin (id_role=0) selalu mendapat akses penuh.
     *
     * @param  string  $menu  Nama slug menu, e.g. 'data-ruangan'
     * @return bool
     */
    public function hasMenuAccess(string $menu): bool
    {
        // Super admin mendapat akses ke semua menu
        if ($this->id_role === 0) {
            return true;
        }

        // Jika akses_menu belum di-set (null), izinkan akses (backward-compat)
        if (is_null($this->akses_menu)) {
            return true;
        }

        return in_array($menu, $this->akses_menu);
    }
}
