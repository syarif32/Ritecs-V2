@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-start">
    <div class="col-12 col-md-6">
      <h2 class="page-title">Add Category</h2>
      <div class="card shadow mb-4">
        <div class="card-body">
          
        <form id="categoryForm" action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div id="category-fields">
                <label for="name">Category Name</label>
                <div class="form-group">
                    
                    @if(session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session('warning') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                        @endif

                        @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    <div class="row p-0 m-0 g-2">
                        <div class="col-12 col-md-10 px-0 py-1 p-md-0 pr-md-3">
                            <input type="text" class="form-control" name="names[]" required>
                        </div>
                        <div class="col-12 col-md-2 p-0 m-0">
                            <button type="button" class="btn btn-outline-primary w-100" onclick="addField(event)">+1 item</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('admin.categories') }}" class="btn btn-secondary">Cancel</a>
        </form>

        <script>
            function addField(e) {
                e.preventDefault();
                let div = document.createElement('div');
                div.classList.add('form-group');
                div.innerHTML = `
                    <div class="row p-0 m-0 g-2">
                        <div class="col-12 col-md-10 px-0 py-1 p-md-0 pr-md-3">
                            <input type="text" class="form-control" name="names[]" required>
                        </div>
                        <div class="col-12 col-md-2 p-0 m-0">
                            <button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.form-group').remove()">Delete</button>
                        </div>
                    </div>
                `;
                document.getElementById('category-fields').appendChild(div);
            }

            // Cek duplikat sebelum submit
            document.getElementById('categoryForm').addEventListener('submit', function(e) {
                let inputs = document.querySelectorAll('input[name="names[]"]');
                let values = [];
                let duplicate = false;

                inputs.forEach(input => {
                    let val = input.value.trim().toLowerCase();
                    if (values.includes(val)) {
                        duplicate = true;
                        // kasih popover
                        $(input).attr("data-toggle", "popover")
                            .attr("data-placement", "bottom")
                            .attr("data-content", "Kategori duplikat!")
                            .popover("show");
                    } else {
                        values.push(val);
                        $(input).popover("dispose"); // hapus kalau sudah oke
                    }
                });

                if (duplicate) {
                    e.preventDefault(); // stop submit
                }
            });
        </script>


            
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
