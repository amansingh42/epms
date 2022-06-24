@extends('layouts.app_auth')

@section('content')

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Users</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach($users as $user): ?>
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->id != auth()->user()->id)
                                  <a href="{{ route('user.edit',$user->id) }}" class="btn btn-info float-left" style="margin-right:.5%">Edit</a>
                                  
                                  <form method="post" action="{{ route('user.destroy',$user->id)}}"> 
                                      {{ csrf_field() }} @method('DELETE')
                                      <input type="submit" value="Delete" onclick="return confirm('Do you want to Delete this User ?');" class="btn btn-danger">
                                  </form>
                                @endif
                            </td>
                        </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                <div class="">
                    {{ $users->links()}}
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