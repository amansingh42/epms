@extends('layouts.app_auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Welcome To Dashboard') }}</div>

                <div class="card-body">
                    <div class="row justify-content-center">
                       
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $data['user'] ? $data['user'] : 0 }}</h3>
                    
                                    <p>Total Users</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('user.create') }}" class="small-box-footer">
                                    Add More 
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $data['desg'] ? $data['desg'] : 0 }}</h3>
                    
                                    <p>Total Designation</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{ route('designation.create')}}" class="small-box-footer">
                                    Add More
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                       
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3>{{ $data['report'] ? $data['report'] : 0 }}</h3>                    
                                    <p>Total Reports</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('report.index')}}" class="small-box-footer">
                                    Show All 
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div> 
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
