<div class="row">
    <hr style="border: 2px solid;stroke: black;" />
    <div class="col-xl-4 col-md-4">
        <div class="mb-4">
            <label for="contact_no" class="form-label" style="font-weight: bold;">Contact No.</label>
            <input type="text" class="form-control @error('contact_no') is-invalid @enderror" name="contact_no"
                value="{{ old('contact_no') }}" id="contact_no" required>
            <small id="contactNoError" style="color:red"></small>
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <div class="col-xl-4 col-md-4">
        <div class="mb-4">
            <label for="email_address" class="form-label" style="font-weight: bold;">Email Accout</label>
            <input type="email" class="form-control @error('email_address') is-invalid @enderror" id="email_address"
                name="email_address" value="{{ old('email_address') }}" required>
            <small id="email_address_error" style="color:red"></small>
            <small class="error-message text-danger"></small>
            <div id="email_error" class="invalid-feedback" style="display: none;">Email is already in use.</div>
        </div>
    </div>
    <div class="col-xl-4 col-md-4">
        <div class="mb-4">
            <label for="facebook_account" class="form-label" style="font-weight: bold;">Facebook Acount</label>
            <input type="text" class="form-control @error('facebook_account') is-invalid @enderror"
                name="facebook_account" value="{{ old('facebook_account') }}" required>
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <hr style="border: 2px solid;stroke: black;" />
    <div class="col-xl-6 col-md-6">
        <div class="mb-4">
            <label for="dialect_id" class="form-label" style="font-weight: bold;">Languages/Dialects Spoken at
                Home</label>
            <select class="form-control @error('dialect_id') is-invalid @enderror" name="dialect_id"
                value="{{ old('dialect_id') }}" required>
                <option value="" disabled selected></option>
                @foreach ($dialects as $dialect)
                <option value="{{$dialect->id}}" {{old('dialect_id') == $dialect->id ? 'selected' : ''}}>
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
                <option value="" disabled selected></option>
                <option value="No">No</option>
                <option value="Yes">Yes</option>
            </select>
            <small class="error-message text-danger"></small>
        </div>

        <div class="mb-4" id="pwd_remarks" style="display: none;">
            <label for="pwd_remarksInput" class="form-label">Remarks:</label>
            <input type="text" class="form-control @error('pwd_remarks') is-invalid @enderror" id="pwd_remarksInput"
                name="pwd_remarks">
            <small class="error-message text-danger"></small>
        </div>
        <div class="mb-4">
            <label for="solo_parent" class="form-label" style="font-weight: bold;">Are you a Solo Parent?</label>
            <select class="form-control @error('solo_parent') is-invalid @enderror" id="solo_parent" name="solo_parent"
                required>
                <option value="" disabled selected></option>
                <option value="No">No</option>
                <option value="Yes">Yes</option>
            </select>
            <small class="error-message text-danger"></small>
        </div>
        <div class="mb-4">
            <label for="four_ps" class="form-label" style="font-weight: bold;">Are you a 4p's member?</label>
            <select class="form-control @error('four_ps') is-invalid @enderror" id="four_ps" name="four_ps" required>
                <option value="" disabled selected></option>
                <option value="No">No</option>
                <option value="Yes">Yes</option>
            </select>
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <div class="col-xl-6 col-md-6">
        <div class="mb-4">
            <label for="student_religion_id" class="form-label" style="font-weight: bold;">Religion</label>
            <select class="form-control @error('student_religion_id') is-invalid @enderror" name="student_religion_id"
                value="{{ old('student_religion_id') }}" required>
                <option value="" disabled selected></option>
                @foreach ($religions as $religion)
                <option value="{{$religion->id}}" {{old('student_religion_id') == $religion->id ? 'selected' : '' }}>
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
                <option value="" disabled selected></option>
                <option value="No">No</option>
                <option value="Yes">Yes</option>
            </select>
            <small class="error-message text-danger"></small>
        </div>

        <div class="mb-4" id="ips_remarks" style="display: none;">
            <label for="ips_remarksInput" class="form-label">Remarks:</label>
            <input type="text" class="form-control @error('ips_remarks') is-invalid @enderror" id="ips_remarksInput"
                name="ips_remarks" required>
            <small class="error-message text-danger"></small>
        </div>
        <div class="mb-4">
            <label for="stay_id" class="form-label" style="font-weight: bold;">Who are you staying?</label>
            <select class="form-control @error('stay_id') is-invalid @enderror" name="stay_id"
                value="{{ old('stay_id') }}" required>
                <option value="" disabled selected></option>
                @foreach ($stays as $stay)
                <option value="{{$stay->id}}">{{$stay->stay_name}}</option>
                @endforeach
            </select>
            <small class="error-message text-danger"></small>
        </div>
    </div>
</div>