@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <h2 class="page-title">Verify Transaction</h2>
      <div class="row">
        <div class="col-md-8">
          <div class="card shadow mb-4">
            <div class="card-body position-relative">

              @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-2">
                  {{ session('success') }}
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
              @endif

              <form action="{{ route('admin.memberships.update', $transaction->transaction_id) }}" method="POST">
                @csrf
                <div class="form-row">

                  <div class="form-group col-12">
                    <label>User</label>
                    <input type="text" class="form-control" value="{{ $transaction->user->full_name ?? '-' }}" disabled>
                  </div>

                  <div class="form-group col-12">
                    <label>Amount</label>
                    <input type="text" class="form-control" value="Rp. {{ number_format($transaction->amount,0,',','.') }}" disabled>
                  </div>

                  <div class="form-group col-12">
                    <label>Sender Name</label>
                    <input type="text" class="form-control" value="{{ $transaction->sender_name }}" disabled>
                  </div>

                  <div class="form-group col-12">
                    <label>Sender Bank</label>
                    <input type="text" class="form-control" value="{{ $transaction->sender_bank }}" disabled>
                  </div>

                  <div class="form-group col-12">
                    <label>Destination</label>
                    <input type="text" class="form-control" value="{{ $transaction->bank->bank_name ?? 'Bank name error' }} - {{ $transaction->bank->account_number ?? 'Account number error' }}" disabled>
                  </div>

                  <div class="form-group col-12">
                    <label>Proof</label>
                    @if($transaction->proof_path)
                      <a href="{{ asset($transaction->proof_path) }}" target="_blank">
                        <img src="{{ asset($transaction->proof_path) }}" style="max-width:150px;" class="rounded">
                      </a>
                    @endif
                  </div>

                  <div class="form-group col-12">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                      <option value="pending" {{ $transaction->status==='pending'?'selected':'' }}>Pending</option>
                      <option value="paid" {{ $transaction->status==='paid'?'selected':'' }}>Paid</option>
                      <option value="rejected" {{ $transaction->status==='rejected'?'selected':'' }}>Rejected</option>
                    </select>
                  </div>

                  <div class="col-12 d-flex justify-content-start mt-3">
                      <button type="submit" class="btn btn-primary mr-2">Update Status</button>
                      <a href="{{ route('admin.memberships') }}" class="btn btn-secondary">Cancel</a>
                  </div>

                </div>
              </form>

            </div>
          </div>
        </div>
      </div> 
    </div>
  </div>
</div>
@endsection
