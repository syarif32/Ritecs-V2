@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-8">

      <h2 class="page-title">Edit Bank</h2>

      <div class="card shadow">
        <div class="card-body">
          <form method="POST" action="{{ route('admin.banks.update',$bank->bank_id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label>Bank Name</label>
              <input type="text" name="bank_name" class="form-control" value="{{ $bank->bank_name }}" required>
            </div>
            <div class="form-group">
              <label>Account Name</label>
              <input type="text" name="account_name" class="form-control" value="{{ $bank->account_name }}" required>
            </div>
            <div class="form-group">
              <label>Account Number</label>
              <input type="text" name="account_number" class="form-control" value="{{ $bank->account_number }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.banks.index') }}" class="btn btn-secondary">Cancel</a>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
