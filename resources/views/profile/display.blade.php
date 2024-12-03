@extends('layouts.admin')
@section('title', 'Profile View')

@section('content')
<h1 class="mt-4">Profile View</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Profile View</li>
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
<div class="d-flex justify-content-end mb-3">
    <a class="btn btn-primary shadow" href="">
        <i class="fa fa-user-plus me-2"></i>Register New Users</a>
</div>
<div class="card card-mb-4 shadow">
    <div class="card-header text-white" style="background-color: #0A7075">
        <i class="fas fa-table me-1"></i>
        Users View
    </div>
    <div class="card-body">
        <table id="userTable" class="table table-striped table-hover table-bordered table-responsive">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            ajax: "{{ route('admin.profile.display') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'role',
                    name: 'role'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return data; // Render HTML content for action buttons
                    }
                }
            ],
            order: [
                [3, 'desc']
            ] // Default sorting by created_at descending
        });
    });

    function confirmDelete(profileId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete user!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("{{ url('admin/profile/delete') }}/" + profileId, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', 'Profile User has been deleted.', 'success');
                            $('#userTable').DataTable().ajax.reload();
                        } else {
                            Swal.fire('Error', 'There was an issue deleting the user.', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'There was an issue deleting the user.', 'error');
                        console.error('Error:', error);
                    });
            }
        });
    }
</script>
@endsection