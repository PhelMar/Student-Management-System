<button class="btn btn-warning editPositionBtn"
    data-id="{{ $position->id }}"
    data-name="{{ $position->positions_name }}"
    data-bs-toggle="modal"
    data-bs-target="#editPositionModal">Edit</button>

<a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete('{{ $position->id }}')">Delete</a>