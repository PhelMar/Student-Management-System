@extends('layouts.admin')
@section('title', 'School Year View')

@section('content')
<h1 class="mt-4">School Year View</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">School Year View</li>
</ol>
@if (session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function(){
            Swal.fire({
                title: 'Success!',
                text: "{{session('success')}}",
                icon: 'success',
                confirmButtonText: 'OK',
                timer: 1200
            });
        });
    </script>
@endif
<div class="card card-mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        School Year View
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>SCHOOL YEAR</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>SCHOOL YEAR</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($school_years as $school_year)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$school_year->school_year_name}}</td>
                    <td>
                        <button class="btn btn-warning editSchoolYearBtn"
                            data-id="{{ $school_year->id }}"
                            data-name="{{ $school_year->school_year_name }}"
                            data-bs-toggle="modal"
                            data-bs-target="#editSchoolYearModal">Edit</button>

                        <a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete('{{$school_year->id}}')">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button id="addFeatures" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addSchoolYearModal">Add</button>
    </div>
</div>

<div class="modal fade" id="addSchoolYearModal" tabindex="-1" aria-labelledby="addSchoolYearModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSchoolYearModalLabel">Add School Year</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="school_yearForm" action="{{route('admin.school_year.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">School Year</label>
                        <input type="text" name="school_year_name" id="school_year_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit SchoolYear Modal -->
<div class="modal fade" id="editSchoolYearModal" tabindex="-1" aria-labelledby="editSchoolYearModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSchoolYearModalLabel">Edit School Year</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editSchoolYearForm" action="{{ route('admin.school_year.update', 0) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="school_year_id" id="edit_school_year_id">
                    <div class="mb-3">
                        <label for="edit_school_year_name" class="form-label">School Year</label>
                        <input type="text" name="school_year_name" id="edit_school_year_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#success-alert').fadeOut('slow');
        }, 3000);

        $('.editSchoolYearBtn').click(function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            $('#edit_school_year_id').val(id);
            $('#edit_school_year_name').val(name);
            $('#editSchoolYearForm').attr('action', `{{ url('admin/school_year/update') }}/${id}`);
        });
    });

    function confirmDelete(school_yearId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete student!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("{{ url('admin/school_year/delete') }}/" + school_yearId, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', 'School Year data has been deleted.', 'success');
                            location.reload();
                        } else {
                            Swal.fire('Error', 'There was an issue deleting the school_year type.', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'There was an issue deleting the school_year type.', 'error');
                        console.error('Error:', error);
                    });
            }
        });
    }
</script>

@endsection