<div class="row">
    <h3>Family Background</h3>
    <hr style="border: 1px solid;stroke: black;" />
    <h5 style="text-decoration: underline;">Father</h5>
    <hr style="border: 1px solid;stroke: black;" />
    <div class="col-xl-6 col-md-6">
        <div class="mb-4">
            <label for="fathers_name" class="form-label" style="font-weight: bold;">Full Name</label>
            <input type="text" class="form-control @error('fathers_name') is-invalid @enderror"
                name="fathers_name" value="{{ old('fathers_name') }}">
        </div>
        <div class="mb-4">
            <label for="" class="form-label" style="font-weight: bold;">Province</label>
            <select id="fathers_province" name="fathers_province_id" class="form-control @error('fathers_province_id') is-invalid @enderror">
                <option value="">Select Province</option>
                @foreach($provinces as $province)
                <option value="{{ $province->prov_code }}">{{ $province->prov_desc }}</option>
                @endforeach
            </select>
            <small class="error-message text-danger"></small>
        </div>
        <div class="mb-4">
            <label for="fathers_address" class="form-label" style="font-weight: bold;">Municipality</label>
            <select id="fathers_municipality" name="fathers_municipality_id" class="form-control @error('fathers_municipality_id') is-invalid @enderror">
                <option value="">Select Municipality</option>
            </select>
            <small class="error-message text-danger"></small>
        </div>
        <div class="mb-4">
            <label for="fathers_address" class="form-label" style="font-weight: bold;">Barangay</label>
            <select id="fathers_barangay" name="fathers_barangay_id" class="form-control @error('fathers_barangay_id') is-invalid @enderror">
                <option value="">Select Barangay</option>
            </select>
            <small class="error-message text-danger"></small>
        </div>
        <div class="mb-4">
            <label for="" class="form-label" style="font-weight: bold;">Purok/Village</label>
            <input type="text" class="form-control @error('fathers_purok') is-invalid @enderror"
                name="fathers_purok" value="{{ old('fathers_purok') }}">
        </div>
    </div>
    <div class="col-xl-6 col-md-6">
        <div class="mb-4">
            <label for="fathers_birthdate" class="form-label" style="font-weight: bold;">Birthdate</label>
            <input type="date" class="form-control @error('fathers_birthdate') is-invalid @enderror"
                name="fathers_birthdate" value="{{ old('fathers_birthdate') }}">
        </div>
        <div class="mb-4">
            <label for="fathers_place_of_birth" class="form-label" style="font-weight: bold;">Place of Birth</label>
            <textarea type="text" class="form-control @error('fathers_place_of_birth') is-invalid @enderror"
                name="fathers_place_of_birth" value="{{ old('fathers_place_of_birth') }}" rows="2"></textarea>
        </div>
        <div class="mb-4">
            <label for="fathers_contact_no" class="form-label" style="font-weight: bold;">Contact No.</label>
            <input type="text" class="form-control @error('fathers_contact_no') is-invalid @enderror"
                name="fathers_contact_no" value="{{ old('fathers_contact_no') }}" id="fathers_contact_no">
            <small id="fathers_contactNoError" style="color:red"></small>
        </div>
        <div class="mb-4">
            <label for="fathers_religion_id" class="form-label" style="font-weight: bold;">Religion</label>
            <select class="form-control @error('fathers_religion_id') is-invalid @enderror"
                name="fathers_religion_id" value="{{ old('fathers_religion_id') }}">
                <option value="" disabled selected></option>
                @foreach ($religions as $religion)
                <option value="{{$religion->id}}">{{$religion->religion_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <hr style="border: 1px solid;stroke: black;" />
    <div class="col-xl-4 col-md-4">
        <div class="mb-4">
            <label for="fathers_highest_education_id" class="form-label" style="font-weight: bold;">Highest Education Attainment</label>
            <select class="form-control @error('fathers_highest_education_id') is-invalid @enderror"
                name="fathers_highest_education_id" value="{{ old('fathers_highest_education_id') }}">
                <option value="" disabled selected></option>
                @foreach ($highest_educations as $highest_education)
                <option value="{{$highest_education->id}}">{{$highest_education->highest_education_level}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xl-4 col-md-4">
        <div class="mb-4">
            <label for="fathers_occupation" class="form-label" style="font-weight: bold;">Occupation</label>
            <input type="text" class="form-control @error('fathers_occupation') is-invalid @enderror"
                name="fathers_occupation" value="{{ old('fathers_occupation') }}">
        </div>
    </div>
    <div class="col-xl-4 col-md-4">
        <div class="mb-4">
            <label for="number_of_fathers_sibling" class="form-label" style="font-weight: bold;">Numbers of Siblings</label>
            <input type="text" class="form-control @error('number_of_fathers_sibling') is-invalid @enderror"
                name="number_of_fathers_sibling" value="{{ old('number_of_fathers_sibling') }}" id="number_of_fathers_sibling">
            <small id="number_of_fathers_sibling_Error" style="color:red;"></small>
        </div>
    </div>
</div>