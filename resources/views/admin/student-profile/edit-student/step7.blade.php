<div class="row">
    <h3>Educational Background</h3>
    <hr style="border: 2px solid;stroke: black;" />
    <div class="col-xl-6 col-md-6">
        <h5>Name of school attended</h5>
        <div class="mb-4">
            <label for="kindergarten" class="form-label" style="font-weight: bold;">Kindergarten</label>
            <input type="text" class="form-control @error('kindergarten') is-invalid @enderror"
                name="kindergarten" value="{{ old('kindergarten', $students->kindergarten) }}">
        </div>
        <div class="mb-4">
            <label for="elementary" class="form-label" style="font-weight: bold;">Elementary</label>
            <input type="text" class="form-control @error('elementary') is-invalid @enderror"
                name="elementary" value="{{ old('elementary', $students->elementary) }}" required>
                <small class="error-message text-danger"></small>
        </div>
        <div class="mb-4">
            <label for="junior_high" class="form-label" style="font-weight: bold;">Junior High</label>
            <input type="text" class="form-control @error('junior_high') is-invalid @enderror"
                name="junior_high" value="{{ old('junior_high', $students->junior_high) }}" required>
                <small class="error-message text-danger"></small>
        </div>
        <div class="mb-4">
            <label for="senior_high" class="form-label" style="font-weight: bold;">Senior High</label>
            <input type="text" class="form-control @error('senior_high') is-invalid @enderror"
                name="senior_high" value="{{ old('senior_high', $students->senior_high) }}">
        </div>
    </div>
    <div class="col-xl-6 col-md-6">
        <h5>School year graduated</h5>
        <div class="mb-4">
            <label for="kindergarten_year_attended" class="form-label" style="font-weight: bold;">Kindergarten Year Attended</label>
            <input type="text" class="form-control @error('kindergarten_year_attended') is-invalid @enderror"
                name="kindergarten_year_attended" value="{{ old('kindergarten_year_attended', $students->kindergarten_year_attended) }}">
        </div>
        <div class="mb-4">
            <label for="elementary_year_attended" class="form-label" style="font-weight: bold;">Elementary Year Attended</label>
            <input type="text" class="form-control @error('elementary_year_attended') is-invalid @enderror" required
                name="elementary_year_attended" value="{{ old('elementary_year_attended', $students->elementary_year_attended) }}">
                <small class="error-message text-danger"></small>
        </div>
        <div class="mb-4">
            <label for="junior_high_year_attended" class="form-label" style="font-weight: bold;">Junior High Year Attended</label>
            <input type="text" class="form-control @error('junior_high_year_attended') is-invalid @enderror" required
                name="junior_high_year_attended" value="{{ old('junior_high_year_attended', $students->junior_high_year_attended) }}">
                <small class="error-message text-danger"></small>
        </div>
        <div class="mb-4">
            <label for="senior_high_year_attended" class="form-label" style="font-weight: bold;">Senior High Year Attended</label>
            <input type="text" class="form-control @error('senior_high_year_attended') is-invalid @enderror"
                name="senior_high_year_attended" value="{{ old('senior_high_year_attended', $students->senior_high_year_attended) }}">
        </div>
    </div>
</div>