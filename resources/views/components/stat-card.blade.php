@props([
'title' => '',
'value' => 0,
'icon' => null,
'iconImg' => null,
'iconBg' => 'icon-bg-blue',
'color' => 'primary', // primary | success | warning | danger | info | secondary
'subtitle' => null,
'id' => null,
])
{{--
  x-stat-card — Dashboard statistics widget card

  Usage:
    <x-stat-card
        title="Total Pasien IGD"
        :value="$igd->jumlah_pasien"
        icon="fas fa-procedures"
        icon-bg="icon-bg-blue"
        color="primary"
        subtitle="Kunjungan hari ini" />

  Or with image icon:
    <x-stat-card
        title="Pasien Pulang"
        :value="42"
        icon-img="{{ asset('sb-admin/animasi/pasien-pulang.png') }}"
color="success" />
--}}

@php
$borderColors = [
'primary' => 'border-left-primary',
'success' => 'border-left-success',
'warning' => 'border-left-warning',
'danger' => 'border-left-danger',
'info' => 'border-left-info',
'secondary' => 'border-left-secondary',
];
$borderClass = $borderColors[$color] ?? 'border-left-primary';

$textColors = [
'primary' => 'text-primary',
'success' => 'text-success',
'warning' => 'text-warning',
'danger' => 'text-danger',
'info' => 'text-info',
'secondary' => 'text-secondary',
];
$textClass = $textColors[$color] ?? 'text-primary';
@endphp

<div class="col-xl-3 col-md-6 mb-3" {{ $id ? "id=$id" : '' }}>
    <div class="card {{ $borderClass }} shadow h-100 py-2 pu-stats-card">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col me-2">
                    <div class="text-xs fw-bold {{ $textClass }} text-uppercase mb-1">
                        {{ $title }}
                    </div>
                    <div class="h5 mb-0 fw-bold text-gray-800">
                        {{ number_format((float) $value) }}
                    </div>
                    @if($subtitle)
                    <div class="text-xs text-muted mt-1">{{ $subtitle }}</div>
                    @endif
                </div>
                <div class="col-auto">
                    @if($iconImg)
                    <img src="{{ $iconImg }}" alt="{{ $title }}" class="pu-stats-img"
                        style="width:48px;height:48px;object-fit:contain;opacity:0.85;">
                    @elseif($icon)
                    <div class="pu-icon-wrapper {{ $iconBg }}"
                        style="width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                        <i class="{{ $icon }}" style="font-size:1.25rem;"></i>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>