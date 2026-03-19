@extends('backend.layouts.main')

@section('content')

        <div class="container-fluid">

          <div class="row justify-content-center">
            <div class="col-12">

              <h2 class="page-title">Journal Data</h2>
              <p class="card-text">DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool, built upon the foundations of progressive enhancement, that adds all of these advanced features to any HTML table. </p>
              <a href="{{ route('admin.create-journals') }}" type="button" class="btn btn-primary pt-2"><span class="fe fe-file-plus fe-16 mr-2"></span>Add Journal</a>

              <div class="row my-4">
                <!-- Small table -->
                <div class="col-md-12">
                  <div class="card shadow">
                    <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                      {{ session('success') }}
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                    @endif

                      <!-- table -->
                      <table class="table datatables" id="dataTable-1">
                        <thead>
                          <tr>
                            <th>Cover</th>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Url Path</th>
                            <th>Category</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          
                          @foreach($journals as $journal)
                            <tr>
                                <td>
                                  <a href="{{ asset($journal->cover_path) }}" target="_blank">
                                    <div class="avatar avatar-sm">
                                      <img src="{{ asset($journal->cover_path) }}" class="avatar-img rounded object-fit-cover">
                                    </div>
                                  </a>
                                </td>
                                <td>{{ $journal->journal_id }}</td>
                                <td>{{ $journal->title }}</td>
                                <td><a href="{{ $journal->url_path }}" target="_blank">{{ $journal->url_path }}</a></td>
                                <td>
                                    {{ $journal->keywords->pluck('name')->implode(', ') ?: '-' }}
                                </td>
                                <td>
                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="text-muted sr-only">Action</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                      <a class="dropdown-item" href="{{ route('admin.edit-journals', $journal->journal_id) }}">Edit</a>
                                      <a class="dropdown-item" 
                                        href="{{ route('admin.delete-journals', $journal->journal_id) }}" 
                                        onclick="return confirm('Yakin mau dihapus?')">Remove
                                      </a>

                                    </div>
                                </td>
                            </tr>
                          @endforeach

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div> <!-- simple table -->
              </div> <!-- end section -->
            </div> <!-- .col-12 -->
          </div> <!-- .row -->
        </div> 

@endsection