@extends('layouts.admin')
@section('title', 'Base Income View')

@section('content')
<h1 class="mt-4">Base Income View</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Base Income View</li>
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
        Base Income View
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>INCOME TYPE</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>INCOME TYPE</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($incomes as $income)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$income->income_base}}</td>
                    <td>
                        <button class="btn btn-warning editIncomeBtn"
                            data-id="{{ $income->id }}"
                            data-name="{{ $income->income_base }}"
                            data-bs-toggle="modal"
                            data-bs-target="#editIncomeModal">Edit</button>

                        <a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete('{{$income->id}}')">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button id="addFeatures" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addIncomeModal">Add</button>
    </div>
</div>

<div class="modal fade" id="addIncomeModal" tabindex="-1" aria-labelledby="addIncomeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addIncomeModalLabel">Add Income Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="incomeForm" action="{{route('admin.income.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">income Type</label>
                        <input type="text" name="income_base" id="income_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit income Modal -->
<div class="modal fade" id="editIncomeModal" tabindex="-1" aria-labelledby="editIncomeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editIncomeModalLabel">Edit Income Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editIncomeForm" action="{{ route('admin.income.update', 0) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="income_id" id="edit_income_id">
                    <div class="mb-3">
                        <label for="edit_income_name" class="form-label">Income Type</label>
                        <input type="text" name="income_base" id="edit_income_name" class="form-control" required>
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

        $('.editIncomeBtn').click(function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            $('#edit_income_id').val(id);
            $('#edit_income_name').val(name);
            $('#editIncomeForm').attr('action', `{{ url('admin/income/update') }}/${id}`);
        });
    });

    function confirmDelete(incomeId) {
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
                fetch("{{ url('admin/income/delete') }}/" + incomeId, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', 'Income data has been deleted.', 'success');
                            location.reload();
                        } else {
                            Swal.fire('Error', 'There was an issue deleting the income type.', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'There was an issue deleting the income type.', 'error');
                        console.error('Error:', error);
                    });
            }
        });
    }
</script>

@endsection