<button class="btn btn-warning editSchoolYearBtn"
    data-id="{{ $school_year->id }}"
    data-name="{{ $school_year->school_year_name }}"
    data-bs-toggle="modal"
    data-bs-target="#editSchoolYearModal">Edit</button>

<a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete('{{ $school_year->id }}')">Delete</a>