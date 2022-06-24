@extends('layouts.app_auth')

@section('content')
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
<div class="col-md-6">
  <div class="card card-warning">
    <div class="card-header">
      <h3 class="card-title">Hr Points</h3>
    </div>    
    <div class="card-body">
      @if($pfmreport)
        <form class="form-horizontal" action="{{ route('report.update.hrinfo',$pfmreport->id) }}" id="multistep_admin_form" method="post">  
      @else
        <form class="form-horizontal" action="{{ route('report.store') }}" id="multistep_admin_form" method="post">              
      @endif

        @if($pfmreport)
          @method('PATCH') 
        @endif
        @csrf

        <input type="hidden"  name="employee_id" value="{{ $emp ? $emp->id : '' }}">

        <div class="row ">
          <div class="col-sm-6">
            <!-- text input -->
            <div class="form-group">
              @foreach($hr_fields as $field)
                @php $id = $field['id'] @endphp

                <label for="">{{ $field['name'] }}</label>
                <select name="hr_ratings[{{ $field['id'] }}]" id="">
                    @for($i=1;$i<=10;$i++)
                      <option value="{{$i}}" {{ $i == $field['value'] ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
                </select>
              @endforeach
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <!-- textarea -->
            <div class="form-group">
              <label>Hr Remarks</label>
              <textarea class="form-control" name="hr_remarks" rows="3" placeholder="Enter ..."></textarea>
            </div>
          </div>
        </div>
        <input type="submit" name="Submit" class="btn btn-primary">
      </form>
    </div>
  </div>
</div>
@endsection
