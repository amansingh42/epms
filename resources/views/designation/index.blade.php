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
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach($designation as $des): ?>
                        <tr>
                            <td>{{ ucfirst($des->name) }}</td>
                            <td>
                                <a href="{{ route('designation.edit',$des->id) }}" class="btn btn-info float-left" style="margin-right:.5%">Edit</a>
                                
                                <form method="post" action="{{ route('designation.destroy',$des->id)}}"> 
                                    {{ csrf_field() }} @method('DELETE')
                                    <input type="submit" onclick="return confirm('Do you want to delete this designation ?');" class="btn btn-danger " value="Delete">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                <div class="">
                    {{ $designation->links()}}
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