@props([
    'role' => null,  // int: 0=Super Admin, 1=Direktur, 2=Pengawas, 3=Keperawatan
])
{{--
  x-badge-role — Consistent role badge

  Usage:
    <x-badge-role :role="$user->id_role" />
--}}
@php
$roles = [
    0 => ['label' => 'Super Admin',         'class' => 'bg-danger',  'icon' => 'fas fa-user'],
    1 => ['label' => 'Direksi',            'class' => 'bg-primary', 'icon' => 'fas fa-user'],
    2 => ['label' => 'Pengawas',       'class' => 'bg-warning text-dark',    'icon' => 'fas fa-user'],
    3 => ['label' => 'Keperawatan',    'class' => 'bg-success', 'icon' => 'fas fa-user'],
];
$r = $roles[$role] ?? ['label' => 'Tidak dikenal', 'class' => 'bg-secondary', 'icon' => 'fas fa-user'];
@endphp
<span class="badge {{ $r['class'] }}">
    <i class="{{ $r['icon'] }} me-2"></i>{{ $r['label'] }}
</span>
