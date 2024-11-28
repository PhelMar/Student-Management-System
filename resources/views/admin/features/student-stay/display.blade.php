@extends('layouts.admin')
@section('title', 'Student Live View')

@section('content')
<h1 class="mt-4">Student Live View</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Student Live View</li>
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
    <div class="card-header text-white">
        <i class="fas fa-table me-1"></i>
        Student Live View
    </div>
    <div class="card-body">
        <table id="dataTables" class="table table-bordered table-hover w-100">
            <thead>
                <tr>
                    <th>#</th>
                    <th>STAY TYPE</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>STAY TYPE</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
        </table>
        <button id="addFeatures" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addStayModal">Add</button>
    </div>
</div>

<div class="modal fade" id="addStayModal" tabindex="-1" aria-labelledby="addStayModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStayModalLabel">Add Stay Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="stayForm" action="{{route('admin.stay.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Stay Name</label>
                        <input type="text" name="stay_name" id="stay_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Stay Modal -->
<div class="modal fade" id="editStayModal" tabindex="-1" aria-labelledby="editStayModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStayModalLabel">Edit Stay Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editStayForm" action="{{ route('admin.stay.update', 0) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="stay_id" id="edit_stay_id">
                    <div class="mb-3">
                        <label for="edit_stay_name" class="form-label">Stay Name</label>
                        <input type="text" name="stay_name" id="edit_stay_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#dataTables').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.stay.display") }}',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'stay_name',
                    name: 'stay_name'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        $(document).on('click', '.editStayBtn', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');

            $('#edit_stay_id').val(id);
            $('#edit_stay_name').val(name);

            $('#editStayForm').attr('action', `{{ url('admin/stay/update') }}/${id}`);
        });
    });

    $(document).ready(function() {
        setTimeout(function() {
            $('#success-alert').fadeOut('slow');
        }, 3000);

        $('.editStayBtn').click(function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            $('#edit_stay_id').val(id);
            $('#edit_stay_name').val(name);
            $('#editStayForm').attr('action', `{{ url('admin/stay/update') }}/${id}`);
        });
    });

    function confirmDelete(stayId) {
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
                fetch("{{ url('admin/stay/delete') }}/" + stayId, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', 'Stay data has been deleted.', 'success');
                            location.reload();
                        } else {
                            Swal.fire('Error', 'There was an issue deleting the stay type.', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'There was an issue deleting the stay type.', 'error');
                        console.error('Error:', error);
                    });
            }
        });
    }
</script>

@endsection