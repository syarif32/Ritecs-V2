@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="h5 page-title">Welcome!</h2>
                </div>
                <div class="col-auto">
                    <form class="form-inline">
                        <div class="form-group d-none d-lg-inline">
                            <label for="reportrange" class="sr-only">Date Ranges</label>
                            <div id="reportrange" class="px-2 py-2 text-muted">
                                <span class="small"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-sm"><span class="fe fe-refresh-ccw fe-16 text-muted"></span></button>
                            <button type="button" class="btn btn-sm mr-2"><span class="fe fe-filter fe-16 text-muted"></span></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row items-align-baseline">
                <!-- REVENUE CARD -->
                <div class="col-md-12 col-lg-4">
                    <div class="card shadow eq-card mb-4">
                        <div class="card-body mb-n3">
                            <div class="row items-align-baseline h-100">
                                <div class="col-md-6 my-3">
                                    <p class="mb-0"><strong class="mb-0 text-uppercase text-muted">Revenue</strong></p>
                                    <h3>Rp. {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                                    <p class="text-muted">Total revenue all time successful payments membership</p>
                                </div>
                                <div class="col-md-6 my-4 text-center">
                                    <div class="chart-box mx-4">
                                        <div id="dashboardRadialWidget"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 border-top py-3">
                                    <p class="mb-1"><strong class="text-muted">This Week</strong></p>
                                    <h4 class="mb-0">Rp. {{ number_format($thisWeekRevenue, 0, ',', '.') }}</h4>
                                    <p class="small text-muted mb-0">
                                        <span class="{{ $revenueGrowth >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $revenueGrowth >= 0 ? '+' : '' }}{{ $revenueGrowth }}% Last week
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-6 border-top py-3">
                                    <p class="mb-1"><strong class="text-muted">Success Rate</strong></p>
                                    <h4 class="mb-0">{{ $successRate }}%</h4>
                                    <p class="small text-muted mb-0"><span>Paid transactions this month</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KONTEN & PENERBITAN CARD -->
                <div class="col-md-12 col-lg-4">
                    <div class="card shadow eq-card mb-4">
                        <div class="card-body mb-n3">
                            <div class="row items-align-baseline h-100">
                                <div class="col-12 my-3">
                                    <p class="mb-0"><strong class="mb-0 text-uppercase text-muted">Konten & Penerbitan</strong></p>
                                    <h3>{{ $totalContent }}</h3>
                                </div>
                                <div class="col-md-6 border-top py-3">
                                    <p class="mb-1"><strong class="text-muted">Buku</strong></p>
                                    <h4 class="mb-0">{{ $totalBooks }}</h4>
                                    <p class="small text-muted mb-0"><span>Total Published</span></p>
                                </div>
                                <div class="col-md-6 border-top py-3">
                                    <p class="mb-1"><strong class="text-muted">Jurnal</strong></p>
                                    <h4 class="mb-0">{{ $totalJournals }}</h4>
                                    <p class="small text-muted mb-0"><span>Total Published</span></p>
                                </div>
                                <div class="col-md-6 border-top py-3">
                                    <p class="mb-1"><strong class="text-muted">Writer list</strong></p>
                                    <h4 class="mb-0">{{ $totalWriters }}</h4>
                                </div>
                                <div class="col-md-6 border-top py-3">
                                    <p class="mb-1"><strong class="text-muted">Keyword list</strong></p>
                                    <h4 class="mb-0">{{ $totalKeywords }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- USER & MEMBERSHIP CARD -->
                <div class="col-md-12 col-lg-4">
                    <div class="card shadow eq-card mb-4">
                        <div class="card-body mb-n3">
                            <div class="row items-align-baseline h-100">
                                <div class="col-12 my-3">
                                    <p class="mb-0"><strong class="mb-0 text-uppercase text-muted">User & Membership</strong></p>
                                    <h3>{{ $totalUsers }}</h3>
                                    <p class="text-muted">Total all user & membership guest</p>
                                </div>
                                <div class="col-md-4 border-top py-3">
                                    <p class="mb-1"><strong class="text-muted">Regular User</strong></p>
                                    <h4 class="mb-0">{{ $regularUsers }}</h4>
                                </div>
                                <div class="col-md-4 border-top py-3">
                                    <p class="mb-1"><strong class="text-muted">With Membership</strong></p>
                                    <h4 class="mb-0">{{ $activeMemberships }}</h4>
                                </div>
                                <div class="col-md-4 border-top py-3">
                                    <p class="mb-1"><strong class="text-muted">Guest Member</strong></p>
                                    <h4 class="mb-0">{{ $guestMemberships }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BALANCE & CHART -->
            <div class="mb-2 align-items-center">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="row mt-1 align-items-center">
                            <div class="col-12 col-lg-4 text-left pl-4">
                                <p class="mb-1 small text-muted">Balance</p>
                                <span class="h3">Rp. {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                                <span class="small {{ $monthlyGrowth >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $monthlyGrowth >= 0 ? '+' : '' }}{{ $monthlyGrowth }}%
                                </span>
                                <span class="fe fe-arrow-{{ $monthlyGrowth >= 0 ? 'up' : 'down' }} {{ $monthlyGrowth >= 0 ? 'text-success' : 'text-danger' }} fe-12"></span>
                                <p class="text-muted mt-2">Total revenue dari semua transaksi yang berhasil</p>
                            </div>
                            <div class="col-6 col-lg-2 text-center py-4">
                                <p class="mb-1 small text-muted">Today</p>
                                <span class="h3">Rp. {{ number_format($todayRevenue, 0, ',', '.') }}</span><br />
                            </div>
                            <div class="col-6 col-lg-2 text-center py-4 mb-2">
                                <p class="mb-1 small text-muted">Goal Value</p>
                                <span class="h3">Rp. {{ number_format($monthlyTarget, 0, ',', '.') }}</span><br />
                            </div>
                            <div class="col-6 col-lg-2 text-center py-4">
                                <p class="mb-1 small text-muted">Completions</p>
                                <span class="h3">{{ $totalCompletions }}</span><br />
                            </div>
                            <div class="col-6 col-lg-2 text-center py-4">
                                <p class="mb-1 small text-muted">Conversion</p>
                                <span class="h3">{{ $conversionRate }}%</span><br />
                            </div>
                        </div>
                        <div class="chartbox mr-4">
                            <div id="dashboardAreaChart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Recent Activity -->
                <div class="col-md-12 col-lg-4 mb-4">
                    <div class="card timeline shadow">
                        <div class="card-header">
                            <strong class="card-title">Recent Activity</strong>
                            <a class="float-right small text-muted" href="#!">View all</a>
                        </div>
                        <div class="card-body" data-simplebar style="height:355px; overflow-y: auto; overflow-x: hidden;">
                            @forelse($recentActivities as $activity)
                            <div class="pb-3 timeline-item item-{{ 
                                $activity->action_type == 'PROMOTE' ? 'success' : 
                                ($activity->action_type == 'DEMOTE' ? 'warning' : 'primary') 
                            }}">
                                <div class="pl-5">
                                    <div class="mb-1">
                                        <strong>{{ $activity->actor ? $activity->actor->email : 'System' }}</strong>
                                        <span class="text-muted small mx-2">{{ $activity->description }}</span>
                                        @if($activity->target)
                                        <strong class="text-primary">{{ $activity->target->email }}</strong>
                                        @endif
                                    </div>
                                    <p class="small text-muted">
                                        <span class="badge badge-{{ 
                                            $activity->action_type == 'PROMOTE' ? 'success' : 
                                            ($activity->action_type == 'DEMOTE' ? 'warning' : 'info') 
                                        }}">
                                            {{ $activity->action_type }}
                                        </span>
                                        <span class="badge badge-light ml-1">{{ $activity->created_at->diffForHumans() }}</span>
                                    </p>
                                </div>
                            </div>
                            @empty
                            <p class="text-muted text-center">No recent activities</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="col-md-12 col-lg-8">
                    <div class="card shadow">
                        <div class="card-header">
                            <strong class="card-title">Recent Transactions</strong>
                            <a class="float-right small text-muted" href="#!">View all</a>
                        </div>
                        <div class="card-body my-n2">
                            <table class="table table-striped table-hover table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentTransactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->transaction_id }}</td>
                                        <th scope="col">{{ $transaction->user->first_name ?? 'N/A' }} {{ $transaction->user->last_name ?? '' }}</th>
                                        <td>Rp. {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $transaction->status == 'paid' ? 'success' : ($transaction->status == 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $transaction->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No recent transactions</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Update Radialbar Widget dengan JUMLAH transaksi sukses bulan ini
    var radialbarWidgetOptions = {
        series: [{{ $successTransactionsThisMonth }}], // Jumlah transaksi sukses
        chart: {
            height: 120,
            type: 'radialBar'
        },
        theme: {
            mode: colors.chartTheme
        },
        plotOptions: {
            radialBar: {
                hollow: {
                    size: '70%'
                },
                track: {
                    background: colors.borderColor
                },
                dataLabels: {
                    show: true,
                    name: {
                        fontSize: '0.875rem',
                        fontWeight: 400,
                        offsetY: -10,
                        show: false,
                        color: colors.mutedColor,
                        fontFamily: base.defaultFontFamily
                    },
                    value: {
                        formatter: function(val) {
                            return parseInt(val) // Tampilkan angka asli, bukan persen
                        },
                        fontSize: '1.53125rem',
                        fontWeight: 700,
                        fontFamily: base.defaultFontFamily,
                        offsetY: 10,
                        show: true,
                        color: colors.headingColor
                    }
                }
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'light',
                type: 'diagonal2',
                shadeIntensity: 0.2,
                gradientFromColors: [extend.primaryColorLighter],
                gradientToColors: [base.primaryColor],
                inverseColors: true,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [20, 100]
            }
        },
        stroke: {
            lineCap: 'round'
        }
    };

    var radialbarWidget = document.querySelector("#dashboardRadialWidget");
    if (radialbarWidget) {
        var radialbarWidgetChart = new ApexCharts(radialbarWidget, radialbarWidgetOptions);
        radialbarWidgetChart.render();
    }

    // Update Area Chart dengan data dari controller
    var areaChartOptions = {
        series: [{
            name: 'Revenue',
            data: {!! $chartRevenue !!}
        }, {
            name: 'Transactions',
            data: {!! $chartTransactions !!}
        }],
        chart: {
            type: 'area',
            height: 350,
            background: 'transparent',
            stacked: false,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        theme: {
            mode: colors.chartTheme
        },
        xaxis: {
            type: 'datetime',
            categories: {!! $chartDates !!},
            labels: {
                show: true,
                trim: false,
                style: {
                    colors: colors.mutedColor,
                    fontFamily: base.defaultFontFamily
                }
            },
            axisBorder: {
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        fill: {
            type: 'solid',
            opacity: 0.3
        },
        colors: chartColors,
        grid: {
            show: true,
            borderColor: colors.borderColor
        }
    };

    var areachartCtn = document.querySelector("#dashboardAreaChart");
    if (areachartCtn) {
        var areachart = new ApexCharts(areachartCtn, areaChartOptions);
        areachart.render();
    }
</script>
@endpush

@endsection