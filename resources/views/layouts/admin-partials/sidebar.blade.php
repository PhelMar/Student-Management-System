<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">

            <!-- Dashboards -->
            <div class="sb-sidenav-menu-heading">Core</div>
            <a class="nav-link" href="{{route('admin.dashboard')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>

            <!-- Users -->
            <div class="sb-sidenav-menu-heading">Interface</div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                Users
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseUsers" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                    <a class="nav-link" href="{{route('admin.profile.display')}}">View Users</a>
                    <a class="nav-link" href="{{route('admin.register.create')}}">Register New Users</a>
                </nav>
            </div>

            <!-- Students -->
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseStudents" aria-expanded="false" aria-controls="collapseStudents">
                <div class="sb-nav-link-icon"><i class="fas fa-graduation-cap"></i></div>
                Students
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseStudents" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{route('admin.students.create')}}">Add Students</a>
                    <a class="nav-link" href="{{route('admin.students.display')}}">View Students</a>

                    <!-- Generate Reports Submenu -->
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseReports" aria-expanded="false" aria-controls="collapseReports">
                        <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                        Generate Reports
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseReports" aria-labelledby="headingThree" data-bs-parent="#collapseStudents">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{route('admin.students.soloparentdisplay')}}">Solo Parent</a>
                            <a class="nav-link" href="{{route('admin.students.ipsdisplay')}}">IP's</a>
                            <a class="nav-link" href="{{route('admin.students.pwddisplay')}}">PWD</a>
                            <a class="nav-link" href="{{route('admin.incomeFirstReport.display')}}">Income Basis</a>
                        </nav>
                    </div>
                </nav>
            </div>

            <!-- View Violations -->
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseViolations" aria-expanded="false" aria-controls="collapseViolations">
                <div class="sb-nav-link-icon"><i class="fas fa-exclamation-triangle"></i></div>
                Violations
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseViolations" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                    <a class="nav-link" href="{{route('admin.violations.display')}}">View Students</a>
                    <a class="nav-link" href="{{route('admin.violations.create')}}">Add Student Violations</a>
                </nav>
            </div>

            <!-- View Organizations -->
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseOrganizations" aria-expanded="false" aria-controls="collapseOrganizations">
                <div class="sb-nav-link-icon"><i class="fas fa-building"></i></div>
                Organizations
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseOrganizations" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                    <a class="nav-link" href="{{route('admin.organizations.display')}}">View Organizations</a>
                    <a class="nav-link" href="{{route('admin.organizations.create')}}">Add Student Organizations</a>
                </nav>
            </div>

            <!-- Manage Clearance -->
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseClearance" aria-expanded="false" aria-controls="collapseClearance">
                <div class="sb-nav-link-icon"><i class="fas fa-file-signature"></i></div>
                Manage Clearance
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseClearance" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                    <a class="nav-link" href="{{route('admin.clearance.create')}}">Create Clearance</a>
                    <a class="nav-link" href="{{route('admin.clearance.display')}}">View Clearance</a>
                </nav>
            </div>
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        {{ Auth::user()->name ?? 'Admin' }}
    </div>
</nav>