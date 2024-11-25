<div class="card shadow">
    <div class="card-header text-white" style="background-color: #0A7075">
        <i class="fas fa-table me-1"></i>
        <h5>Below 10k total Income of Parents</h5>
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Course</th>
                    <th>Year</th>
                    <th>School Year</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$student->first_name}} {{$student->last_name}}</td>
                    <td>{{$student->course->course_name}}</td>
                    <td>{{$student->year->year_name}}</td>
                    <td>{{$student->school_year->school_year_name}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>