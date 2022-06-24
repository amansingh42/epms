@extends('layouts.app_auth')

@section('content')
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Roles</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach($roles as $role): ?>
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>
                                <a href="{{ route('role.edit',$role->id) }}" style="margin-right:.5%" class="btn btn-info float-left">Edit</a>
                                
                                <form method="post" action="{{ route('role.destroy',$role->id)}}"> 
                                    {{ csrf_field() }} @method('DELETE')
                                    <input type="submit" class="btn btn-danger" onclick="return confirm('Do you want to Delete this Role ?');" value="Delete">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                <div class="">
                    {{ $roles->links()}}
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

@section('script')
@include('include.datatable-script')
@endsection