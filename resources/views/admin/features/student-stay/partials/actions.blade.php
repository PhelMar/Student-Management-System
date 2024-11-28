<button class="btn btn-warning editStayBtn"
    data-id="{{ $stay->id }}"
    data-name="{{ $stay->stay_name }}"
    data-bs-toggle="modal"
    data-bs-target="#editStayModal">Edit</button>

<a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete('{{ $stay->id }}')">Delete</a>