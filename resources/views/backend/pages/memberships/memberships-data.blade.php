@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <h2 class="page-title">Transactions</h2>
      <p class="card-text">List transaksi membership yang menunggu verifikasi admin.</p>

      <div class="row my-4">
        <div class="col-md-12">
          <div class="card shadow">
            <div class="card-body">

              {{-- Success Message --}}
              @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ session('success') }}
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
              @endif

              {{-- Error Message (umum) --}}
              @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{ session('error') }}
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
              @endif

              {{-- Validation Errors --}}
              @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
              @endif


              <table class="table datatables" id="dataTable-1">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Sender Name</th>
                    <th>Sender Bank</th>
                    <th>Destination</th>
                    <th>Proof</th>
                    <th>type</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($transactions as $tx)
                  <tr>
                    <td>{{ $tx->transaction_id }}</td>
                    <td>{{ $tx->user->full_name ?? '-' }}</td>
                    <td>Rp. {{ number_format($tx->amount, 0, ',', '.') }}</td>
                    <td>{{ $tx->sender_name }}</td>
                    <td>{{ $tx->sender_bank }}</td>
                    <td>{{ $tx->bank->bank_name ?? 'Bank name error' }} - {{ $tx->bank->account_number ?? 'Account number error' }}</td>
                    <td>
                      @if($tx->proof_path)
                        <a href="{{ asset($tx->proof_path) }}" target="_blank">
                          <img src="{{ asset($tx->proof_path) }}" style="max-width:50px;" class="rounded">
                        </a>
                      @endif
                    </td>
                    <td>
                      @if($tx->type === 'firstPayments')
                        <span class="pt-1 badge badge-pill badge-success">First Payments</span>
                      @elseif($tx->type === 'extendedPayments')
                        <span class="pt-1 badge badge-pill badge-primary">Extended Payments</span>
                      @else
                        <span class="pt-1 badge badge-pill badge-secondary">-</span>
                      @endif
                    </td>
                    <td>
                      @if($tx->status === 'paid')
                        <span class="pt-1 badge badge-pill badge-success h6">Paid</span>
                      @elseif($tx->status === 'pending')
                        <span class="pt-1 badge badge-pill badge-warning h6">Pending</span>
                      @elseif($tx->status === 'rejected')
                        <span class="pt-1 badge badge-pill badge-danger h6">Rejected</span>
                      @endif
                    </td>
                    <td>{{ $tx->created_at->format('d M Y H:i') }}</td>
                    <td>
                      <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="text-muted sr-only">Action</span>
                      </button>
                      <div class="dropdown-menu dropdown-menu-right">

                        @if($tx->type === 'extendedPayments')
                          <a class="dropdown-item"
                            href="{{ route('admin.memberships.edit', $tx->transaction_id) }}"
                            @if($tx->status === 'paid')
                                onclick="return confirm('Transaksi ini berstatus PAID. Mengubah data dapat menyebabkan inkonsistensi. Apakah Anda yakin ingin melanjutkan?')"
                            @endif
                          >
                            Edit
                          </a>

                          @if($tx->status === 'paid' && $tx->is_extended == 0)
                              <a class="dropdown-item text-success" 
                                href="{{ route('admin.memberships.extend', $tx->transaction_id) }}"
                                onclick="return confirm('Perpanjang masa aktif membership ini selama 1 tahun?')">
                                Perpanjang
                              </a>
                          @endif

                          <a class="dropdown-item text-danger" 
                            href="{{ route('admin.memberships.delete', $tx->transaction_id) }}"
                            onclick="return confirm('Yakin ingin menghapus transaksi ini?') && confirm('Menghapus transaksi akan menonaktifkan membership user. Lanjutkan?')">
                            Remove
                          </a>
                        @else
                            <a class="dropdown-item"
                              href="{{ route('admin.memberships.edit', $tx->transaction_id) }}"
                              @if($tx->status === 'paid')
                                  onclick="return confirm('Transaksi ini berstatus PAID. Mengubah data dapat menyebabkan inkonsistensi. Apakah Anda yakin ingin melanjutkan?')"
                              @endif
                            >
                              Edit
                            </a>

                            <a class="dropdown-item text-danger" 
                              href="{{ route('admin.memberships.delete', $tx->transaction_id) }}"
                              @if($tx->status === 'paid')
                                  onclick="return confirm('Yakin ingin menghapus transaksi ini?') && confirm('Menghapus data transaksi akan menangguhkan status membership user yang berjalan. Lanjutkan?')"
                              @else
                                  onclick="return confirm('Yakin ingin menghapus transaksi ini?') && confirm('Menghapus data transaksi akan menangguhkan status membership user yang berjalan. Lanjutkan?')"
                              @endif
                            >
                              Remove
                            </a>
                        @endif

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
