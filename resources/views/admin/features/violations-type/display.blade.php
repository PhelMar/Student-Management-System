@extends('layouts.admin')
@section('title', 'Violations Type')

@section('content')
<h1 class="mt-4">Violations Type</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Violations Type</li>
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
        Violations Type
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>VIOLATIONS TYPE</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>VIOLATIONS TYPE</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($violation_types as $violation_type)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$violation_type->violation_type_name}}</td>
                    <td>
                        <button class="btn btn-warning editViolationsTypeBtn"
                            data-id="{{ $violation_type->id }}"
                            data-name="{{ $violation_type->violation_type_name }}"
                            data-bs-toggle="modal"
                            data-bs-target="#editViolationsTypeModal">Edit</button>

                        <a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete('{{$violation_type->id}}')">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button id="addFeatures" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addViolationsTypeModal">Add</button>
    </div>
</div>

<div class="modal fade" id="addViolationsTypeModal" tabindex="-1" aria-labelledby="addViolationsTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addViolationsTypeModalLabel">Add Violations Type Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="violation_typeForm" action="{{route('admin.violation_type.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Violations Type Name</label>
                        <input type="text" name="violation_type_name" id="violation_type_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit ViolationsType Modal -->
<div class="modal fade" id="editViolationsTypeModal" tabindex="-1" aria-labelledby="editViolationsTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editViolationsTypeModalLabel">Edit Violations Type Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editViolationsTypeForm" action="{{ route('admin.violation_type.update', 0) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="violation_type_id" id="edit_violation_type_id">
                    <div class="mb-3">
                        <label for="edit_violation_type_name" class="form-label">Violations Type Name</label>
                        <input type="text" name="violation_type_name" id="edit_violation_type_name" class="form-control" required>
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

        $('.editViolationsTypeBtn').click(function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            $('#edit_violation_type_id').val(id);
            $('#edit_violation_type_name').val(name);
            $('#editViolationsTypeForm').attr('action', `{{ url('admin/violation_type/update') }}/${id}`);
        });
    });

    function confirmDelete(violation_typeId) {
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
                fetch("{{ url('admin/violation_type/delete') }}/" + violation_typeId, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', 'Violations Type data has been deleted.', 'success');
                            location.reload();
                        } else {
                            Swal.fire('Error', 'There was an issue deleting the violation type.', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'There was an issue deleting the violation type.', 'error');
                        console.error('Error:', error);
                    });
            }
        });
    }
</script>

@endsection