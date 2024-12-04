@extends('layouts.admin')
@section('title', 'Gender View')

@section('content')
<h1 class="mt-4">Gender View</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Gender View</li>
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
        Gender View
    </div>
    <div class="card-body">
        <table id="dataTables" class="table table-bordered table-hover w-100">
            <thead>
                <tr>
                    <th>#</th>
                    <th>GENDER TYPE</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>GENDER TYPE</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
        </table>
        <button id="addFeatures" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addGenderModal">Add</button>
    </div>
</div>

<div class="modal fade" id="addGenderModal" tabindex="-1" aria-labelledby="addGenderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addGenderModalLabel">Add Gender Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="genderForm" action="{{route('admin.gender.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Gender Type</label>
                        <input type="text" name="gender_name" id="gender_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Gender Modal -->
<div class="modal fade" id="editGenderModal" tabindex="-1" aria-labelledby="editGenderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGenderModalLabel">Edit Gender Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editGenderForm" action="{{ route('admin.gender.update', 0) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="gender_id" id="edit_gender_id">
                    <div class="mb-3">
                        <label for="edit_gender_name" class="form-label">Gender Type</label>
                        <input type="text" name="gender_name" id="edit_gender_name" class="form-control" required>
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
            ajax: '{{ route("admin.gender.display") }}',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'gender_name',
                    name: 'gender_name'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        $(document).on('click', '.editGenderBtn', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');

            $('#edit_gender_id').val(id);
            $('#edit_gender_name').val(name);

            $('#editGenderForm').attr('action', `{{ url('admin/gender/update') }}/${id}`);
        });
    });

    $(document).ready(function() {
        setTimeout(function() {
            $('#success-alert').fadeOut('slow');
        }, 3000);

        $('.editGenderBtn').click(function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            $('#edit_gender_id').val(id);
            $('#edit_gender_name').val(name);
            $('#editGenderForm').attr('action', `{{ url('admin/gender/update') }}/${id}`);
        });
    });

    function confirmDelete(genderId) {
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
                fetch("{{ url('admin/gender/delete') }}/" + genderId, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', 'Gender data has been deleted.', 'success');
                            location.reload();
                        } else {
                            Swal.fire('Error', 'There was an issue deleting the gender type.', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'There was an issue deleting the gender type.', 'error');
                        console.error('Error:', error);
                    });
            }
        });
    }
</script>

@endsection