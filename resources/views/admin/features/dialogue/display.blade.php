@extends('layouts.admin')
@section('title', 'Dialect View')

@section('content')
<h1 class="mt-4">Dialect View</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dialect View</li>
</ol>
@if (session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
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
        Dialect
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>DIALECT TYPE</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>DIALECT TYPE</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($dialects as $dialect)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$dialect->dialect_name}}</td>
                    <td>
                        <button class="btn btn-warning editDialectBtn"
                            data-id="{{ $dialect->id }}"
                            data-name="{{ $dialect->dialect_name }}"
                            data-bs-toggle="modal"
                            data-bs-target="#editDialectModal">Edit</button>

                        <a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete('{{$dialect->id}}')">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button id="addFeatures" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addDialectModal">Add</button>
    </div>
</div>

<div class="modal fade" id="addDialectModal" tabindex="-1" aria-labelledby="addDialectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDialectModalLabel">Add Dialect Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="dialectForm" action="{{route('admin.dialect.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Dialect Type</label>
                        <input type="text" name="dialect_name" id="dialect_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Dialect Modal -->
<div class="modal fade" id="editDialectModal" tabindex="-1" aria-labelledby="editDialectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDialectModalLabel">Edit Dialect Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editDialectForm" action="{{ route('admin.dialect.update', 0) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="dialect_id" id="edit_dialect_id">
                    <div class="mb-3">
                        <label for="edit_dialect_name" class="form-label">Dialect Type</label>
                        <input type="text" name="dialect_name" id="edit_dialect_name" class="form-control" required>
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

        $('.editDialectBtn').click(function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            $('#edit_dialect_id').val(id);
            $('#edit_dialect_name').val(name);
            $('#editDialectForm').attr('action', `{{ url('admin/dialect/update') }}/${id}`);
        });
    });

    function confirmDelete(dialectId) {
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
                fetch("{{ url('admin/dialect/delete') }}/" + dialectId, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', 'Dialect data has been deleted.', 'success');
                            location.reload();
                        } else {
                            Swal.fire('Error', 'There was an issue deleting the dialect type.', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'There was an issue deleting the dialect type.', 'error');
                        console.error('Error:', error);
                    });
            }
        });
    }
</script>

@endsection