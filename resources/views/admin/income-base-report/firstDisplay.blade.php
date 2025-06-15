@extends('layouts.admin')

@section('title', 'Incomebase Reports')

@section('content')
<div class="container mt-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2>Income Base Reports</h2>
        <button onclick="goBack()" class="btn btn-secondary mt-3">Go Back</button>
    </div>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>

    <!-- Tab navigation -->
    <div class="container mt-3">
        <ul class="nav nav-tabs" id="incomeTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="below_10k-tab" data-bs-toggle="tab" href="#below_10k" role="tab" aria-controls="below_10k" aria-selected="true">10k Below</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tenk_to_twenty-tab" data-bs-toggle="tab" href="#tenk_to_twenty" role="tab" aria-controls="tenk_to_twenty" aria-selected="false">Between 10k-20k</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="twentyk_to_thirty-tab" data-bs-toggle="tab" href="#twentyk_to_thirty" role="tab" aria-controls="twentyk_to_thirty" aria-selected="false">Between 20k-30k</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="above_30k-tab" data-bs-toggle="tab" href="#above_30k" role="tab" aria-controls="above_30k" aria-selected="false">Above 30k</a>
            </li>
        </ul>
    </div>

    <!-- Tab content -->
    <div class="tab-content mt-3" id="incomeTabsContent">
        <!-- 10k Below Tab -->
        <div class="tab-pane fade show active" id="below_10k" role="tabpanel" aria-labelledby="below_10k-tab">
            @include('admin.income-base-report.table')
                <button type="button"
                    class="btn btn-primary mt-3 openReportModal"
                    data-route="{{ route('admin.below10k.print') }}">
                    <i class="fa fa-file-alt me-2"></i> Generate Report
                </button>
        </div>

        <!-- Between 10k-20k Tab -->
        <div class="tab-pane fade" id="tenk_to_twenty" role="tabpanel" aria-labelledby="tenk_to_twenty-tab">
            @include('admin.income-base-report.table2')
                <button type="button"
                    class="btn btn-primary mt-3 openReportModal"
                    data-route="{{ route('admin.between10k-20k.print') }}">
                    <i class="fa fa-file-alt me-2"></i> Generate Report
                </button>
        </div>

        <!-- Between 20k-30k Tab -->
        <div class="tab-pane fade" id="twentyk_to_thirty" role="tabpanel" aria-labelledby="twentyk_to_thirty-tab">
            @include('admin.income-base-report.table3')
                <button type="button"
                    class="btn btn-primary mt-3 openReportModal"
                    data-route="{{ route('admin.between20k-30k.print') }}">
                    <i class="fa fa-file-alt me-2"></i> Generate Report
                </button>
        </div>

        <!-- Above 30k Tab -->
        <div class="tab-pane fade" id="above_30k" role="tabpanel" aria-labelledby="above_30k-tab">
            @include('admin.income-base-report.table4')
                <button type="button"
                    class="btn btn-primary mt-3 openReportModal"
                    data-route="{{ route('admin.above-30k.print') }}">
                    <i class="fa fa-file-alt me-2"></i> Generate Report
                </button>
        </div>
    </div>
</div>


<!-- Report Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
  <div class="modal-dialog">
  <form id="reportForm" method="GET" target="_self">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="reportModalLabel">Generate Student Report</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-group mb-3">
            <label for="school_year_id">School Year:</label>
            <select name="school_year_id" id="school_year_id" class="form-control" required>
              <option value="" selected>Select School Year</option>
              @foreach ($school_year as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group mb-3">
            <label for="semester">Semester:</label>
            <select name="semester_id" id="semester_id" class="form-control" required>
              <option value="">-- Select --</option>
              <option value="1st Semester">1st Semester</option>
              <option value="2nd Semester">2nd Semester</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="action" value="print" class="btn btn-success" onclick="openInNewTab(event)">
            <i class="fas fa-print"></i> Print
        </button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
    const below10Thousand = "{{ route('admin.belowTenK.display') }}";
    const between10to20Thousand = "{{ route('admin.betweenTenToTwentyThousand.display') }}";
    const between20to30Thousand = "{{ route('admin.betweenTwentyToThirtyThousand.display') }}";
    const above30Thousand = "{{ route('admin.aboveThirtyThousand.display') }}";

    document.addEventListener('DOMContentLoaded', function() {
        var myTabs = new bootstrap.Tab(document.querySelector('#incomeTabs a.active'), {});

        document.querySelector('#below_10k').classList.add('show', 'active');
    });

    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.openReportModal');
        const form = document.getElementById('reportForm');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const route = this.getAttribute('data-route');
                form.setAttribute('action', route);
                form.setAttribute('target', '_self'); // Default to same tab
                const modal = new bootstrap.Modal(document.getElementById('reportModal'));
                modal.show();
            });
        });

        window.openInNewTab = function (e) {
            const form = document.getElementById('reportForm');
            form.setAttribute('target', '_blank');
        };
    });
    
</script>
<script src="{{asset('admin/js/belowTenThousand.js')}}"></script>
<script src="{{asset('admin/js/betweenTenToTwentyThousand.js')}}"></script>
<script src="{{asset('admin/js/betweenTwentyToThirtyThousand.js')}}"></script>
<script src="{{asset('admin/js/aboveThirtyThousand.js')}}"></script>

@endsection