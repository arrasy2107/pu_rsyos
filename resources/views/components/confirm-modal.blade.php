@props([
    'id'          => 'confirmDeleteModal',
    'title'       => 'Konfirmasi Hapus',
    'message'     => 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.',
    'actionUrl'   => '#',
    'actionMethod'=> 'POST',  // GET | POST | DELETE
    'actionLabel' => 'Hapus',
    'actionClass' => 'btn-danger',
    'cancelLabel' => 'Batal',
])
{{--
  x-confirm-modal — Generic delete/action confirmation modal

  Usage (static):
    <x-confirm-modal
        id="deleteUserModal"
        title="Hapus Pengguna"
        message="Data pengguna akan dihapus permanen."
        action-url="{{ route('deletepengguna', $user->id) }}"
        action-label="Ya, Hapus" />

  Usage (dynamic via JS):
    Set data-id on trigger button, then JS sets the form action dynamically.
--}}
<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id }}Label">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    {{ $title }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-0">{{ $message }}</p>
                @if(!empty(trim($slot)))
                    {{ $slot }}
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> {{ $cancelLabel }}
                </button>
                @if($actionMethod === 'GET')
                <a href="{{ $actionUrl }}" class="btn {{ $actionClass }}" id="{{ $id }}-confirm-btn">
                    <i class="fas fa-trash me-1"></i> {{ $actionLabel }}
                </a>
                @else
                <form id="{{ $id }}-form" action="{{ $actionUrl }}" method="POST" style="display:inline;">
                    @csrf
                    @if($actionMethod !== 'POST')
                        @method($actionMethod)
                    @endif
                    <button type="submit" class="btn {{ $actionClass }}" id="{{ $id }}-confirm-btn">
                        <i class="fas fa-trash me-1"></i> {{ $actionLabel }}
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
