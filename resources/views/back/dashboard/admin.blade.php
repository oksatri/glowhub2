@php
    // Admin dashboard partial: uses variables provided by DashboardController
@endphp

{{-- Reused content from original dashboard view for admin users --}}
<div class="card-group">
    @php
        $bookingsIndexRoute =
            auth()->check() && auth()->user()->role === 'mua'
                ? route('auth-mua.bookinga.bookings.index')
                : route('admin.bookings.index');
    @endphp

    <div class="card border-right">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <h3 class="text-dark mb-1 font-weight-medium">{{ number_format($usersCount) }}</h3>
                    <h6 class="text-muted mb-0">Total Users</h6>
                </div>
                <div class="ml-auto text-right">
                    @if (!is_null($usersCompare))
                        <span class="badge badge-pill {{ $usersCompare >= 0 ? 'badge-success' : 'badge-danger' }}">{{ $usersCompare }}%</span>
                        <div class="small text-muted">last 30 days</div>
                    @else
                        <div class="small text-muted">no comparison</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card border-right">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <h3 class="text-dark mb-1 font-weight-medium">{{ number_format($muasCount) }}</h3>
                    <h6 class="text-muted mb-0">Total MUAs</h6>
                </div>
                <div class="ml-auto text-right">
                    @if (!is_null($muasCompare))
                        <span class="badge badge-pill {{ $muasCompare >= 0 ? 'badge-success' : 'badge-danger' }}">{{ $muasCompare }}%</span>
                        <div class="small text-muted">last 30 days</div>
                    @else
                        <div class="small text-muted">no comparison</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card border-right">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <h3 class="text-dark mb-1 font-weight-medium">{{ number_format($bookingsCount) }}</h3>
                    <h6 class="text-muted mb-0">Total Bookings</h6>
                </div>
                <div class="ml-auto text-right">
                    @if (!is_null($bookingsCompare))
                        <span class="badge badge-pill {{ $bookingsCompare >= 0 ? 'badge-success' : 'badge-danger' }}">{{ $bookingsCompare }}%</span>
                        <div class="small text-muted">last 30 days</div>
                    @else
                        <div class="small text-muted">no comparison</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <h3 class="text-dark mb-1 font-weight-medium">{{ number_format($pendingCount) }}</h3>
                    <h6 class="text-muted mb-0">Pending Bookings</h6>
                </div>
                <div class="ml-auto text-right">
                    <a href="{{ $bookingsIndexRoute }}" class="btn btn-outline-primary btn-sm">View bookings</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Keep rest of admin view: charts, recent bookings, tables, etc. --}}
