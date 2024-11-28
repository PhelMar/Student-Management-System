<button class="btn btn-warning editDialectBtn"
    data-id="{{ $dialect->id }}"
    data-name="{{ $dialect->dialect_name }}"
    data-bs-toggle="modal"
    data-bs-target="#editDialectModal">Edit</button>

<a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete('{{ $dialect->id }}')">Delete</a>