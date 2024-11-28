<button class="btn btn-warning editOrganizationTypeBtn"
    data-id="{{ $organization_types->id }}"
    data-name="{{ $organization_types->organization_name }}"
    data-bs-toggle="modal"
    data-bs-target="#editOrganizationTypeModal">Edit</button>

<a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete('{{ $organization_types->id }}')">Delete</a>