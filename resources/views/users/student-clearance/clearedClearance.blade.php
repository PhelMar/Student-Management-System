@extends('layouts.user')

@section('title', 'Cleared Clearance View')

@section('content')
<div class="container mt-4">
    <h2>Cleared Clearance View</h2>

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
            @include('users.student-clearance.bsit-table')
            <a href="{{ route('user.bsit.print') }}" target="_blank" class="btn btn-primary mt-2">Print</a>
        </div>


        <div class="tab-pane fade" id="BSTM" role="tabpanel" aria-labelledby="BSTM-tab">
            @include('users.student-clearance.bstm-table2')
            <a href="{{ route('user.bstm.print') }}" target="_blank" class="btn btn-primary mt-2">Print</a>
        </div>


        <div class="tab-pane fade" id="BSBA_MM" role="tabpanel" aria-labelledby="BSBA_MM-tab">
            @include('users.student-clearance.bsba-mm-table3')
            <a href="{{ route('user.bsbamm.print') }}" target="_blank" class="btn btn-primary mt-2">Print</a>
        </div>


        <div class="tab-pane fade" id="BSBA_FM" role="tabpanel" aria-labelledby="BSBA_FM-tab">
            @include('users.student-clearance.bsba-fm-table4')
            <a href="{{ route('user.bsbafm.print') }}" target="_blank" class="btn btn-primary mt-2">Print</a>
        </div>
        <!-- -->
        <div class="tab-pane fade" id="BEED" role="tabpanel" aria-labelledby="BEED-tab">
            @include('users.student-clearance.beed-table5')
            <a href="{{ route('user.beed.print') }}" target="_blank" class="btn btn-primary mt-2">Print</a>
        </div>

        <div class="tab-pane fade" id="BSED_ENGLISH" role="tabpanel" aria-labelledby="BSED_ENGLISH-tab">
            @include('users.student-clearance.bsed_english-table6')
            <a href="{{ route('user.bsedenglish.print') }}" target="_blank" class="btn btn-primary mt-2">Print</a>
        </div>

        <div class="tab-pane fade" id="BSED_VALUES" role="tabpanel" aria-labelledby="BSED_VALUES-tab">
            @include('users.student-clearance.bsed-values-table7')
            <a href="{{ route('user.bsedvalues.print') }}" target="_blank" class="btn btn-primary mt-2">Print</a>
        </div>

        <div class="tab-pane fade" id="BSED_SOCIAL_STUDIES" role="tabpanel" aria-labelledby="BSED_SOCIAL_STUDIES-tab">
            @include('users.student-clearance.bsed_social_studies-table8')
            <a href="{{ route('user.bsedsocialstudies.print') }}" target="_blank" class="btn btn-primary mt-2">Print</a>
        </div>

        <div class="tab-pane fade" id="BSCRIM" role="tabpanel" aria-labelledby="BSCRIM-tab">
            @include('users.student-clearance.bscrim-table9')
            <a href="{{ route('user.bscrim.print') }}" target="_blank" class="btn btn-primary mt-2">Print</a>
        </div>
    </div>
</div>

<script>
    const BSITUrl = "{{route('user.BSITcleared.display')}}";
    const BSTMUrl = "{{route('user.BSTMcleared.display')}}";
    const BSBAFMUrl = "{{route('user.BSBAFMcleared.display')}}";
    const BSBAMMUrl = "{{route('user.BSBAMMcleared.display')}}";
    const BEEDUrl = "{{route('user.BEEDcleared.display')}}";
    const BSEDSOCIALSTUDIESUrl = "{{route('user.BSEDSOCIALSTUDIEScleared.display')}}";
    const BSEDENGLISHUrl = "{{route('user.BSEDENGLISHcleared.display')}}";
    const BSEDVALUESUrl = "{{route('user.BSEDVALUEScleared.display')}}";
    const BSCRIMUrl = "{{route('user.BSCRIMcleared.display')}}";
    document.addEventListener('DOMContentLoaded', function() {
        var myTabs = new bootstrap.Tab(document.querySelector('#clearedTabs a.active'), {});

        document.querySelector('#BSIT').classList.add('show', 'active');
    });
</script>
<script src="{{asset('user/js/BSIT.js')}}"></script>
<script src="{{asset('user/js/BSTM.js')}}"></script>
<script src="{{asset('user/js/BSBA_FM.js')}}"></script>
<script src="{{asset('user/js/BSBA_MM.js')}}"></script>
<script src="{{asset('user/js/BEED.js')}}"></script>
<script src="{{asset('user/js/BSED_SOCIAL_STUDIES.js')}}"></script>
<script src="{{asset('user/js/BSED_ENGLISH.js')}}"></script>
<script src="{{asset('user/js/BSED_VALUES.js')}}"></script>
<script src="{{asset('user/js/BSCRIM.js')}}"></script>

@endsection