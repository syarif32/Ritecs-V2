
<?php $__env->startSection('title', 'System Maintenance | RITECS'); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800"> System Maintenance</h1>
        
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fe fe-alert-circle"></i> Gunakan fitur ini hanya ketika aplikasi Laravel terasa lambat atau terjadi kesalahan saat memuat halaman.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fe fe-check"></i> <?php echo e(session('success')); ?>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if(request('rebuild_status') == 'success'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fe fe-check"></i> Aplikasi berhasil dioptimalkan (rebuild cache).
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <div class="row">

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-3">
                    <div class="card-body text-center">
                        <i class="fe fe-sliders display-4 text-warning mb-3"></i>
                        <h5 class="font-weight-bold">Clear Config</h5>
                        <p class="text-muted small">Menghapus cache konfigurasi agar perubahan file & config terbaca ulang.</p>
                        <form action="<?php echo e(route('admin.maintenance.clear', 'config')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button class="btn btn-warning btn-sm"><i class="fe fe-refresh-cw"></i> Jalankan</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-3">
                    <div class="card-body text-center">
                        <i class="fe fe-map display-4 text-info mb-3"></i>
                        <h5 class="font-weight-bold">Clear Route</h5>
                        <p class="text-muted small">Menghapus cache routing jika terdapat eror pada halaman.</p>
                        <form action="<?php echo e(route('admin.maintenance.clear', 'route')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button class="btn btn-info btn-sm"><i class="fe fe-refresh-cw"></i> Jalankan</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-3">
                    <div class="card-body text-center">
                        <i class="fe fe-eye display-4 text-primary mb-3"></i>
                        <h5 class="font-weight-bold">Clear View</h5>
                        <p class="text-muted small">Menghapus cache blade jika terdapat eror saat render halaman.</p>
                        <form action="<?php echo e(route('admin.maintenance.clear', 'view')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button class="btn btn-primary btn-sm"><i class="fe fe-refresh-cw"></i> Jalankan</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-3">
                    <div class="card-body text-center">
                        <i class="fe fe fe-zap display-4 text-danger mb-3"></i>
                        <h5 class="font-weight-bold">Clear Optimize</h5>
                        <p class="text-muted small">Menghapus semua cache sekaligus (config, route, view, event, dll).</p>
                        <form action="<?php echo e(route('admin.maintenance.clear', 'optimize')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button class="btn btn-danger btn-sm"><i class="fe fe-refresh-cw"></i> Jalankan</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-left-dark shadow h-100 py-3">
                    <div class="card-body text-center">
                        <i class="fe fe-alert-triangle display-4 text-danger mb-3"></i>
                        <h5 class="font-weight-bold">Clear Logs</h5>
                        <p class="text-muted small">Menghapus semua file aktivitas di storage/logs secara permanen untuk melegakan server.</p>
                        <form id="clearLogsForm" action="<?php echo e(route('admin.maintenance.clearLogs')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmClearLogs()">
                                <i class="fe fe-trash-2"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-3">
                    <div class="card-body text-center">
                        <i class="fe fe-cpu display-4 text-success mb-3"></i>
                        <h5 class="font-weight-bold">Rebuild Optimize</h5>
                        <p class="text-muted small">Membangun ulang cache (config, route, view, dll). Direkomendasikan setelah Clear Optimize.</p>
                        <form action="<?php echo e(route('admin.maintenance.clear', 'rebuild')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button class="btn btn-success btn-sm">
                                <i class="fe fe-zap"></i> Jalankan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmClearLogs() {
            Swal.fire({
                title: 'Peringatan!',
                text: "Semua log akan dihapus permanen. Tindakan ini membantu mengurangi beban memori di server, tindakan ini tidak memengaruhi fungsi kinerja sistem. Apakah Anda yakin ingin melanjutkan?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('clearLogsForm').submit();
                }
            })
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views/backend/pages/maintenance/index.blade.php ENDPATH**/ ?>