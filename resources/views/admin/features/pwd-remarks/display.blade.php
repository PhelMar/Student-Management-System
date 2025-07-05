@extends('layouts.admin')
@section('title', 'Pwd Remarks View')

@section('content')
<h1 class="mt-4">Pwd Remarks View</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Pwd Remarks View</li>
</ol>
@if (session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
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
        Pwd Remarks View
    </div>
    <div class="card-body">
        <table id="dataTables" class="table table-bordered table-hover w-100">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pwd Remarks</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Pwd Remarks</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
        </table>
        <button id="addFeatures" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addPwdRemarksModal">Add</button>
    </div>
</div>

<div class="modal fade" id="addPwdRemarksModal" tabindex="-1" aria-labelledby="addPwdRemarksModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPwdRemarksModalLabel">Add Pwd Remarks</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="pwdRemarksForm" action="{{route('admin.pwd-remarks.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Pwd Remarks</label>
                        <input type="text" name="pwd_name" id="pwd_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Pwd remarks Modal -->
<div class="modal fade" id="editPwdRemarksModal" tabindex="-1" aria-labelledby="editPwdRemarksModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPwdRemarksModalLabel">Edit Pwd remarks</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPwdRemarksForm" action="{{ route('admin.pwd-remarks.update', 0) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="pwd_remarks_id" id="edit_pwd_remarks_id">
                    <div class="mb-3">
                        <label for="edit_pwd_name" class="form-label">Pwd Remarks</label>
                        <input type="text" name="pwd_name" id="edit_pwd_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const table = $('#dataTables').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.pwd-remarks.display") }}',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'pwd_name',
                    name: 'pwd_name'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        $(document).on('click', '.editPwdRemarksBtn', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');

            $('#edit_pwd_remarks_id').val(id);
            $('#edit_pwd_name').val(name);

            $('#editPwdRemarksForm').attr('action', `{{ url('admin/pwd-remarks/update') }}/${id}`);
        });
    });

    $(document).ready(function() {
        setTimeout(function() {
            $('#success-alert').fadeOut('slow');
        }, 3000);

        $('.editPwdRemarksBtn').click(function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            $('#edit_pwd_remarks_id').val(id);
            $('#edit_pwd_name').val(name);
            $('#editPwdRemarksForm').attr('action', `{{ url('admin/pwd-remarks/update') }}/${id}`);
        });
    });

    function confirmDelete(pwdRemarksId) {
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
                fetch("{{ url('admin/pwd-remarks/delete') }}/" + pwdRemarksId, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', 'Pwd Remarks data has been deleted.', 'success');
                            location.reload();
                        } else {
                            Swal.fire('Error', 'There was an issue deleting the Pwd Remarks.', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'There was an issue deleting the Pwd Remarks.', 'error');
                        console.error('Error:', error);
                    });
            }
        });
    }
</script>

@endsection