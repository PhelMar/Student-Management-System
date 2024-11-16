<div class="card">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        <h5>BSED Values Cleared Students</h5>
    </div>
    <div class="card-body">
        <table id="datatablesSimple7">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Course</th>
                    <th>Year</th>
                    <th>School Year</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$student->student->first_name}} {{$student->student->last_name}}</td>
                    <td>{{$student->course->course_name}}</td>
                    <td>{{$student->year->year_name}}</td>
                    <td>{{$student->school_year->school_year_name}}</td>
                    <td>{{$student->status}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>