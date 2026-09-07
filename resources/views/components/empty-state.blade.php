@props([
    'icon'    => 'fas fa-inbox',
    'title'   => 'Belum ada data',
    'message' => 'Data yang Anda cari belum tersedia.',
])
{{--
  x-empty-state — Consistent empty state for tables and content areas

  Usage:
    <x-empty-state
        icon="fas fa-file-alt"
        title="Belum ada laporan"
        message="Laporan untuk hari ini belum tersedia." />
--}}
<div class="pu-empty-state">
    <div class="empty-icon">
        <i class="{{ $icon }}"></i>
    </div>
    <h3>{{ $title }}</h3>
    <p>{{ $message }}</p>
    @if(isset($slot) && !empty(trim($slot)))
    <div class="mt-3">{{ $slot }}</div>
    @endif
</div>
