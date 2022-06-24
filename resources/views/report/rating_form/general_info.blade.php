@extends('layouts.app_auth')

@section('content')
  <section class="content">
    <div class="container-fluid">
      @include('include.session-message')
      @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">General Info</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form action="{{ route('performance.geninfo') }}" method="post">
                @csrf
                <div class="form-group">
                  <label for="">Name</label>
                  <select name="userid" id="">
                    @foreach($users as $user)
                      <option value="{{ $user->id }}">{{ $user->name }} ( {{ !empty($user->designationName) && $user->designationName->name != '' ? $user->designationName->name : '' }} )</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="">Year</label>
                  <select name="year" id="">
                    @for($i=2020; $i<= date('Y'); $i++)
                      <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                  </select>
                </div>
                <div class="form-group">
                  <label for="">Month</label>
                  <select name="month" id="">
                    @for($i=1;$i<=12;$i++)
                      @php
                        $month = date('F',mktime(0,0,0,$i));
                        $m = date('n');
                      @endphp
                      <option value="{{ $i }}" {{ $i > $m ? 'disabled' : '' }}>{{ $month }}</option>
                    @endfor
                  </select>
                </div>
                <div>
                  <input type="submit" name="Submit" class="btn btn-primary">
                </div>
              </form>
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