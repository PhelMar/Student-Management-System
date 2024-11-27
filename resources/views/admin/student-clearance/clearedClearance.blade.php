@extends('layouts.admin')

@section('title', 'Cleared Clearance View')

@section('content')
<div class="container mt-4">

    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2>Cleared Clearance View</h2>
        <button onclick="goBack()" class="btn btn-secondary mt-3">Go Back</button>
    </div>

    <!-- Tab navigation -->
    <div class="container mt-3">
        <ul class="nav nav-tabs" id="clearedTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="BSIT-tab" data-bs-toggle="tab" href="#BSIT" role="tab" aria-controls="BSIT" aria-selected="true">BSIT</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="BSTM-tab" data-bs-toggle="tab" href="#BSTM" role="tab" aria-controls="BSTM" aria-selected="false">BSTM</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="BSBA_MM-tab" data-bs-toggle="tab" href="#BSBA_MM" role="tab" aria-controls="BSBA_MM" aria-selected="false">BSBA MM</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="BSBA_FM-tab" data-bs-toggle="tab" href="#BSBA_FM" role="tab" aria-controls="BSBA_FM" aria-selected="false">BSBA FM</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="BEED-tab" data-bs-toggle="tab" href="#BEED" role="tab" aria-controls="BEED" aria-selected="false">BEED</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="BSED_ENGLISH-tab" data-bs-toggle="tab" href="#BSED_ENGLISH" role="tab" aria-controls="BSED_ENGLISH" aria-selected="false">BSED ENGLISH</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="BSED_VALUES-tab" data-bs-toggle="tab" href="#BSED_VALUES" role="tab" aria-controls="BSED_VALUES" aria-selected="false">BSED VALUES</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="BSED_SOCIAL_STUDIES-tab" data-bs-toggle="tab" href="#BSED_SOCIAL_STUDIES" role="tab" aria-controls="BSED_SOCIAL_STUDIES" aria-selected="false">BSED SOCIAL STUDIES</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="BSCRIM-tab" data-bs-toggle="tab" href="#BSCRIM" role="tab" aria-controls="BSCRIM" aria-selected="false">BSCRIM</a>
            </li>
        </ul>
    </div>


    <div class="tab-content mt-3" id="clearedTabsContent">

        <div class="tab-pane fade show active" id="BSIT" role="tabpanel" aria-labelledby="BSIT-tab">
            @include('admin.student-clearance.bsit-table')
            <a href="{{ route('admin.bsit.print') }}" target="_blank" class="btn btn-primary mt-2">Print</a>
        </div>


        <div class="tab-pane fade" id="BSTM" role="tabpanel" aria-labelledby="BSTM-tab">
            @include('admin.student-clearance.bstm-table2')
            <a href="{{ route('admin.bstm.print') }}" target="_blank" class="btn btn-primary mt-2">Print</a>
        </div>


        <div class="tab-pane fade" id="BSBA_MM" role="tabpanel" aria-labelledby="BSBA_MM-tab">
            @include('admin.student-clearance.bsba-mm-table3')
            <a href="{{ route('admin.bsbamm.print') }}" target="_blank" class="btn btn-primary mt-2">Print</a>
        </div>


        <div class="tab-pane fade" id="BSBA_FM" role="tabpanel" aria-labelledby="BSBA_FM-tab">
            @include('admin.student-clearance.bsba-fm-table4')
            <a href="{{ route('admin.bsbafm.print') }}" target="_blank" class="btn btn-primary mt-2">Print</a>
        </div>
        <!-- -->
        <div class="tab-pane fade" id="BEED" role="tabpanel" aria-labelledby="BEED-tab">
            @include('admin.student-clearance.beed-table5')
            <a href="{{ route('admin.beed.print') }}" target="_blank" class="btn btn-primary mt-2">Print</a>
        </div>

        <div class="tab-pane fade" id="BSED_ENGLISH" role="tabpanel" aria-labelledby="BSED_ENGLISH-tab">
            @include('admin.student-clearance.bsed_english-table6')
            <a href="{{ route('admin.bsedenglish.print') }}" target="_blank" class="btn btn-primary mt-2">Print</a>
        </div>

        <div class="tab-pane fade" id="BSED_VALUES" role="tabpanel" aria-labelledby="BSED_VALUES-tab">
            @include('admin.student-clearance.bsed-values-table7')
            <a href="{{ route('admin.bsedvalues.print') }}" target="_blank" class="btn btn-primary mt-2">Print</a>
        </div>

        <div class="tab-pane fade" id="BSED_SOCIAL_STUDIES" role="tabpanel" aria-labelledby="BSED_SOCIAL_STUDIES-tab">
            @include('admin.student-clearance.bsed_social_studies-table8')
            <a href="{{ route('admin.bsedsocialstudies.print') }}" target="_blank" class="btn btn-primary mt-2">Print</a>
        </div>

        <div class="tab-pane fade" id="BSCRIM" role="tabpanel" aria-labelledby="BSCRIM-tab">
            @include('admin.student-clearance.bscrim-table9')
            <a href="{{ route('admin.bscrim.print') }}" target="_blank" class="btn btn-primary mt-2">Print</a>
        </div>
    </div>
</div>

<script>
    const BSITUrl = "{{route('admin.BSITcleared.display')}}";
    const BSTMUrl = "{{route('admin.BSTMcleared.display')}}";
    const BSBAFMUrl = "{{route('admin.BSBAFMcleared.display')}}";
    const BSBAMMUrl = "{{route('admin.BSBAMMcleared.display')}}";
    const BEEDUrl = "{{route('admin.BEEDcleared.display')}}";
    const BSEDSOCIALSTUDIESUrl = "{{route('admin.BSEDSOCIALSTUDIEScleared.display')}}";
    const BSEDENGLISHUrl = "{{route('admin.BSEDENGLISHcleared.display')}}";
    const BSEDVALUESUrl = "{{route('admin.BSEDVALUEScleared.display')}}";
    const BSCRIMUrl = "{{route('admin.BSCRIMcleared.display')}}";
    document.addEventListener('DOMContentLoaded', function() {
        var myTabs = new bootstrap.Tab(document.querySelector('#clearedTabs a.active'), {});

        document.querySelector('#BSIT').classList.add('show', 'active');
    });

    function goBack() {
        window.history.back();
    }
</script>
<script src="{{asset('admin/js/BSIT.js')}}"></script>
<script src="{{asset('admin/js/BSTM.js')}}"></script>
<script src="{{asset('admin/js/BSBA_FM.js')}}"></script>
<script src="{{asset('admin/js/BSBA_MM.js')}}"></script>
<script src="{{asset('admin/js/BEED.js')}}"></script>
<script src="{{asset('admin/js/BSED_SOCIAL_STUDIES.js')}}"></script>
<script src="{{asset('admin/js/BSED_ENGLISH.js')}}"></script>
<script src="{{asset('admin/js/BSED_VALUES.js')}}"></script>
<script src="{{asset('admin/js/BSCRIM.js')}}"></script>

@endsection