<div class="row">
    <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Bookings Trend (7 days)</h4>
                <div class="mt-2" style="height:283px; width:100%;">
                    <canvas id="bookingTrendChart" style="height:260px; width:100%;"></canvas>
                </div>
                <ul class="list-style-none mb-0 mt-3">
                    <li>
                        <i class="fas fa-circle text-primary font-10 mr-2"></i>
                        <span class="text-muted">Total (30 days)</span>
                        <span class="text-dark float-right font-weight-medium">{{ $last30_bookings }}</span>
                    </li>
                    <li class="mt-3">
                        <i class="fas fa-circle text-danger font-10 mr-2"></i>
                        <span class="text-muted">Previous 30 days</span>
                        <span class="text-dark float-right font-weight-medium">{{ $prev30_bookings }}</span>
                    </li>
                    <li class="mt-3">
                        <i class="fas fa-circle text-cyan font-10 mr-2"></i>
                        <span class="text-muted">Pending</span>
                        <span class="text-dark float-right font-weight-medium">{{ $pendingCount }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Net Income</h4>
                <div class="net-income mt-4 position-relative" style="height:294px;"></div>
                <ul class="list-inline text-center mt-5 mb-2">
                    <li class="list-inline-item text-muted font-italic">Sales for this month</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Earning by Location</h4>
                <div class="" style="height:180px">
                    <div id="visitbylocate" style="height:100%"></div>
                </div>
                <div class="row mb-3 align-items-center mt-5">
                    <div class="col-4 text-right">
                        <span class="text-muted font-14">India</span>
                    </div>
                    <div class="col-5">
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-3 text-right">
                        <span class="mb-0 font-14 text-dark font-weight-medium">28%</span>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <div class="col-4 text-right">
                        <span class="text-muted font-14">UK</span>
                    </div>
                    <div class="col-5">
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 74%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-3 text-right">
                        <span class="mb-0 font-14 text-dark font-weight-medium">21%</span>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <div class="col-4 text-right">
                        <span class="text-muted font-14">USA</span>
                    </div>
                    <div class="col-5">
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-cyan" role="progressbar" style="width: 60%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-3 text-right">
                        <span class="mb-0 font-14 text-dark font-weight-medium">18%</span>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-4 text-right">
                        <span class="text-muted font-14">China</span>
                    </div>
                    <div class="col-5">
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-3 text-right">
                        <span class="mb-0 font-14 text-dark font-weight-medium">12%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <h4 class="card-title mb-0">Earning Statistics</h4>
                    <div class="ml-auto">
                        <div class="dropdown sub-dropdown">
                            <button class="btn btn-link text-muted dropdown-toggle" type="button" id="dd1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="more-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1">
                                <a class="dropdown-item" href="#">Insert</a>
                                <a class="dropdown-item" href="#">Update</a>
                                <a class="dropdown-item" href="#">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pl-4 mb-5">
                    <div class="stats ct-charts position-relative" style="height: 315px;"></div>
                </div>
                <ul class="list-inline text-center mt-4 mb-0">
                    <li class="list-inline-item text-muted font-italic">Earnings for this month</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Recent Bookings</h4>
                <div class="mt-4 activity">
                    @forelse($recentBookings as $b)
                        <div class="d-flex align-items-start border-left-line pb-3">
                            <div>
                                <a href="{{ route('back.bookings.show', $b->id) }}" class="btn btn-info btn-circle mb-2 btn-item">
                                    <i data-feather="calendar"></i>
                                </a>
                            </div>
                            <div class="ml-3 mt-2">
                                <h5 class="text-dark font-weight-medium mb-2">{{ $b->customer_name ?? '—' }}
                                    @if ($b->mua)
                                        <small class="text-muted">with {{ $b->mua->name }}</small>
                                    @endif
                                </h5>
                                <p class="font-14 mb-2 text-muted">{{ optional($b->created_at)->format('d M Y H:i') }} — <strong class="text-capitalize">{{ $b->status }}</strong></p>
                                <span class="font-weight-light font-14 text-muted">{{ $b->selected_date ?? '' }} {{ $b->selected_time ?? '' }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted">No recent bookings</div>
                    @endforelse
                    <div class="mt-2"><a href="{{ $bookingsIndexRoute }}" class="font-14 border-bottom pb-1 border-info">Load More</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <h4 class="card-title">Top Leaders</h4>
                    <div class="ml-auto">
                        <div class="dropdown sub-dropdown">
                            <button class="btn btn-link text-muted dropdown-toggle" type="button" id="dd1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="more-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1">
                                <a class="dropdown-item" href="#">Insert</a>
                                <a class="dropdown-item" href="#">Update</a>
                                <a class="dropdown-item" href="#">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table no-wrap v-middle mb-0">
                        <thead>
                            <tr class="border-0">
                                <th class="border-0 font-14 font-weight-medium text-muted">Team Lead
                                </th>
                                <th class="border-0 font-14 font-weight-medium text-muted px-2">Project
                                </th>
                                <th class="border-0 font-14 font-weight-medium text-muted">Team</th>
                                <th class="border-0 font-14 font-weight-medium text-muted text-center">Status</th>
                                <th class="border-0 font-14 font-weight-medium text-muted text-center">Weeks</th>
                                <th class="border-0 font-14 font-weight-medium text-muted">Budget</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border-top-0 px-2 py-4">
                                    <div class="d-flex no-block align-items-center">
                                        <div class="mr-3"><img src="{{ asset('admin/assets/images/users/widget-table-pic1.jpg') }}" alt="user" class="rounded-circle" width="45" height="45" /></div>
                                        <div class="">
                                            <h5 class="text-dark mb-0 font-16 font-weight-medium">Hanna Gover</h5>
                                            <span class="text-muted font-14">hgover@gmail.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-top-0 text-muted px-2 py-4 font-14">Elite Admin</td>
                                <td class="border-top-0 px-2 py-4">
                                    <div class="popover-icon">
                                        <a class="btn btn-primary rounded-circle btn-circle font-12" href="javascript:void(0)">DS</a>
                                        <a class="btn btn-danger rounded-circle btn-circle font-12 popover-item" href="javascript:void(0)">SS</a>
                                        <a class="btn btn-cyan rounded-circle btn-circle font-12 popover-item" href="javascript:void(0)">RP</a>
                                        <a class="btn btn-success text-white rounded-circle btn-circle font-20" href="javascript:void(0)">+</a>
                                    </div>
                                </td>
                                <td class="border-top-0 text-center px-2 py-4"><i class="fa fa-circle text-primary font-12" data-toggle="tooltip" data-placement="top" title="In Testing"></i></td>
                                <td class="border-top-0 text-center font-weight-medium text-muted px-2 py-4">35</td>
                                <td class="font-weight-medium text-dark border-top-0 px-2 py-4">$96K</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4">
                                    <div class="d-flex no-block align-items-center">
                                        <div class="mr-3"><img src="{{ asset('admin/assets/images/users/widget-table-pic2.jpg') }}" alt="user" class="rounded-circle" width="45" height="45" /></div>
                                        <div class="">
                                            <h5 class="text-dark mb-0 font-16 font-weight-medium">Daniel Kristeen</h5>
                                            <span class="text-muted font-14">Kristeen@gmail.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted px-2 py-4 font-14">Real Homes WP Theme</td>
                                <td class="px-2 py-4">
                                    <div class="popover-icon">
                                        <a class="btn btn-primary rounded-circle btn-circle font-12" href="javascript:void(0)">DS</a>
                                        <a class="btn btn-danger rounded-circle btn-circle font-12 popover-item" href="javascript:void(0)">SS</a>
                                        <a class="btn btn-success text-white rounded-circle btn-circle font-20" href="javascript:void(0)">+</a>
                                    </div>
                                </td>
                                <td class="text-center px-2 py-4"><i class="fa fa-circle text-success font-12" data-toggle="tooltip" data-placement="top" title="Done"></i></td>
                                <td class="text-center text-muted font-weight-medium px-2 py-4">32</td>
                                <td class="font-weight-medium text-dark px-2 py-4">$85K</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4">
                                    <div class="d-flex no-block align-items-center">
                                        <div class="mr-3"><img src="{{ asset('admin/assets/images/users/widget-table-pic3.jpg') }}" alt="user" class="rounded-circle" width="45" height="45" /></div>
                                        <div class="">
                                            <h5 class="text-dark mb-0 font-16 font-weight-medium">Julian Josephs</h5>
                                            <span class="text-muted font-14">Josephs@gmail.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted px-2 py-4 font-14">MedicalPro WP Theme</td>
                                <td class="px-2 py-4">
                                    <div class="popover-icon">
                                        <a class="btn btn-primary rounded-circle btn-circle font-12" href="javascript:void(0)">DS</a>
                                        <a class="btn btn-danger rounded-circle btn-circle font-12 popover-item" href="javascript:void(0)">SS</a>
                                        <a class="btn btn-cyan rounded-circle btn-circle font-12 popover-item" href="javascript:void(0)">RP</a>
                                        <a class="btn btn-success text-white rounded-circle btn-circle font-20" href="javascript:void(0)">+</a>
                                    </div>
                                </td>
                                <td class="text-center px-2 py-4"><i class="fa fa-circle text-primary font-12" data-toggle="tooltip" data-placement="top" title="Done"></i></td>
                                <td class="text-center text-muted font-weight-medium px-2 py-4">29</td>
                                <td class="font-weight-medium text-dark px-2 py-4">$81K</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4">
                                    <div class="d-flex no-block align-items-center">
                                        <div class="mr-3"><img src="{{ asset('admin/assets/images/users/widget-table-pic4.jpg') }}" alt="user" class="rounded-circle" width="45" height="45" /></div>
                                        <div class="">
                                            <h5 class="text-dark mb-0 font-16 font-weight-medium">Jan Petrovic</h5>
                                            <span class="text-muted font-14">hgover@gmail.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted px-2 py-4 font-14">Hosting Press HTML</td>
                                <td class="px-2 py-4">
                                    <div class="popover-icon">
                                        <a class="btn btn-primary rounded-circle btn-circle font-12" href="javascript:void(0)">DS</a>
                                        <a class="btn btn-success text-white font-20 rounded-circle btn-circle" href="javascript:void(0)">+</a>
                                    </div>
                                </td>
                                <td class="text-center px-2 py-4"><i class="fa fa-circle text-danger font-12" data-toggle="tooltip" data-placement="top" title="In Progress"></i></td>
                                <td class="text-center text-muted font-weight-medium px-2 py-4">23</td>
                                <td class="font-weight-medium text-dark px-2 py-4">$80K</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function() {
        var ctx = document.getElementById('bookingTrendChart');
        if (!ctx) return;
        var labels = {!! json_encode($trendLabels) !!};
        var data = {!! json_encode($trendData) !!};

        new Chart(ctx.getContext('2d'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Bookings',
                    data: data,
                    fill: true,
                    backgroundColor: 'rgba(54,162,235,0.1)',
                    borderColor: 'rgba(54,162,235,1)',
                    tension: 0.3,
                    pointRadius: 3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    })();
</script>
