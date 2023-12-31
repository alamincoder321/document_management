@extends('layouts.backend_master')
@section('title', 'Dashboard')
@section('bread_crumb_title', 'Dashboard')
@section('bread_crumb_subtitle')
Dashboard-
@if(session()->has('branch'))
{{session()->get('branch')->title}}
@endif
@endsection

@section('content')

<!-- Title Count Start -->
<div class="card-group">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex no-block align-items-center">
                        <div>
                            <div class="icon"><i class="lni-display"></i></div>
                            <p class="text-muted">New Clients</p>
                        </div>
                        <div class="ml-auto">
                            <h2 class="counter text-primary">234</h2>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="progress">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex no-block align-items-center">
                        <div>
                            <div class="icon"><i class="lni-pencil-alt"></i></div>
                            <p class="text-muted">Total Projects</p>
                        </div>
                        <div class="ml-auto">
                            <h2 class="counter text-success">1,390</h2>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex no-block align-items-center">
                        <div>
                            <div class="icon"><i class="lni-empty-file"></i></div>
                            <p class="text-muted">Pending Invoices</p>
                        </div>
                        <div class="ml-auto">
                            <h2 class="counter text-info">5,723</h2>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="progress">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex no-block align-items-center">
                        <div>
                            <div class="icon"><i class="lni-cart"></i></div>
                            <p class="text-muted">All Projects</p>
                        </div>
                        <div class="ml-auto">
                            <h2 class="counter text-purple">2,396</h2>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="progress">
                        <div class="progress-bar bg-purple" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Title Count End -->

<div class="row">
    <div class="col-12">
        <ul>
            @foreach($users as $user)
            <li>{{$user->name}}</li>
            @endforeach
        </ul>
    </div>
</div>

@endsection