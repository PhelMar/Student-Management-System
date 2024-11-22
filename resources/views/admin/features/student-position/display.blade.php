@extends('layouts.admin')
@section('title', 'Student Position View')

@section('content')
<h1 class="mt-4">Student Position View</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Student Position View</li>
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
        Student Position View
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>POSITION</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>POSITION</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($positions as $position)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$position->positions_name}}</td>
                    <td>
                        <button class="btn btn-warning editPositionBtn"
                            data-id="{{ $position->id }}"
                            data-name="{{ $position->positions_name }}"
                            data-bs-toggle="modal"
                            data-bs-target="#editPositionModal">Edit</button>

                        <a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete('{{$position->id}}')">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button id="addFeatures" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addPositionModal">Add</button>
    </div>
</div>

<div class="modal fade" id="addPositionModal" tabindex="-1" aria-labelledby="addPositionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPositionModalLabel">Add Position Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="positionForm" action="{{route('admin.position.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Position Type</label>
                        <input type="text" name="positions_name" id="position_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Position Modal -->
<div class="modal fade" id="editPositionModal" tabindex="-1" aria-labelledby="editPositionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPositionModalLabel">Edit Position Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPositionForm" action="{{ route('admin.position.update', 0) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="position_id" id="edit_position_id">
                    <div class="mb-3">
                        <label for="edit_position_name" class="form-label">Position Type</label>
                        <input type="text" name="positions_name" id="edit_position_name" class="form-control" required>
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

        $('.editPositionBtn').click(function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            $('#edit_position_id').val(id);
            $('#edit_position_name').val(name);
            $('#editPositionForm').attr('action', `{{ url('admin/position/update') }}/${id}`);
        });
    });

    function confirmDelete(positionId) {
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
                fetch("{{ url('admin/position/delete') }}/" + positionId, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', 'Position data has been deleted.', 'success');
                            location.reload();
                        } else {
                            Swal.fire('Error', 'There was an issue deleting the position type.', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'There was an issue deleting the position type.', 'error');
                        console.error('Error:', error);
                    });
            }
        });
    }
</script>

@endsection