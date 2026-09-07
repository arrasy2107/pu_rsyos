@php
$type = $type ?? 'text';
$autocomplete = $autocomplete ?? 'off';
$placeholder = $placeholder ?? '';
$icon = $icon ?? 'fas fa-pencil-alt';
@endphp

<div class="form-group pu-login-form-group">
    <label for="{{ $id }}">{{ $label }}</label>
    <div class="pu-login-input-wrapper">
        <div class="pu-login-input-icon">
            <i class="{{ $icon }}"></i>
        </div>
        <input
            type="{{ $type }}"
            class="form-control pu-login-input"
            id="{{ $id }}"
            name="{{ $name }}"
            autocomplete="{{ $autocomplete }}"
            placeholder="{{ $placeholder }}"
            required>
        @if(!empty($append))
        <button type="button" class="btn-input-icon" id="{{ $append }}" aria-label="Toggle password visibility">
            <i class="fas fa-eye" id="pwd-eye"></i>
        </button>
        @endif
    </div>
</div>