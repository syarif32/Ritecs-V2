<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row justify-content-start">
    <div class="col-12 col-lg-10 col-xl-8">
      <h2 class="h3 mb-4 page-title">Add Membership</h2>

      <div class="card shadow mb-4">
        <div class="card-body">
          <form action="<?php echo e(route('admin.manageUserMemberships.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="row">
              
              <div class="col-md-12 mb-3">
                <label>User (optional — pilih jika member sudah terdaftar)</label>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('user_select');
    const first = document.getElementById('guest_first_name');
    const last  = document.getElementById('guest_last_name');
    const email = document.getElementById('guest_email');
    const inst  = document.getElementById('guest_institution');

    function fillFromOption(opt) {
        if (!opt) return;
        const fn = opt.getAttribute('data-first_name') || '';
        const ln = opt.getAttribute('data-last_name') || '';
        const em = opt.getAttribute('data-email') || '';
        const ins = opt.getAttribute('data-institution') || '';

        if (opt.value) {
            // selected an existing user -> fill and make readonly
            first.value = fn;
            last.value  = ln;
            email.value = em;
            inst.value  = ins;

            first.readOnly = true;
            last.readOnly  = true;
            email.readOnly = true;
            inst.readOnly  = true;
        } else {
            // no user selected -> clear or keep old input and make editable
            // don't clear if user typed previously (keeps old input)
            if(!first.value) first.value = '';
            if(!last.value)  last.value  = '';
            if(!email.value) email.value = '';
            if(!inst.value)  inst.value  = '';

            first.readOnly = false;
            last.readOnly  = false;
            email.readOnly = false;
            inst.readOnly  = false;
        }
    }

    // initial fill (useful when redirect back with old inputs)
    fillFromOption(select.options[select.selectedIndex]);

    select.addEventListener('change', function(e) {
        fillFromOption(this.options[this.selectedIndex]);
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views\backend\pages\manage-user-membership\create.blade.php ENDPATH**/ ?>