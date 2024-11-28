@extends('layouts.admin')
@section('title', 'Organization Type View')

@section('content')
<h1 class="mt-4">Organization Type View</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Organization Type View</li>
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
        Organization Type View
    </div>
    <div class="card-body">
        <table id="dataTables" class="table table-bordered table-hover w-100">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ORGANIZATION TYPE</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>ORGANIZATION TYPE</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
        </table>
        <button id="addFeatures" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addOrganizationTypeModal">Add</button>
    </div>
</div>

<div class="modal fade" id="addOrganizationTypeModal" tabindex="-1" aria-labelledby="addOrganizationTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addOrganizationTypeModalLabel">Add Organization Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="organization_typeForm" action="{{route('admin.organization_type.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Organization Type</label>
                        <input type="text" name="organization_name" id="organization_type_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit OrganizationType Modal -->
<div class="modal fade" id="editOrganizationTypeModal" tabindex="-1" aria-labelledby="editOrganizationTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOrganizationTypeModalLabel">Edit Organization Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editOrganizationTypeForm" action="{{ route('admin.organization_type.update', 0) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="organization_type_id" id="edit_organization_type_id">
                    <div class="mb-3">
                        <label for="edit_organization_type_name" class="form-label">Organization Type</label>
                        <input type="text" name="organization_name" id="edit_organization_type_name" class="form-control" required>
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
            ajax: '{{ route("admin.organization_type.display") }}',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'organization_types_name',
                    name: 'organization_types_name'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        $(document).on('click', '.editOrganizationTypeBtn', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');

            $('#edit_organization_type_id').val(id);
            $('#edit_organization_type_name').val(name);

            $('#editOrganizationTypeForm').attr('action', `{{ url('admin/organization_type/update') }}/${id}`);
        });
    });

    $(document).ready(function() {
        setTimeout(function() {
            $('#success-alert').fadeOut('slow');
        }, 3000);

        $('.editOrganizationTypeBtn').click(function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            $('#edit_organization_type_id').val(id);
            $('#edit_organization_type_name').val(name);
            $('#editOrganizationTypeForm').attr('action', `{{ url('admin/organization_type/update') }}/${id}`);
        });
    });

    function confirmDelete(organization_typeId) {
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
                fetch("{{ url('admin/organization_type/delete') }}/" + organization_typeId, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', 'OrganizationType data has been deleted.', 'success');
                            location.reload();
                        } else {
                            Swal.fire('Error', 'There was an issue deleting the organization_type type.', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'There was an issue deleting the organization_type type.', 'error');
                        console.error('Error:', error);
                    });
            }
        });
    }
</script>

@endsection