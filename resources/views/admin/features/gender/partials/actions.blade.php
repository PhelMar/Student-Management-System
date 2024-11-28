<button class="btn btn-warning editGenderBtn"
    data-id="{{ $gender->id }}"
    data-name="{{ $gender->gender_name }}"
    data-bs-toggle="modal"
    data-bs-target="#editGenderModal">Edit</button>

<a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete('{{ $gender->id }}')">Delete</a>