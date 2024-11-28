<button class="btn btn-warning editIncomeBtn"
    data-id="{{ $income->id }}"
    data-name="{{ $income->income_base }}"
    data-bs-toggle="modal"
    data-bs-target="#editIncomeModal">Edit</button>

<a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete('{{ $income->id }}')">Delete</a>