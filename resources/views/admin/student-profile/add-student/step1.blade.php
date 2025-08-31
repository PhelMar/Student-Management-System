<h3>Personal Information</h3>
<hr style="border: 3px solid;stroke: black;" />
<div class="row">
    <div class="col-xl-6 col-md-6">
        <div class="mb-4">
            <label for="first_name" class="form-label" style="font-weight: bold;">First Name</label>
            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                name="first_name" value="{{ old('first_name') }}" required>
            <small class="error-message text-danger"></small>
        </div>
        <div class="mb-4">
            <label for="last_name" class="form-label" style="font-weight: bold;">Last Name</label>
            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                name="last_name" value="{{ old('last_name') }}" required>
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <div class="col-xl-6 col-md-6">
        <div class="mb-4">
            <label for="middle_name" class="form-label" style="font-weight: bold;">Middle Name</label>
            <input type="text" class="form-control @error('middle_name') is-invalid @enderror"
                name="middle_name" value="{{ old('middle_name') }}">
        </div>
        <div class="mb-4">
            <label for="nick_name" class="form-label" style="font-weight: bold;">Nick Name</label>
            <input type="text" class="form-control @error('nick_name') is-invalid @enderror"
                name="nick_name" value="{{ old('nick_name') }}">
        </div>
    </div>
    <hr style="border: 2px solid;stroke: black;" />
    <div class="col-xl-3 col-md-3">
        <div class="mb-4">
            <label for="birthdate" class="form-label" style="font-weight: bold;">Birthdate</label>
            <input type="date" class="form-control @error('birthdate') is-invalid @enderror"
                name="birthdate" value="{{ old('birthdate') }}" required>
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="mb-4">
            <label for="gender_id" class="form-label" style="font-weight: bold;">Gender</label>
            <select class="form-control @error('gender_id') is-invalid @enderror"
                name="gender_id" value="{{ old('gender_id') }}" required>
                <option value="" disabled selected></option>
                @foreach ($genders as $gender)
                <option value="{{$gender->id}}" {{ (old('gender_id') == $gender->id) ? 'selected' : ''}}>
                    {{$gender->gender_name}}
                </option>
                @endforeach
            </select>
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="mb-4">
            <label for="birth_order_among_sibling" class="form-label" style="font-weight: bold;">Birth Order Among Siblings?</label>
            <input type="text" class="form-control @error('birth_order_among_sibling') is-invalid @enderror"
                name="birth_order_among_sibling" value="{{ old('birth_order_among_sibling') }}" id="birth_order_among_sibling" required>
            <small id="birth_order_Error" style="color:red"></small>
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="mb-4">
            <label for="place_of_birth" class="form-label" style="font-weight: bold;">Place of Birth</label>
            <textarea type="text" class="form-control @error('place_of_birth') is-invalid @enderror"
                name="place_of_birth" rows="3" required>{{ old('place_of_birth') }}</textarea>
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <hr style="border: 2px solid;stroke: black;" />
    <h5>Current Address</h5>
    <div class="col-xl-3 col-md-3">
        <div class="mb-4">
            <label for="" class="form-label" style="font-weight: bold;">Province</label>
            <select id="current_province" name="current_province_id" class="form-control @error('current_province_id') is-invalid @enderror" required>
                <option value="">Select Province</option>
                @foreach($provinces as $province)
                <option value="{{ $province->prov_code }}"
                    >
                    {{ $province->prov_desc }}
                </option>
                @endforeach
            </select>
            @error('current_province_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="mb-4">
            <label for="" class="form-label" style="font-weight: bold;">Municipality</label>
            <select id="current_municipality" name="current_municipality_id" class="form-control @error('current_municipality_id') is-invalid @enderror" required>
                <option value=""
                >Select Municipality</option>
            </select>
            @error('current_municipality_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="mb-4">
            <label for="" class="form-label" style="font-weight: bold;">Barangay</label>
            <select id="current_barangay" name="current_barangay_id" class="form-control @error('current_barangay_id') is-invalid @enderror" required>
                <option value="">Select Barangay</option>
            </select>
            @error('current_barangay_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="mb-4">
            <label for="" class="form-label" style="font-weight: bold;">Purok/Village</label>
            <input type="text" class="form-control @error('current_purok') is-invalid @enderror"
                name="current_purok" id="current_purok" value="{{ old('current_purok') }}" required>
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <hr style="border: 2px solid;stroke: black;" />
    <div class="col-xl-3 col-md-3 mb-3">
    <input type="checkbox" id="same_as_current" />
    <label for="same_as_current" style="font-weight: bold;">Same as Current Address</label>
</div>
    <h5>Permanent Address</h5>
    <div class="col-xl-3 col-md-3">
        <div class="mb-4">
            <label for="" class="form-label" style="font-weight: bold;">Province</label>
            <select id="permanent_province" name="permanent_province_id" class="form-control @error('permanent_province_id') is-invalid @enderror" required>
                <option value="">Select Province</option>
                @foreach($provinces as $province)
                <option value="{{ $province->prov_code }}">{{ $province->prov_desc }}</option>
                @endforeach
            </select>
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="mb-4">
            <label for="permanent_address" class="form-label" style="font-weight: bold;">Municipality</label>
            <select id="permanent_municipality" name="permanent_municipality_id" class="form-control @error('permanent_municipality_id') is-invalid @enderror" required>
                <option value="">Select Municipality</option>
            </select>
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="mb-4">
            <label for="permanent_address" class="form-label" style="font-weight: bold;">Barangay</label>
            <select id="permanent_barangay" name="permanent_barangay_id" class="form-control @error('permanent_barangay_id') is-invalid @enderror" required>
                <option value="">Select Barangay</option>
            </select>
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="mb-4">
            <label for="" class="form-label" style="font-weight: bold;">Purok/Village</label>
            <input type="text" class="form-control @error('permanent_purok') is-invalid @enderror"
                name="permanent_purok" id="permanent_purok" value="{{ old('permanent_purok') }}" required>
            <small class="error-message text-danger"></small>
        </div>
    </div>
</div>

   <script>
$('#same_as_current').on('change', function() {
    if (this.checked) {
        // Copy Province
        let currentProvince = $('#current_province').val();
        $('#permanent_province').val(currentProvince).trigger('change');

        // Wait for municipalities to load via AJAX
        setTimeout(function() {
            let currentMunicipality = $('#current_municipality').val();
            $('#permanent_municipality').val(currentMunicipality).trigger('change');

            // Wait for barangays to load via AJAX
            setTimeout(function() {
                let currentBarangay = $('#current_barangay').val();
                $('#permanent_barangay').val(currentBarangay);
            }, 500); // adjust timeout to match your AJAX load speed
        }, 500); 

        $('#permanent_purok').val($('#current_purok').val());
        // Make selects "readonly" (submit works)
        $('#permanent_province, #permanent_municipality, #permanent_barangay')
            .css('pointer-events', 'none')
            .css('background-color', '#e9ecef');

    } else {
        // Enable selects again and clear values if needed
        $('#permanent_province, #permanent_municipality, #permanent_barangay')
            .css('pointer-events', 'auto')
            .css('background-color', '');

        $('#permanent_province').val('').trigger('change');
        $('#permanent_municipality').val('').trigger('change');
        $('#permanent_barangay').val('');

        // Purok stays editable, not affected
    }
});

$(document).ready(function() {
    // Restrict birthdate to at least 18 years old
    let today = new Date();
    let year = today.getFullYear() - 18; // 18 years ago
    let month = (today.getMonth() + 1).toString().padStart(2, '0'); // months are 0-indexed
    let day = today.getDate().toString().padStart(2, '0');
    let maxDate = `${year}-${month}-${day}`;

    let $birthdate = $('input[name="birthdate"]');
    $birthdate.attr('max', maxDate);

    // Optional: real-time feedback if they type manually
    $birthdate.on('input', function() {
        if (this.value > maxDate) {
            $(this).val(''); // clear invalid date
            alert('You must be at least 18 years old.'); // simple feedback
        }
    });
});



</script>


