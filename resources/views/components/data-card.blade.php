@props([
'title' => null,
'icon' => null,
'iconClass' => 'text-primary',
'id' => null,
'class' => '',
'collapsible' => false,
'collapsed' => false,
'gradient' => false,
'parent' => null,
])
{{--
  x-data-card — Standard card wrapper for CRUD tables and forms

  Usage (simple):
    <x-data-card title="Daftar Pengguna" icon="fas fa-users">
        ...content...
    </x-data-card>

  Usage (with header actions):
    <x-data-card title="Tabel Data">
        <x-slot name="headerActions">
            <button class="btn btn-sm btn-primary">Export</button>
        </x-slot>
        ...content...
    </x-data-card>

  Usage (collapsible):
    <x-data-card title="IGD" :collapsible="true" :gradient="true" id="collapseIGD">
        ...content...
    </x-data-card>
--}}

@php
$cardId = $id ?? 'card-' . Str::random(6);
$collapseId = 'collapse-' . $cardId;
@endphp

<div class="card mb-4 animate-fade-in-up {{ $class }}" {{ $id ? "id=$cardId" : '' }}>

    @if($title || isset($headerActions))
    <div class="card-header d-flex justify-content-between align-items-center {{ $gradient ? 'pu-card-gradient-header' : '' }} {{ $collapsible ? 'py-3' : '' }}"
        @if($collapsible)
        role="button"
        data-bs-toggle="collapse"
        data-bs-target="#{{ $collapseId }}"
        aria-expanded="{{ $collapsed ? 'false' : 'true' }}"
        style="cursor:pointer;"
        @endif>
        <h6 class="m-0 fw-bold">
            @if($icon)
            <i class="{{ $icon }} me-2 {{ $gradient ? '' : $iconClass }}"></i>
            @endif
            {{ $title }}
        </h6>

        <div class="d-flex align-items-center gap-2">
            @if(isset($headerActions))
            {{ $headerActions }}
            @endif
            @if($collapsible)
            <i class="fas fa-chevron-down {{ $gradient ? 'text-white' : 'text-muted' }}" style="font-size:0.75rem;transition:transform 0.2s;"></i>
            @endif
        </div>
    </div>
    @endif

    @if($collapsible)
    <div class="collapse {{ $collapsed ? '' : 'show' }}" id="{{ $collapseId }}" @if($parent) data-bs-parent="#{{ $parent }}" @endif>
        <div class="card-body">
            {{ $slot }}
        </div>
    </div>
    @else
    <div class="card-body">
        {{ $slot }}
    </div>
    @endif

</div>