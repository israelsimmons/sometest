@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <a class="btn btn-primary" href="/vuejs/list"><span style="font-size:2em" class="fab fa-vuejs"></span><br>Vuejs version</a>
                    <a class="btn btn-primary" href="/shares"><span style="font-size:2em" class="fab fa-laravel"></span> <br>Laravel version</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
