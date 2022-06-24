@extends('layouts.app_auth')

@section('content')

    <!-- <div>
        {{ __('Add User') }}
    </div> -->

<!-- <div class="content-wrapper"> -->
    @if($errors->any())
        @foreach($errors->all() as $err)
            {{ $err}}
        @endforeach
    @endif
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add User</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="{{ route('user.store') }}">
                  {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                  </div>
                  <div class="form-group">
                    <label for="Email">Email address</label>
                    <input type="email" class="form-control" id="Email" name="email" placeholder="Enter Email">
                  </div>
                  <div class="form-group">
                    <label for="Empid">Emp Id</label>
                    <input type="text" class="form-control" id="Empid" name="empid" placeholder="Enter Employee id">
                  </div>
                  <div class="form-group">
                    <label>Designation</label>
                    <select class="" name="designation" data-placeholder="Select Designations" style="width: 100%;">
                      <?php foreach($designations as $desg){?>    
                        <option value="{{ $desg->id }}">{{ $desg->name }}</option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Role</label>
                    <select class="" name="role" data-placeholder="Select Role" style="width: 100%;">
                      <?php foreach($roles as $role){?>    
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="Password">Password</label>
                    <input type="password" class="form-control" id="Password" name="password" placeholder="Password">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            </div>
            </div>
        </div>
    </section>
<!-- </div> -->
@endsection 