<div class="row">
    <div class="col-xl-6 col-md-6">
        <div class="mb-4">
            <label for="income_id" class="form-label" style="font-weight: bold;">Monthly Family Income (Combined)</label>
            <select class="form-control @error('income_id') is-invalid @enderror" required
                name="income_id" value="{{ old('income_id') }}">
                <option value="" disabled selected>Choose Income Base</option>
                @foreach ($incomes as $income)
                <option value="{{$income->id}}"
                    {{$students->income_id == $income->id ? 'selected' : ''}}>
                    {{$income->income_base}}
                </option>
                @endforeach
            </select>
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <div class="col-xl-6 col-md-6">
        <div class="mb-4">
            <label for="parents_status_id" class="form-label" style="font-weight: bold;">Parents Status</label>
            <select class="form-control @error('parents_status_id') is-invalid @enderror"
                name="parents_status_id" value="{{ old('parents_status_id') }}" required>
                <option value="" disabled selected>Choose Parent Status</option>
                @foreach ($parents_status as $parent_statu)
                <option value="{{$parent_statu->id}}"
                    {{$students->parents_status_id == $parent_statu->id ? 'selected' : ''}}>
                    {{$parent_statu->status}}
                </option>
                @endforeach
            </select>
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <hr style="border: 2px solid;stroke: black;" />
    <h5>Incase of Emergency</h5>
    <hr style="border: 1px solid;stroke: black;" />
    <div class="col-xl-6 col-md-6">
        <div class="mb-4">
            <label for="incase_of_emergency_name" class="form-label" style="font-weight: bold;">Name</label>
            <input type="text" class="form-control @error('incase_of_emergency_name') is-invalid @enderror" required
                name="incase_of_emergency_name" value="{{ old('incase_of_emergency_name', $students->incase_of_emergency_name) }}">
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <div class="col-xl-6 col-md-6">
        <div class="mb-4">
            <label for="incase_of_emergency_contact" class="form-label" style="font-weight: bold;">Contact No.</label>
            <input type="text" class="form-control @error('incase_of_emergency_contact') is-invalid @enderror" required
                name="incase_of_emergency_contact" value="{{ old('incase_of_emergency_contact', $students->incase_of_emergency_contact) }}" id="incase_of_emergency_contact">
            <small id="incase_of_emergency_contact_Error" style="color:red"></small>
            <small class="error-message text-danger"></small>
        </div>
    </div>
</div>