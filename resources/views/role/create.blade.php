@extends('layouts.app_auth')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Role</h3>
                        </div>
                        <form method="post" action="{{ route('role.store') }}">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                                </div>
                                <?php foreach($permissions as $permission) {?>
                                    <div class="form-check">
                                        <input name="permissions[]" id="perm-{{ $permission->id }}" value="{{ $permission->id }}" class="form-check-input" type="checkbox">
                                        <label class="form-check-label" for="perm-{{ $permission->id }}" >{{ $permission->name }}</label>
                                    </div>
                                <?php }?>
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
@endsection