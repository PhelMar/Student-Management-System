@extends('layouts.admin')
@section('title', 'Parent Status View')

@section('content')
<h1 class="mt-4">Parent Status View</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Parent Status View</li>
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
<div class="card card-mb-4 shadow">
    <div class="card-header text-white" style="background-color: #0A7075">
        <i class="fas fa-table me-1"></i>
        Parent Status View
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>PARENT STATUS TYPE</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>PARENT STATUS TYPE</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($parent_statuses as $parent_status)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$parent_status->status}}</td>
                    <td>
                        <button class="btn btn-warning editParentStatusBtn"
                            data-id="{{ $parent_status->id }}"
                            data-name="{{ $parent_status->status }}"
                            data-bs-toggle="modal"
                            data-bs-target="#editParentStatusModal">Edit</button>

                        <a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete('{{$parent_status->id}}')">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button id="addFeatures" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addParentStatusModal">Add</button>
    </div>
</div>

<div class="modal fade" id="addParentStatusModal" tabindex="-1" aria-labelledby="addParentStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addParentStatusModalLabel">Add Parent Status Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="parent_statusForm" action="{{route('admin.parent_status.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Parent Status Type</label>
                        <input type="text" name="status" id="parent_status_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit ParentStatus Modal -->
<div class="modal fade" id="editParentStatusModal" tabindex="-1" aria-labelledby="editParentStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editParentStatusModalLabel">Edit Parent Status Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editParentStatusForm" action="{{ route('admin.parent_status.update', 0) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="parent_status_id" id="edit_parent_status_id">
                    <div class="mb-3">
                        <label for="edit_parent_status_name" class="form-label">Parent Status Type</label>
                        <input type="text" name="status" id="edit_parent_status_name" class="form-control" required>
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

        $('.editParentStatusBtn').click(function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            $('#edit_parent_status_id').val(id);
            $('#edit_parent_status_name').val(name);
            $('#editParentStatusForm').attr('action', `{{ url('admin/parent_status/update') }}/${id}`);
        });
    });

    function confirmDelete(parent_statusId) {
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
                fetch("{{ url('admin/parent_status/delete') }}/" + parent_statusId, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', 'ParentStatus data has been deleted.', 'success');
                            location.reload();
                        } else {
                            Swal.fire('Error', 'There was an issue deleting the parent_status type.', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'There was an issue deleting the parent_status type.', 'error');
                        console.error('Error:', error);
                    });
            }
        });
    }
</script>

@endsection