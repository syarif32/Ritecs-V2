@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <h2 class="page-title">Book Data</h2>
      <p class="card-text">DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool for advanced table features.</p>
      
      <a href="{{ route('admin.create-books') }}" type="button" class="btn btn-primary pt-2 mb-3">
        <span class="fe fe-file-plus fe-16 mr-2"></span>Add Book
      </a>

      <div class="row my-4">
        <div class="col-md-12">
          <div class="card shadow">
            <div class="card-body">
              
              @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
              </div>
              @endif

              <table class="table datatables" id="dataTable-1">
                <thead>
                  <tr>
                    <th>Cover</th>
                    <th>Title</th>
                    <th>Writer</th>
                    <th>Category</th>
                    <th>Publisher</th>
                    <th>Pages</th>
                    <th>W x L x T</th>
                    <th>ISBN</th>
                    <th>Ebook Path</th>
                    <th>Print Price</th>
                    <th>Ebook Price</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($books as $book)
                  <tr>
                    <td>
                      <a href="{{ asset($book->cover_path) }}" target="_blank">
                        <div class="avatar avatar-sm">
                          <img src="{{ asset($book->cover_path) }}" class="avatar-img rounded object-fit-cover">
                        </div>
                      </a>
                    </td>
                    <td class="small">{{ $book->title }}</td>
                    <td class="small">
                     @if($book->writers->count() > 0)
                        @foreach($book->writers as $index => $writer)
                          {{ $index + 1 }}. {{ $writer->name }}{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                      @else
                        <span class="text-muted">-</span>
                      @endif
                    </td>
                    <td class="small">
                      {{ $book->categories->pluck('name')->implode(', ') }}
                    </td>
                    <td class="small">{{ $book->publisher }}</td>
                    <td class="small">{{ $book->pages }}</td>
                    <td class="small">
                      @if($book->width || $book->length || $book->thickness)
                        {{ $book->width ?? '-' }} x {{ $book->length ?? '-' }} x {{ $book->thickness ?? '-' }} cm
                      @endif
                    </td>
                    <td class="small">{{ $book->isbn }}</td>
                    <td class="small">
                      @if($book->ebook_path)
                        <a href="{{ $book->ebook_path }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 150px;">{{ $book->ebook_path }}</a>
                      @endif
                    </td>
                    <td class="small">
                      @if($book->print_price) Rp. {{ number_format($book->print_price, 0, ',', '.') }} @endif
                    </td>
                    <td class="small">
                      @if($book->ebook_price) Rp. {{ number_format($book->ebook_price, 0, ',', '.') }} @endif
                    </td>
                    <td>
                      <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="text-muted sr-only">Action</span>
                      </button>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('admin.edit-books', $book->book_id) }}">Edit</a>
                        <a class="dropdown-item" 
                          href="{{ route('admin.delete-books', $book->book_id) }}" 
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
        </div> 
      </div>
    </div>
  </div>
</div>
@endsection