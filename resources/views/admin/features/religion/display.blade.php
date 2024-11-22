@extends('layouts.admin')
@section('title', 'Religion View')

@section('content')
<h1 class="mt-4">Religion View</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Religion View</li>
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
        Religion View
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>RELIGION NAME</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>RELIGION NAME</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($religions as $religion)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$religion->religion_name}}</td>
                    <td>
                        <button class="btn btn-warning editReligionBtn"
                            data-id="{{ $religion->id }}"
                            data-name="{{ $religion->religion_name }}"
                            data-bs-toggle="modal"
                            data-bs-target="#editReligionModal">Edit</button>

                        <a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete('{{$religion->id}}')">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button id="addFeatures" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addReligionModal">Add</button>
    </div>
</div>

<div class="modal fade" id="addReligionModal" tabindex="-1" aria-labelledby="addReligionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addReligionModalLabel">Add Religion Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="religionForm" action="{{route('admin.religion.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Religion Type</label>
                        <input type="text" name="religion_name" id="religion_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Religion Modal -->
<div class="modal fade" id="editReligionModal" tabindex="-1" aria-labelledby="editReligionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editReligionModalLabel">Edit Religion Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editReligionForm" action="{{ route('admin.religion.update', 0) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="religion_id" id="edit_religion_id">
                    <div class="mb-3">
                        <label for="edit_religion_name" class="form-label">Religion Type</label>
                        <input type="text" name="religion_name" id="edit_religion_name" class="form-control" required>
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

        $('.editReligionBtn').click(function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            $('#edit_religion_id').val(id);
            $('#edit_religion_name').val(name);
            $('#editReligionForm').attr('action', `{{ url('admin/religion/update') }}/${id}`);
        });
    });

    function confirmDelete(religionId) {
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
                fetch("{{ url('admin/religion/delete') }}/" + religionId, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', 'Religion data has been deleted.', 'success');
                            location.reload();
                        } else {
                            Swal.fire('Error', 'There was an issue deleting the religion type.', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'There was an issue deleting the religion type.', 'error');
                        console.error('Error:', error);
                    });
            }
        });
    }
</script>

@endsection