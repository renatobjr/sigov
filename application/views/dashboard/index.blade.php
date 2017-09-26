@extends('dashboard.templates.header')

@section('main')
    @if(isset($_SESSION['loginSucesso']))
        <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>SIGov 1.0 </strong><br><a href="#" class="alert-link">{{ $_SESSION['loginSucesso'] }}</a>
        </div>
    @endif

@endsection