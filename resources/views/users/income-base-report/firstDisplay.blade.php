@extends('layouts.user')

@section('title', 'Incomebase Reports')

@section('content')
<div class="container mt-4">
    <h2>Incomebase Reports</h2>

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
            @include('user.income-base-report.table', ['students' => $below10k, 'title' => 'Below 10k'])
            <a href="{{ route('user.below10k.print') }}" target="_blank" class="btn btn-primary mt-2">Print</a>
        </div>

        <!-- Between 10k-20k Tab -->
        <div class="tab-pane fade" id="tenk_to_twenty" role="tabpanel" aria-labelledby="tenk_to_twenty-tab">
            @include('user.income-base-report.table2', ['students' => $tenkToTwentyk, 'title' => '10k-20k'])
            <a href="{{ route('user.between10k-20k.print') }}" target="_blank" class="btn btn-primary mt-2">Print</a>
        </div>

        <!-- Between 20k-30k Tab -->
        <div class="tab-pane fade" id="twentyk_to_thirty" role="tabpanel" aria-labelledby="twentyk_to_thirty-tab">
            @include('user.income-base-report.table3', ['students' => $twentykToThirtyk, 'title' => '20k-30k'])
            <a href="{{ route('user.between20k-30k.print') }}" target="_blank" class="btn btn-primary mt-2">Print</a>
        </div>

        <!-- Above 30k Tab -->
        <div class="tab-pane fade" id="above_30k" role="tabpanel" aria-labelledby="above_30k-tab">
            @include('user.income-base-report.table4', ['students' => $above30k, 'title' => 'Above 30k'])
            <a href="{{ route('user.above-30k.print') }}" target="_blank" class="btn btn-primary mt-2">Print</a>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myTabs = new bootstrap.Tab(document.querySelector('#incomeTabs a.active'), {});

        document.querySelector('#below_10k').classList.add('show', 'active');
    });
</script>

@endsection