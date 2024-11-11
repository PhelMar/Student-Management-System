<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">

            <!-- Dashboards -->
            <div class="sb-sidenav-menu-heading">Core</div>
            <a class="nav-link" href="{{route('user.dashboard')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>

            <!-- Students -->
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseStudents" aria-expanded="false" aria-controls="collapseStudents">
                <div class="sb-nav-link-icon"><i class="fas fa-graduation-cap"></i></div>
                Students
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseStudents" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{route('user.students.create')}}">Add Students</a>
                    <a class="nav-link" href="{{route('user.students.display')}}">View Students</a>

                    <!-- Generate Reports Submenu -->
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseReports" aria-expanded="false" aria-controls="collapseReports">
                        <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                        Generate Reports
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseReports" aria-labelledby="headingThree" data-bs-parent="#collapseStudents">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="report-students.html">Students</a>
                            <a class="nav-link" href="report-ips.html">IP's</a>
                            <a class="nav-link" href="report-pwd.html">PWD</a>
                            <a class="nav-link" href="report-solo-parent.html">Solo Parent</a>
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
                    <a class="nav-link" href="{{route('user.violations.display')}}">View Students</a>
                    <a class="nav-link" href="{{route('user.violations.create')}}">Add Student Violations</a>
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
                    <a class="nav-link" href="{{route('user.organizations.display')}}">View Organizations</a>
                    <a class="nav-link" href="{{route('user.organizations.create')}}">Add Student Organizations</a>
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
                <a class="nav-link" href="{{route('user.clearance.create')}}">Create Clearance</a>
                <a class="nav-link" href="{{route('user.clearance.display')}}">View Clearance</a>
                </nav>
            </div>



            <div class="sb-sidenav-menu-heading">Addons</div>
            <a class="nav-link" href="charts.html">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                Charts
            </a>
            <a class="nav-link" href="tables.html">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                Tables
            </a>
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        {{ Auth::user()->name ?? 'User' }}
    </div>
</nav>