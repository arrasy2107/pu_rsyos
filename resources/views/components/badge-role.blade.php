@props([
    'role' => null,  // int: 1=Direktur, 2=Pengawas, 3=Keperawatan
])
{{--
  x-badge-role — Consistent role badge

  Usage:
    <x-badge-role :role="$user->id_role" />
--}}
@php
$roles = [
    1 => ['label' => 'Direktur',           'class' => 'bg-primary', 'icon' => 'fas fa-user-tie'],
    2 => ['label' => 'Pengawas Umum',      'class' => 'bg-info',    'icon' => 'fas fa-shield-alt'],
    3 => ['label' => 'Bid. Keperawatan',   'class' => 'bg-success', 'icon' => 'fas fa-user-nurse'],
];
$r = $roles[$role] ?? ['label' => 'Tidak dikenal', 'class' => 'bg-secondary', 'icon' => 'fas fa-user'];
@endphp
<span class="badge {{ $r['class'] }}">
    <i class="{{ $r['icon'] }} me-1"></i>{{ $r['label'] }}
</span>
