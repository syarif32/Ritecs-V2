<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row justify-content-start">
    <div class="col-12 col-lg-10 col-xl-8">
      <h2 class="h3 mb-4 page-title">Add Membership</h2>

      <div class="card shadow mb-4">
        <div class="card-body">
            
         
          <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <?php echo e(session('success')); ?>

              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
          <?php endif; ?>

          
          <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <?php echo e(session('error')); ?>

              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
          <?php endif; ?>

          
          <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
          <?php endif; ?>


          <!-- FORM yang sudah diberi id mainForm -->
          <form id="mainForm" action="<?php echo e(route('admin.manageUserMemberships.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            
            <input type="hidden" name="membership_action" id="membership_action" value="">
            <input type="hidden" name="selected_user_id" id="selected_user_id" value="">
            <input type="hidden" name="guest_email_original" value="<?php echo e(old('guest_email')); ?>">

            <div class="row">
              
              <div class="col-md-12 mb-3">
                <label>User (optional — pilih jika user sudah terdaftar)</label>
                <select id="user_select" name="user_id" class="form-control">
                  <option value="">-- Tidak pilih / Tambah guest baru --</option>
                  <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($u->user_id); ?>"
                        data-first_name="<?php echo e(e($u->first_name)); ?>"
                        data-last_name="<?php echo e(e($u->last_name)); ?>"
                        data-email="<?php echo e(e($u->email)); ?>"
                        data-institution="<?php echo e(e($u->institution)); ?>">
                      <?php echo e($u->full_name ?: $u->email); ?>

                    </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <small class="form-text text-muted">Pilih User yang terdaftar</small>
              </div>

              
              <div class="col-md-6 mb-3">
                <label>First Name</label>
                <input type="text" id="guest_first_name" name="guest_first_name" class="form-control" value="<?php echo e(old('guest_first_name')); ?>">
              </div>
              <div class="col-md-6 mb-3">
                <label>Last Name</label>
                <input type="text" id="guest_last_name" name="guest_last_name" class="form-control" value="<?php echo e(old('guest_last_name')); ?>">
              </div>

              <div class="col-md-6 mb-3">
                  <label>Email</label>
                  <input type="email" id="guest_email" name="guest_email" class="form-control <?php $__errorArgs = ['guest_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                         value="<?php echo e(old('guest_email')); ?>">
                  <small class="form-text text-muted">Pastikan email uniq/belum digunakan.</small>
                  <?php $__errorArgs = ['guest_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                      <small class="text-danger d-block"><?php echo e($message); ?></small>
                  <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

              <div class="col-md-6 mb-3">
                <label>Institution</label>
                <input type="text" id="guest_institution" name="guest_institution" class="form-control" value="<?php echo e(old('guest_institution')); ?>">
              </div>
              
              <div class="col-md-6 mb-3">
                  <label>Member Number</label>
                  <input type="text" name="member_number" class="form-control <?php $__errorArgs = ['member_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                         value="<?php echo e(old('member_number')); ?>" required>
                  <?php $__errorArgs = ['member_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                      <small class="text-danger d-block"><?php echo e($message); ?></small>
                  <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

              <div class="col-md-6 mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                  <option value="1" <?php echo e(old('status','1') == '1' ? 'selected' : ''); ?>>Active</option>
                  <option value="0" <?php echo e(old('status') == '0' ? 'selected' : ''); ?>>Inactive</option>
                </select>
              </div>

              <div class="col-md-6 mb-3">
                <label>Start Date</label>
                <input type="date" class="form-control" name="start_date" value="<?php echo e(old('start_date', now()->format('Y-m-d'))); ?>" required>
              </div>
              <div class="col-md-6 mb-3">
                <label>End Date</label>
                <input type="date" class="form-control" name="end_date" value="<?php echo e(old('end_date', now()->addYear()->format('Y-m-d'))); ?>" required>
              </div>
              
            </div>

            <button class="btn btn-primary" type="submit">Save</button>
            <a href="<?php echo e(route('admin.manageUserMemberships.index')); ?>" class="btn btn-secondary">Cancel</a>

          </form>
        </div>
      </div>

    </div>
  </div>
</div>


<?php if(session('membership_email_conflict') && session('conflict_user')): ?>
  <?php $u = session('conflict_user'); ?>

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
          <b><?php echo e($u?->full_name ?: ($u?->email ?? '-')); ?></b> (<?php echo e($u?->email ?? '-'); ?>).
          Pilih tipe membership yang ingin dibuat.

          
          <?php if($u?->membership): ?>
            <div class="alert alert-warning mt-3 mb-0">
              ⚠ User ini sudah memiliki membership aktif / terdaftar.<br>
              Tidak dapat dilakukan <b>Relasi User</b>.
            </div>
          <?php endif; ?>
        </div>

        <div class="modal-footer">
          
          
          <button
            type="button"
            class="btn btn-primary"
            id="btnRelateUser"
            <?php if($u?->membership): ?> disabled style="pointer-events:none; opacity:.6;" <?php endif; ?>
          >Relasi User</button>

          <button type="button" class="btn btn-warning" id="btnGuestForce">Guest Member</button>
          <button type="button" class="btn btn-secondary" id="btnCancelAction">Batal</button>
        </div>

      </div>
    </div>
  </div>
<?php endif; ?>


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

<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
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
    <?php if(session('membership_email_conflict') && session('conflict_user')): ?>
        const conflictUser = <?php echo json_encode(session('conflict_user'), 15, 512) ?>;

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
    <?php endif; ?>


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
<?php $__env->stopPush(); ?>


<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/backend/pages/manage-user-membership/create.blade.php ENDPATH**/ ?>