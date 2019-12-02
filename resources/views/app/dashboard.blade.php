@extends('layouts.app')

@section('content')

<div class="container mt-3">

    <simplert :useRadius="true" :useIcon="true" ref="simplert"></simplert>
    <router-view></router-view>

</div>
@endsection

@section('bottom_scripts')
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@endsection
