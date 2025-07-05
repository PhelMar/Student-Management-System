<button class="btn btn-warning editPwdRemarksBtn"
    data-id="{{ $pwdRemarks->id }}"
    data-name="{{ $pwdRemarks->pwd_name }}"
    data-bs-toggle="modal"
    data-bs-target="#editPwdRemarksModal">Edit</button>

<a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete('{{ $pwdRemarks->id }}')">Delete</a>