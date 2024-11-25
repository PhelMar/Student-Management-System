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
                    <a class="nav-link" href="{{route('user.students.display')}}">View Students</a>
                    <a class="nav-link" href="{{route('user.violations.display')}}">View Students Violations</a>
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
                    <a class="nav-link" href="{{route('user.clearance.display')}}">View Clearance</a>
                </nav>
            </div>

        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        {{ Auth::user()->name ?? 'user' }}
    </div>
</nav>