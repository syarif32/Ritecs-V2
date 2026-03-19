@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-8">

      <h2 class="page-title">Add Bank</h2>

      <div class="card shadow">
        <div class="card-body">
          <form method="POST" action="{{ route('admin.banks.store') }}">
            @csrf
            <div class="form-group">
              <label>Bank Name</label>
              <input type="text" name="bank_name" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Account Name</label>
              <input type="text" name="account_name" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Account Number</label>
              <input type="text" name="account_number" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('admin.banks.index') }}" class="btn btn-secondary">Cancel</a>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
