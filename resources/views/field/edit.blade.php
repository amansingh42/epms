@extends('layouts.app_auth')

@section('content')

    <div>
        @if($errors->any())
            @foreach($errors as $error)
                {{ $error }}
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
                                <h3 class="card-title">Edit User</h3>
                            </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                            <form method="post" action="{{ route('field.update',$field->id) }}">
                                {{ csrf_field() }}
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" value="{{old('name') == true ? old('name') : $field->name}}" name="name" placeholder="Enter Name">
                                    </div>
                                    <div class="form-group clearfix">
                                        <label for="">Status</label>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="radioPrimary1" name="status" value="1" {{ $field->status == 1 ? 'checked' : ''}}>
                                            <label for="radioPrimary1">
                                                Show
                                            </label>
                                        </div>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="radioPrimary2" value="0" name="status" {{ $field->status == 0 ? 'checked' : ''}}>
                                            <label for="radioPrimary2">
                                                Hide
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Roles</label>
                                        <select class="" style="width: 100%;" name="role">
                                            <option value="">Select a value</option>
                                            <?php foreach($roles as $role){ ?>
                                                <option value="{{ $role->id }}" {{ $role->id == $field->role_id ? 'selected' : ''}}>{{ $role->name }}</option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Designation</label>
                                        <select class="select2" name="desg[]" multiple="multiple" data-placeholder="Select Designations" style="width: 100%;">
                                            <?php foreach($designations as $desg){ ?>
                                                <option value="{{ $desg->id }}" {{ in_array($desg->id,explode(',',$field->designation_id)) ? 'selected' : ''}}>{{ $desg->name }}</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection