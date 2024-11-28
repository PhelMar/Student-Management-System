<button class="btn btn-warning editParentStatusBtn"
    data-id="{{ $parent_status->id }}"
    data-name="{{ $parent_status->status }}"
    data-bs-toggle="modal"
    data-bs-target="#editParentStatusModal">Edit</button>

<a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete('{{ $parent_status->id }}')">Delete</a>