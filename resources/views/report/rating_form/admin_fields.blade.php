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
      <h3 class="card-title">Admin Points</h3>
    </div>    
    <div class="card-body">
      @if($pfmreport)
        <form class="form-horizontal" action="{{ route('report.update',$pfmreport->id) }}" id="multistep_admin_form" method="post">  
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
              
              @foreach($admin_fields as $field)
                @php $id = $field['id'] @endphp

                <label for="">{{ $field['name'] }}</label>
                <select name="admin_ratings[{{ $field['id'] }}]" id="" class="admin-ratings">
                  <option value="">Select Value</option>
                    @for($i=1;$i<=10;$i++)
                      <option value="{{$i}}" {{ $i == $field['value'] ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
                </select>
              @endforeach

              {{-- @error('admin_fields.'.$id) --}}
                <div class="text-danger rating-error" style="display:none">
                  Plaese Select a Value
                </div>
              {{-- @enderror --}}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="">Deduction Points</label>
              <select name="deduct_points" id="">
                @for($i=0; $i <= $deduction_points; $i++)
                  <option value="{{ $i }}" {{ $pfmreport && $pfmreport->admin_deduct_points == $i ? 'selected' : ''}}>{{ $i }}</option>
                @endfor
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>Admin Remarks</label>
              <textarea class="form-control" rows="3" name="admin_remarks" placeholder="Enter ...">{{ $pfmreport ? $pfmreport->admin_remarks : '' }}</textarea>
            </div>
          </div>
        </div>
        <input type="submit" name="Submit" class="btn btn-primary">
        @if(!(request()->is('report/admin-info')))
          <a href="{{ route('performance.hrinfo',$pfmreport->id) }}" class="btn btn-primary">Hr Rating</a>
        @endif
      </form>
    </div>
  </div>
</div>
@endsection
@section('script')
    <script>
    $(function(){
        $('#multistep_admin_form').on('submit', function() {
            let error = 0;
            $('[name*="admin_ratings"]').each(function(el, item) {
                if(!$(this).val()) {
                    $(this).addClass('is-invalid')
                    $(this).parent().find('.rating-error').show()
                    error++;
                } else {
                    $(this).removeClass('is-invalid')
                    $(this).parent().find('.rating-error').hide()
                }
            });
            if(!error) {
                return true;
            } else {
                return false;
            }
        })
    });
    </script>
@endsection