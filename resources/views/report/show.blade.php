@extends('layouts.app_auth')

@section('content')
<div class="col-md-6">
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Employee Data</h3>
    </div>    
    <div class="card-body">
      <div class="table-wrap">
            <!-- <h3>Employee Data</h3> -->
            <table id="report_list" class="table table-bordered table-striped table-custom">
               
                <tbody>
                    <tr>
                        <td>Name</td><td>{{ ($report->user) ? $report->user->name : ''  }}</td>
                    </tr>
                    <tr>
                        <td>Employee Id</td><td>{{ $report->user ? $report->user->emp_id : '' }}</td>
                    </tr>
                    <tr>
                        <td>Year</td><td>{{ $report->year }}</td>
                    </tr>
                    <tr>
                        @php
                            $month = date('F',mktime(0,0,0,$report->month,10));
                        @endphp
                        <td>Month</td><td>{{ $month }}</td>
                    </tr>
                    <tr>
                        <td>Admin Ratings</td><td>{{ $report->admin_points }}</td>
                    </tr>
                    <tr>
                        <td>HR Ratings</td><td>{{ $report->hr_points }}</td>
                    </tr>
                    <tr>
                        <td>Admin Deduct Points</td><td>{{ $report->admin_deduct_points }}</td>
                    </tr>
                    <tr>
                        <td>Average</td><td>{{ $report->avg_points }}</td>
                    </tr>
                    <tr>
                        <td>Admin Remarks</td><td>{{ $report->admin_remarks }}</td>
                    </tr>
                    <tr>
                        <td>HR Remarks</td><td>{{ $report->hr_remarks }}</td>
                    </tr>
                </tbody>
            </table>
        </div>      
        <div class="table-wrap">
            <h3> Last six months rating details</h3>
            <table id="report_list" class="table table-bordered table-striped table-custom table-responsive">
                <thead>
                    <tr>
                        <th>Year</th>
                        <th>Month</th>
                        <th>Admin Ratings</th>
                        <th>Hr Ratings</th>
                        <th>Avarage Ratings</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($points as $point)
                    <tr>
                        <td>{{ $point->year}}</td>
                        @php
                            $month = date('F',mktime(0,0,0,$point->month,10));
                        @endphp
                        <td>{{ $month}}</td>
                        <td>{{ $point->admin_points}}</td>
                        <td>{{ $point->hr_points}}</td>
                        <td>{{ $point->avg_points}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>
@endsection