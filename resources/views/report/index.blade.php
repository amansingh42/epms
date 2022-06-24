@extends('layouts.app_auth')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Reports</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Emp id</th>
                                    <th>Name</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Admin Rating</th>
                                    <th>Hr Rating</th>
                                    <th>Total Rating</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($reports as $report): ?>
                                    <tr>
                                        <td>{{ $report->user->emp_id }}</td>
                                        <td>{{ $report->user->name }}</td>
                                        <td>{{ $report->month }}</td>
                                        <td>{{ $report->year }}</td>
                                        <td>{{ $report->admin_points }}</td>
                                        <td>{{ $report->hr_points }}</td>
                                        <td>{{ $report->avg_points}} %</td>
                                        <td>
                                            <a href="{{ route('report.show',$report->id)}}" class="btn btn-primary float-left" style="margin-right:.5%">Show</a>
                                            <a href="{{ route('report.edit',$report->id) }}" class="btn btn-info float-left" style="margin-right:.5%">Edit</a>
                                            
                                            <form method="post" action="{{ route('report.destroy',$report->id)}}"> 
                                                {{ csrf_field() }} @method('DELETE')
                                                <input type="submit" class="btn btn-danger" onclick="return confirm('Do you want to Delete this Report ?');" value="Delete">
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="">
                            {{ $reports->links()}}
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
    <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
@endsection