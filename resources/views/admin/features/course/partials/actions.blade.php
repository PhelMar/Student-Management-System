<button class="btn btn-warning editCourseBtn"
    data-id="{{ $course->id }}"
    data-name="{{ $course->course_name }}"
    data-bs-toggle="modal"
    data-bs-target="#editCourseModal">Edit</button>

<a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete('{{ $course->id }}')">Delete</a>