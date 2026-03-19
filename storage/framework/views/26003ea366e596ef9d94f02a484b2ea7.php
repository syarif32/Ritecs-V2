<?php $__env->startSection('content'); ?>

  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">

        <div class="row align-items-center mb-4">
          <div class="col">
            <h2 class="h5 page-title">Dashboard Overview</h2>
            <p class="text-muted mb-0">Ringkasan aktivitas sistem dan transaksi terkini.</p>
          </div>
          <div class="col-auto">
            <form class="form-inline">
              <div class="form-group d-none d-lg-inline">
                <label for="reportrange" class="sr-only">Date Ranges</label>
                <div id="reportrange" class="px-2 py-2 text-muted bg-light rounded border">
                  <span class="small"><i class="fe fe-calendar mr-2"></i> <?php echo e(date('d M Y')); ?></span>
                </div>
              </div>
              <div class="form-group ml-3">
                <button type="button" class="btn btn-sm btn-light border mr-2"><span
                    class="fe fe-refresh-ccw fe-16 text-muted"></span></button>
                <button type="button" class="btn btn-sm btn-light border"><span
                    class="fe fe-filter fe-16 text-muted"></span></button>
              </div>
            </form>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col-12">
            <div class="card shadow mb-4">
              <div class="card-body">
                <div class="row align-items-center mb-4">

                  <div class="col-md-4 col-12 border-right">
                    <p class="mb-1 small text-muted text-uppercase font-weight-bold">Total Pendapatan</p>
                    <span class="h3 mb-0 text-primary">Rp <?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></span>
                    <div class="mt-2">
                      <span class="badge badge-light text-success px-2 py-1">+20% <i class="fe fe-arrow-up"></i></span>
                      <small class="text-muted ml-1">dari bulan lalu</small>
                    </div>
                  </div>

                  <div class="col-md-8 col-12">
                    <div class="row text-center">
                      <div class="col-4">
                        <p class="mb-1 small text-muted">Perlu Validasi</p>
                        <h4 class="mb-0"><?php echo e($pendingTransactions); ?></h4>
                        <?php if($pendingTransactions > 0): ?>
                          <small class="text-danger font-weight-bold">Action Needed</small>
                        <?php else: ?>
                          <small class="text-success"><i class="fe fe-check-circle"></i> Aman</small>
                        <?php endif; ?>
                      </div>
                      <div class="col-4 border-left border-right">
                        <p class="mb-1 small text-muted">Member Aktif</p>
                        <h4 class="mb-0"><?php echo e($activeMembers); ?></h4>
                        <small class="text-muted">User Terdaftar</small>
                      </div>
                      <div class="col-4">
                        <p class="mb-1 small text-muted">Total Downloads</p>
                        <h4 class="mb-0"><?php echo e($totalDownloads); ?></h4>
                        <small class="text-muted">Buku</small>
                      </div>
                    </div>
                  </div>
                </div>
                <h6 class="card-title text-muted mb-3">Analitik 7 Hari Terakhir</h6>
                <div class="chartbox position-relative" style="min-height: 320px;">
                  <div id="myRealChart"></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">

          <div class="col-md-12 col-lg-4 mb-4">
            <div class="card shadow h-100">
              <div class="card-header d-flex justify-content-between align-items-center">
                <strong class="card-title mb-0">Aktivitas Admin</strong>
                <a class="small text-muted" href="#">Lihat Semua</a>
              </div>
              <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                <div class="timeline">
                  <?php $__empty_1 = true; $__currentLoopData = $adminLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="pb-3 timeline-item item-<?php echo e($loop->iteration % 2 == 0 ? 'warning' : 'primary'); ?>">
                      <div class="pl-4">
                        <div class="mb-1 small">
                          <strong><?php echo e($log->actor->full_name ?? 'System'); ?></strong>
                          <span class="text-muted mx-1"><?php echo e($log->action ?? 'melakukan aksi'); ?></span>
                        </div>
                        <p class="small text-muted mb-1 font-italic">"<?php echo e(Str::limit($log->description, 50)); ?>"</p>
                        <span class="badge badge-light text-muted"><?php echo e($log->created_at->diffForHumans()); ?></span>
                      </div>
                    </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center text-muted py-4">
                      <span class="fe fe-inbox fe-24 mb-2 d-block"></span>
                      Belum ada aktivitas tercatat.
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-12 col-lg-8 mb-4">
            <div class="card shadow h-100">
              <div class="card-header d-flex justify-content-between align-items-center">
                <strong class="card-title mb-0">Transaksi Terakhir</strong>
                <a class="small text-muted" href="#">Lihat Semua</a>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped table-hover table-borderless mb-0">
                    <thead class="thead-light">
                      <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Nominal</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $__empty_1 = true; $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                          <td class="align-middle"><small class="text-muted">#<?php echo e($trx->transaction_id); ?></small></td>
                          <td class="align-middle">
                            <div class="d-flex align-items-center">
                              <div class="avatar avatar-sm mr-2">
                                <span class="avatar-title rounded-circle bg-light text-muted">
                                  <?php echo e(substr($trx->user->full_name ?? 'G', 0, 1)); ?>

                                </span>
                              </div>
                              <div>
                                <span
                                  class="d-block font-weight-bold text-dark"><?php echo e($trx->user->full_name ?? 'Guest'); ?></span>
                                <small class="text-muted"><?php echo e($trx->sender_bank); ?></small>
                              </div>
                            </div>
                          </td>
                          <td class="align-middle font-weight-bold">Rp <?php echo e(number_format($trx->amount, 0, ',', '.')); ?></td>
                          <td class="align-middle small"><?php echo e($trx->created_at->format('d/m/Y H:i')); ?></td>
                          <td class="align-middle">
                            <?php if($trx->status == 'paid'): ?>
                              <span class="badge badge-pill badge-success px-2">Lunas</span>
                            <?php elseif($trx->status == 'pending'): ?>
                              <span class="badge badge-pill badge-warning px-2">Pending</span>
                            <?php else: ?>
                              <span class="badge badge-pill badge-danger px-2">Gagal</span>
                            <?php endif; ?>
                          </td>
                          <td class="align-middle text-right">
                            <div class="dropdown">
                              <button class="btn btn-sm dropdown-toggle more-vertical text-muted" type="button"
                                data-toggle="dropdown"></button>
                              <div class="dropdown-menu dropdown-menu-right shadow-sm">
                                <a class="dropdown-item" href="#"><i class="fe fe-eye mr-2"></i> Detail</a>
                                <a class="dropdown-item" href="#"><i class="fe fe-edit mr-2"></i> Edit</a>
                              </div>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                          <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fe fe-clipboard fe-24 d-block mb-2"></i>
                            Tidak ada data transaksi terbaru.
                          </td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {


      var dates = <?php echo json_encode($chartDates); ?>;
      var dataRevenue = <?php echo json_encode($dataRevenue); ?>;
      var dataMembers = <?php echo json_encode($dataMembers); ?>;
      var dataTransactions = <?php echo json_encode($dataTransactions); ?>;

      var options = {
        series: [{
          name: 'Pendapatan',
          data: dataRevenue
        }, {
          name: 'Member Baru',
          data: dataMembers
        }, {
          name: 'Total Transaksi',
          data: dataTransactions
        }],
        chart: {
          height: 350,
          type: 'area',
          fontFamily: 'sans-serif',
          toolbar: { show: false },
          zoom: { enabled: false }
        },
        dataLabels: { enabled: false },
        stroke: {
          curve: 'smooth',
          width: 2
        },
        fill: {
          type: 'gradient',
          gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.6,
            opacityTo: 0.2,
            stops: [0, 90, 100]
          }
        },
        xaxis: {
          categories: dates,
          axisBorder: { show: false },
          axisTicks: { show: false },
          labels: {
            style: { colors: '#8e8da4', fontSize: '12px' }
          }
        },
        yaxis: {
          labels: {
            style: { colors: '#8e8da4', fontSize: '12px' },
            formatter: function (val, opts) {
              if (opts.seriesIndex === 0 && val > 1000) {
                return "Rp " + (val / 1000).toFixed(0) + "k";
              }
              return val;
            }
          }
        },
        grid: {
          borderColor: '#f1f1f1',
          strokeDashArray: 4,
          padding: { left: 10, right: 10 }
        },
        colors: ['#6c5ce7', '#00b894', '#0984e3'],
        legend: {
          position: 'top',
          horizontalAlign: 'right'
        },
        tooltip: {
          y: {
            formatter: function (val, { seriesIndex }) {
              if (seriesIndex === 0) {
                return "Rp " + new Intl.NumberFormat('id-ID').format(val);
              }
              return val;
            }
          }
        }
      };

      var chart = new ApexCharts(document.querySelector("#myRealChart"), options);
      chart.render();
    });
  </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views/backend/pages/dashboard.blade.php ENDPATH**/ ?>