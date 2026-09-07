@props([
    'title'    => '',
    'subtitle' => null,
])
{{--
  x-page-header — Consistent page header with title, subtitle and action slot

  Usage:
    <x-page-header title="Data Pengguna" subtitle="Kelola akun pengguna sistem">
        <x-slot name="actions">
            <button class="btn btn-primary">Tambah</button>
        </x-slot>
    </x-page-header>
--}}
<div class="pu-page-header">
    <div>
        <h1>{{ $title }}</h1>
        @if($subtitle)
        <p class="pu-page-subtitle">{{ $subtitle }}</p>
        @endif
    </div>
    @if(isset($actions))
    <div class="pu-page-header-actions">
        {{ $actions }}
    </div>
    @endif
</div>
