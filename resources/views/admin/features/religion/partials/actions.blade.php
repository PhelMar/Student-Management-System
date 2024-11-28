<button class="btn btn-warning editReligionBtn"
    data-id="{{ $religion->id }}"
    data-name="{{ $religion->religion_name }}"
    data-bs-toggle="modal"
    data-bs-target="#editReligionModal">Edit</button>

<a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete('{{ $religion->id }}')">Delete</a>