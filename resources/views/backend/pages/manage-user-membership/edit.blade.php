@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-start">
    <div class="col-12 col-lg-10 col-xl-8">
      <h2 class="h3 mb-4 page-title">Edit Membership</h2>

      <div class="card shadow mb-4">
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
          
          
            {{-- Info tipe membership yang sedang diedit --}}
            @if($membership->user_id)
                <div class="alert alert-info">
                    <b>Membership ini adalah User.</b><br>
                    Membership ini saat ini terhubung ke user:
                    <u>{{ $membership->user->full_name ?? $membership->user->email }}</u>.
                    <br>Anda dapat mengganti relasi melalui dropdown User, namun membutuhkan proses konfirmasi.
                    <br>
                    <button type="button" class="btn btn-danger btn-sm mt-2" data-toggle="modal" data-target="#modalConvertToGuest">
                        Ubah Menjadi Guest
                    </button>
                </div>
            @else
                <div class="alert alert-warning">
                    <b>Membership ini adalah Guest.</b><br>
                    Anda dapat merelasikan membership guest ini ke user yang sudah terdaftar melalui dropdown <b>User</b> di bawah.
                </div>
            @endif
          
          <form id="mainForm" action="{{ route('admin.manageUserMemberships.update', $membership->membership_id) }}" method="POST">
            @csrf
            {{-- hidden --}}
            <input type="hidden" name="membership_action" id="membership_action" value="">
            <input type="hidden" name="selected_user_id" id="selected_user_id" value="{{ old('selected_user_id', $membership->user_id ?? '') }}">
            <input type="hidden" name="guest_email_original" value="{{ old('guest_email', $membership->guest_email) }}">

            <div class="row">
              {{-- Select user (optional) --}}
              <div class="col-md-12 mb-3">
                <label>User (opsional — memilih user akan merelasikan membership guest ke user tersebut)</label>
                <select id="user_select" name="user_id" class="form-control" @if($membership->user_id) disabled @endif>
                  <option value="">-- Tidak pilih / Tambah guest baru --</option>
                  @foreach($users as $u)
                    <option value="{{ $u->user_id }}"
                        data-first_name="{{ e($u->first_name) }}"
                        data-last_name="{{ e($u->last_name) }}"
                        data-email="{{ e($u->email) }}"
                        data-institution="{{ e($u->institution) }}"
                        {{ ($membership->user_id && $membership->user_id == $u->user_id) ? 'selected' : '' }}>
                      {{ $u->full_name ?: $u->email }}
                    </option>
                  @endforeach
                </select>

                <small class="form-text text-muted">
                  @if($membership->user_id)
                    Saat ini ter-relasi ke user. Untuk mengganti relasi harus melalui proses konfirmasi.
                  @else
                    Jika Anda memilih user di sini, maka membership ini
                    <b>akan dihubungkan (relasi) ke user tersebut</b> setelah proses konfirmasi.
                    Jika dikosongkan, membership tetap menjadi <b>guest</b>.
                  @endif
                </small>

              </div>

              {{-- visible fields for personal data (fill when user selected OR editable when not) --}}
              <div class="col-md-6 mb-3">
                <label>First Name</label>
                <input type="text" id="guest_first_name" name="guest_first_name" class="form-control" value="{{ old('guest_first_name', $membership->guest_first_name) }}">
              </div>
              <div class="col-md-6 mb-3">
                <label>Last Name</label>
                <input type="text" id="guest_last_name" name="guest_last_name" class="form-control" value="{{ old('guest_last_name', $membership->guest_last_name) }}">
              </div>

              <div class="col-md-6 mb-3">
                  <label>Email</label>
                  <input type="email" id="guest_email" name="guest_email" class="form-control @error('guest_email') is-invalid @enderror"
                         value="{{ old('guest_email', $membership->guest_email) }}">
                  <small class="form-text text-muted">Pastikan email uniq/belum digunakan. Jika email bentrok dengan user lain, akan muncul konfirmasi.</small>
                  @error('guest_email')
                      <small class="text-danger d-block">{{ $message }}</small>
                  @enderror
                </div>

              <div class="col-md-6 mb-3">
                <label>Institution</label>
                <input type="text" id="guest_institution" name="guest_institution" class="form-control" value="{{ old('guest_institution', $membership->guest_institution) }}">
              </div>
              
              <div class="col-md-6 mb-3">
                  <label>Member Number</label>
                  <input type="text" name="member_number" class="form-control @error('member_number') is-invalid @enderror" 
                         value="{{ old('member_number', $membership->member_number) }}" required>
                  @error('member_number')
                      <small class="text-danger d-block">{{ $message }}</small>
                  @enderror
                </div>

              <div class="col-md-6 mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                  <option value="1" {{ old('status', $membership->status) == 1 ? 'selected' : '' }}>Active</option>
                  <option value="0" {{ old('status', $membership->status) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
              </div>

              <div class="col-md-6 mb-3">
                <label>Start Date</label>
                <input type="date" class="form-control" name="start_date" value="{{ old('start_date', $membership->start_date) }}" required>
              </div>
              <div class="col-md-6 mb-3">
                <label>End Date</label>
                <input type="date" class="form-control" name="end_date" value="{{ old('end_date', $membership->end_date) }}" required>
              </div>
              
            </div>

            <button class="btn btn-primary" type="submit">Update</button>
            <a href="{{ route('admin.manageUserMemberships.index') }}" class="btn btn-secondary">Cancel</a>

          </form>
        </div>
      </div>

    </div>
  </div>
</div>

{{-- Modal 1 – Konfirmasi email bentrok --}}
{{-- Tampilkan modal hanya saat session menyatakan ada konflik dan ada objek user conflict_user --}}
@if(session('membership_email_conflict') && session('conflict_user'))
  @php $u = session('conflict_user'); @endphp

  <div class="modal fade" id="modalConflict" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Email Sudah Terdaftar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeConflictModal()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          Email yang Anda masukkan sudah digunakan oleh  
          <b>{{ $u?->full_name ?: ($u?->email ?? '-') }}</b> ({{ $u?->email ?? '-' }}).
          Pilih tipe membership yang ingin dibuat.

          {{-- Tambahan peringatan jika user sudah punya membership --}}
          @if($u?->membership)
            <div class="alert alert-warning mt-3 mb-0">
              ⚠ User ini sudah memiliki membership aktif / terdaftar.<br>
              Tidak dapat dilakukan <b>Relasi User</b>.
            </div>
          @endif
        </div>

        <div class="modal-footer">
          
          {{-- Tombol Relasi User dinonaktifkan jika user sudah punya membership --}}
          <button
            type="button"
            class="btn btn-primary"
            id="btnRelateUser"
            @if($u?->membership) disabled style="pointer-events:none; opacity:.6;" @endif
          >Relasi User</button>

          <button type="button" class="btn btn-warning" id="btnGuestForce">Guest Member</button>
          <button type="button" class="btn btn-secondary" id="btnCancelAction">Batal</button>
        </div>

      </div>
    </div>
  </div>
@endif

{{-- Modal Preview User (pop-up konfirmasi sebelum men-submit relasi) --}}
<div class="modal fade" id="modalPreviewUser" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Relasi User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closePreviewModal()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Membership akan ditambahkan ke user berikut:</p>
        <table class="table table-bordered">
          <tr><th>Nama</th><td id="preview_name">-</td></tr>
          <tr><th>Email</th><td id="preview_email">-</td></tr>
          <tr><th>Institusi</th><td id="preview_institution">-</td></tr>
        </table>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" id="btnConfirmRelate">Konfirmasi Tambahkan</button>
        <button class="btn btn-secondary" data-dismiss="modal" onclick="closePreviewModal()">Batal</button>
      </div>
    </div>
  </div>
</div>


@if($membership->user_id)
<div class="modal fade" id="modalConvertToGuest" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title">Konfirmasi Ubah ke Guest</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <div class="modal-body">
        <p>
          Anda akan mengubah membership ini menjadi <b>Guest Membership</b>.
        </p>

        <div class="alert alert-warning">
          <b>Konsekuensi:</b>
          <ul class="mb-0">
            <li>Relasi ke user <u>{{ $membership->user->email }}</u> akan dilepas.</li>
            <li>Data user tersebut tidak akan berubah / terhapus.</li>
            <li>Field <code>user_id</code> pada membership ini akan dihapus (null).</li>
            <li>Anda harus memastikan field guest (nama, email, dll) sudah benar.</li>
          </ul>
        </div>

        <p>Lanjutkan?</p>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>

        {{-- Button konfirmasi --}}
        <button class="btn btn-danger" id="btnConfirmConvertToGuest">
          Ya, Ubah ke Guest
        </button>
      </div>

    </div>
  </div>
</div>
@endif


@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ELEMENTS
    const select = document.getElementById('user_select');
    const first = document.getElementById('guest_first_name');
    const last  = document.getElementById('guest_last_name');
    const email = document.getElementById('guest_email');
    const inst  = document.getElementById('guest_institution');
    const mainForm = document.getElementById('mainForm');
    const hAction = document.getElementById('membership_action');
    const hSelectedUser = document.getElementById('selected_user_id');

    // helper: isi/lock fields saat user dipilih dari dropdown
    function fillFromOption(opt) {
        if (!opt) return;
        const fn  = opt.getAttribute('data-first_name') || '';
        const ln  = opt.getAttribute('data-last_name') || '';
        const em  = opt.getAttribute('data-email') || '';
        const ins = opt.getAttribute('data-institution') || '';

        if (opt.value) {
            first.value = fn;
            last.value  = ln;
            email.value = em;
            inst.value  = ins;

            first.readOnly = true;
            last.readOnly  = true;
            email.readOnly = true;
            inst.readOnly  = true;
        } else {
            if (!first.value) first.value = '';
            if (!last.value)  last.value  = '';
            if (!email.value) email.value = '';
            if (!inst.value)  inst.value  = '';

            first.readOnly = false;
            last.readOnly  = false;
            email.readOnly = false;
            inst.readOnly  = false;
        }
    }

    // Inisialisasi dropdown
    if (select) {
        fillFromOption(select.options[select.selectedIndex]);
        select.addEventListener('change', function () {
            fillFromOption(this.options[this.selectedIndex]);
            hSelectedUser.value = '';
            hAction.value = '';
        });
    }

    // ---------- FORM SUBMIT ----------
    mainForm.addEventListener('submit', function () {
        hAction.value = 'check_conflict';
    });


    // ---------- HANDLERS FOR MODAL CONFLICT ----------
    @if(session('membership_email_conflict') && session('conflict_user'))
        const conflictUser = @json(session('conflict_user'));

        $(function(){ $('#modalConflict').modal('show'); });

        // Fungsi ensure preview lengkap (matching email -> user_select)
        function loadFullUserDataToPreview(conflictObj) {
            let previewName = conflictObj.full_name ?? '';
            let previewEmail = conflictObj.email ?? '';
            let previewInstitution = conflictObj.institution ?? '';

            // jika ada email → cocokkan ke dropdown untuk ambil data lengkap
            if (previewEmail && select) {
                for (let opt of select.options) {
                    if (opt.getAttribute('data-email') === previewEmail) {
                        previewName = (opt.getAttribute('data-first_name') || '') + ' ' + (opt.getAttribute('data-last_name') || '');
                        previewInstitution = opt.getAttribute('data-institution') || previewInstitution;
                        break;
                    }
                }
            }

            document.getElementById('preview_name').innerText = previewName || '-';
            document.getElementById('preview_email').innerText = previewEmail || '-';
            document.getElementById('preview_institution').innerText = previewInstitution || '-';
        }


        document.getElementById('btnRelateUser').addEventListener('click', function () {
            hSelectedUser.value = conflictUser.user_id ?? '';
            loadFullUserDataToPreview(conflictUser);   // ⬅ memastikan preview lengkap
            $('#modalConflict').modal('hide');
            $('#modalPreviewUser').modal('show');
        });

        document.getElementById('btnGuestForce').addEventListener('click', function () {
            hAction.value = 'guest_force';
            hSelectedUser.value = '';
            mainForm.submit();
        });

        document.getElementById('btnCancelAction').addEventListener('click', function () {
            hAction.value = 'cancel';
            hSelectedUser.value = '';
            mainForm.submit();
        });
    @endif


    // ---------- HANDLERS PREVIEW MODAL ----------
    const btnConfirmRelate = document.getElementById('btnConfirmRelate');
    if (btnConfirmRelate) {
        btnConfirmRelate.addEventListener('click', function () {
            if (!hSelectedUser.value) {
                alert('Tidak ada user yang dipilih. Silakan ulangi proses relasi.');
                $('#modalPreviewUser').modal('hide');
                return;
            }
            hAction.value = 'user_relation';
            mainForm.submit();
        });
    }
    
    // ----- Convert to Guest -----
    const btnConvert = document.getElementById('btnConfirmConvertToGuest');
    if (btnConvert) {
        btnConvert.addEventListener('click', function () {
            document.getElementById('membership_action').value = 'convert_to_guest';
            document.getElementById('selected_user_id').value = '';
            $('#modalConvertToGuest').modal('hide');
            document.getElementById('mainForm').submit();
        });
    }


    $('#modalPreviewUser').on('hidden.bs.modal', function () {
        if (hAction.value !== 'user_relation') {
            hSelectedUser.value = '';
            hAction.value = '';
            if (select) {
                select.value = '';
                fillFromOption(select.options[select.selectedIndex]);
            }
        }
    });

    window.closePreviewModal = function() {
        $('#modalPreviewUser').modal('hide');
    };

    window.closeConflictModal = function() {
        $('#modalConflict').modal('hide');
    };

}); // DOMContentLoaded
</script>
@endpush
