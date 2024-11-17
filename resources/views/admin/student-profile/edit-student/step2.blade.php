<div class="row">
    <hr style="border: 2px solid;stroke: black;" />
    <div class="col-xl-4 col-md-4">
        <div class="mb-4">
            <label for="contact_no" class="form-label" style="font-weight: bold;">Contact No.</label>
            <input type="text" class="form-control @error('contact_no') is-invalid @enderror"
                name="contact_no" value="{{ old('contact_no', $students->contact_no) }}" id="contact_no" required>
            <small id="contactNoError" style="color:red"></small>
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <div class="col-xl-4 col-md-4">
        <div class="mb-4">
            <label for="email_address" class="form-label" style="font-weight: bold;">Email Accout</label>
            <input type="email" class="form-control @error('email_address') is-invalid @enderror" id="email_address"
                name="email_address" value="{{ old('email_address', $students->email_address) }}" required>
            <small id="emailError" style="color:red"></small>
            <div id="email_error" class="invalid-feedback" style="display: none;">Email is already in use.</div>
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <div class="col-xl-4 col-md-4">
        <div class="mb-4">
            <label for="facebook_account" class="form-label" style="font-weight: bold;">Facebook Acount</label>
            <input type="text" class="form-control @error('facebook_account') is-invalid @enderror"
                name="facebook_account" value="{{ old('facebook_account', $students->facebook_account) }}" required>
                <small class="error-message text-danger"></small>
        </div>
    </div>
    <hr style="border: 2px solid;stroke: black;" />
    <div class="col-xl-6 col-md-6">
        <div class="mb-4">
            <label for="dialect_id" class="form-label" style="font-weight: bold;">Languages/Dialects Spoken at Home</label>
            <select class="form-control @error('dialect_id') is-invalid @enderror"
                name="dialect_id" value="{{ old('dialect_id') }}" required>
                <option value="" disabled selected>Select Dialect</option>
                @foreach ($dialects as $dialect)
                <option value="{{$dialect->id}}" {{$students->dialect_id == $dialect->id ? 'selected' : ''}}>
                    {{$dialect->dialect_name}}
                </option>
                @endforeach
            </select>
            <small class="error-message text-danger"></small>
        </div>
        <div class="mb-4">
            <label for="pwd" class="form-label" style="font-weight: bold;">Are you PWD?</label>
            <select class="form-control @error('pwd') is-invalid @enderror" id="pwd" name="pwd"
                onchange="toggleRemarks('pwd_remarks', this.value)" required>
                <option value="" disabled selected>Select</option>
                <option value="No" {{old('pwd', $students->pwd) == "No" ? 'selected' : ''}}>No</option>
                <option value="Yes" {{old('pwd', $students->pwd) == "Yes" ? 'selected' : ''}}>Yes</option>
            </select>
            <small class="error-message text-danger"></small>
        </div>

        <div class="mb-4" id="pwd_remarks" style="display: none;">
            <label for="pwd_remarksInput" class="form-label">Remarks:</label>
            <input type="text" class="form-control @error('pwd_remarks') is-invalid @enderror"
                value="{{old('pwd_remarks', $students->pwd_remarks)}}" required
                id="pwd_remarksInput" name="pwd_remarks">
                <small class="error-message text-danger"></small>
        </div>
        <div class="mb-4">
            <label for="solo_parent" class="form-label" style="font-weight: bold;">Are you a Solo Parent?</label>
            <select class="form-control @error('solo_parent') is-invalid @enderror" required
                id="solo_parent" name="solo_parent">
                <option value="" disabled selected>Select</option>
                <option value="No" {{old('solo_parent', $students->solo_parent) == "No" ? 'selected' : ''}}>No</option>
                <option value="Yes" {{old('solo_parent', $students->solo_parent) == "Yes" ? 'selected' : ''}}>Yes</option>
            </select>
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <div class="col-xl-6 col-md-6">
        <div class="mb-4">
            <label for="student_religion_id" class="form-label" style="font-weight: bold;">Religion</label>
            <select class="form-control @error('student_religion_id') is-invalid @enderror"
                name="student_religion_id" value="{{ old('student_religion_id') }}" required>
                <option value="" disabled selected>Select Religion</option>
                @foreach ($religions as $religion)
                <option value="{{$religion->id}}" {{$students->StudentsReligion && $students->StudentsReligion->id == $religion->id ? 'selected' : ''}}>
                    {{$religion->religion_name}}
                </option>
                @endforeach
            </select>
            <small class="error-message text-danger"></small>
        </div>
        <div class="mb-4">
            <label for="ips" class="form-label" style="font-weight: bold;">Are you IPs?</label>
            <select class="form-control @error('ips') is-invalid @enderror" id="ips" name="ips"
                onchange="toggleRemarks('ips_remarks', this.value)" required>
                <option value="" disabled selected>Select</option>
                <option value="No" {{old('ips', $students->ips) == "No" ? 'selected' : ''}}>No</option>
                <option value="Yes" {{old('ips', $students->ips) == "Yes" ? 'selected' : ''}}>Yes</option>
            </select>
            <small class="error-message text-danger"></small>
        </div>

        <div class="mb-4" id="ips_remarks" style="display: none;">
            <label for="ips_remarksInput" class="form-label">Remarks:</label>
            <input type="text" class="form-control @error('ips_remarks') is-invalid @enderror"
                value="{{old('ips_remarks', $students->ips_remarks)}}" required
                id="ips_remarksInput" name="ips_remarks">
                <small class="error-message text-danger"></small>
        </div>
        <div class="mb-4">
            <label for="stay_id" class="form-label" style="font-weight: bold;">Who are you staying?</label>
            <select class="form-control @error('stay_id') is-invalid @enderror"
                name="stay_id" value="{{ old('stay_id') }}" required>
                <option value="" disabled selected>Please Select</option>
                @foreach ($stays as $stay)
                <option value="{{$stay->id}}" {{$students->stay_id == $stay->id ? 'selected' : ''}}>
                    {{$stay->stay_name}}
                </option>
                @endforeach
            </select>
            <small class="error-message text-danger"></small>
        </div>
    </div>
</div>