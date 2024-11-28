<button class="btn btn-warning editViolationsTypeBtn"
    data-id="{{ $violation_type->id }}"
    data-name="{{ $violation_type->violation_type_name }}"
    data-bs-toggle="modal"
    data-bs-target="#editViolationsTypeModal">Edit</button>

<a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete('{{ $violation_type->id }}')">Delete</a>