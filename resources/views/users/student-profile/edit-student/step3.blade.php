<div class="row">
    <hr style="border: 2px solid;stroke: black;" />
    <div class="col-xl-4 col-md-4">
        <div class="mb-4">
            <label for="id_no" class="form-label" style="font-weight: bold;">ID No</label>
            <input type="text" class="form-control @error('id_no') is-invalid @enderror"
                id="id_no" name="id_no" value="{{ old('id_no', $students->id_no) }}" id="id_no" required>
            <small id="idNoError" style="color: red;"></small>
            @error('id_no')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="idNoError" class="invalid-feedback" style="display: none;">ID No. is already in exist.</div>
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <div class="col-xl-4 col-md-4">
        <div class="mb-4">
            <label for="school_year_id" class="form-label" style="font-weight: bold;">School Year</label>
            <select class="form-control @error('school_year_id') is-invalid @enderror"
                name="school_year_id" value="{{ old('school_year_id') }}" required>
                <option value="" disabled selected>Select School Year</option>
                @foreach ($school_years as $school_year)
                <option value="{{$school_year->id}}" {{$students->school_year_id == $school_year->id ? 'selected' : ''}}>
                    {{$school_year->school_year_name}}
                </option>
                @endforeach
            </select>
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <div class="col-xl-4 col-md-4">
        <div class="mb-4">
            <label for="semester_id" class="form-label" style="font-weight: bold;">Semester</label>
            <select class="form-control @error('semester_id') is-invalid @enderror"
                name="semester_id" value="{{ old('semester_id') }}" required>
                <option value="" disabled selected>Select Semester</option>
                @foreach ($semesters as $semester)
                <option value="{{$semester->id}}" {{$students->semester_id == $semester->id ? 'selected' : ''}}>
                    {{$semester->semester_name}}
                </option>
                @endforeach
            </select>
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <hr style="border: 1px solid;stroke: black;" />
    <div class="col-xl-6 col-md-6">
        <div class="mb-4">
            <label for="course_id" class="form-label" style="font-weight: bold;">Course</label>
            <select class="form-control @error('course_id') is-invalid @enderror"
                name="course_id" value="{{ old('course_id') }}" required>
                <option value="" disabled selected>Select Course</option>
                @foreach ($courses as $course)
                <option value="{{$course->id}}" {{$students->course_id == $course->id ? 'selected' : ''}}>
                    {{$course->course_name}}
                </option>
                @endforeach
            </select>
            <small class="error-message text-danger"></small>
        </div>
    </div>
    <div class="col-xl-6 col-md-6">
        <div class="mb-4">
            <label for="year_id" class="form-label" style="font-weight: bold;">Year Level</label>
            <select class="form-control @error('year_id') is-invalid @enderror"
                name="year_id" value="{{ old('year_id') }}" required>
                <option value="" disabled selected>Select Year</option>
                @foreach ($years as $year)
                <option value="{{$year->id}}" {{$students->year_id == $year->id ? 'selected' : ''}}>
                    {{$year->year_name}}
                </option>
                @endforeach
            </select>
            <small class="error-message text-danger"></small>
        </div>
    </div>
</div>