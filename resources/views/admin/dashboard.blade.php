@extends('admin.layouts.admin_master')

@section('title', 'Dashboard')

@section('content')
@if (session('success'))
<div class="alert alert-success" role="alert">
    <strong>{{ session('success') }}</strong>
</div>
@endif
@if (session('error'))
<div class="alert alert-warning" role="alert">
    <strong>{{ session('error') }}</strong>
</div>
@endif
<div class="row">
    <div class="col-lg-8 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Congratulations {{ Auth::user()->name }}! 🎉</h5>
                        <p class="mb-4"> You have done <span class="fw-bold">{{ App\Models\Selling_summary::whereDate('selling_date', date('Y-m-d'))->count() }}</span> more sales today. Check your new sale today.</p>
                        <a href="{{ route('selling.product') }}" class="btn btn-sm btn-outline-primary">Sale</a>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img src="{{ asset('admin') }}/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 order-1">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                            <img src="{{ asset('admin') }}/img/icons/unicons/chart-success.png" alt="chart success" class="rounded" />
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Total Supplier</span>
                        <h3 class="card-title mb-2">{{ $suppliers }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('admin') }}/img/icons/unicons/wallet-info.png" alt="Credit Card" class="rounded" />
                            </div>
                        </div>
                        <span  class="fw-semibold d-block mb-1"> Total Customer</span>
                        <h3 class="card-title text-nowrap mb-1">{{ $customers }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Total Revenue -->
    <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
      <div class="card">
        <div class="row row-bordered g-0">
            <div class="col-md-4">
                <div class="card-body">
                    <div class="text-center">
                        <span class="badge bg-success">{{ date('Y') }}</span>
                    </div>
                </div>
                <div class="text-center fw-semibold pt-3 mb-2">Company Growth</div>
                <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                    <div class="d-flex">
                        <div class="me-2">
                        <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>
                        </div>
                        <div class="d-flex flex-column">
                        <small>Purchase</small>
                        <h6 class="mb-0">{{ App\Models\Purchase_summary::whereYear('purchase_date', date('Y'))->sum('grand_total') }}</h6>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="me-2">
                        <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>
                        </div>
                        <div class="d-flex flex-column">
                        <small>Selling</small>
                        <h6 class="mb-0">{{ App\Models\Selling_summary::whereYear('selling_date', date('Y'))->sum('grand_total') }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-body">
                    <div class="text-center">
                        <span class="badge bg-success">{{ date('F') }}</span>
                    </div>
                </div>
                <div class="text-center fw-semibold pt-3 mb-2">Company Growth</div>
                    <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                    <div class="d-flex">
                        <div class="me-2">
                        <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>
                        </div>
                        <div class="d-flex flex-column">
                        <small>Purchase</small>
                        <h6 class="mb-0">{{ App\Models\Purchase_summary::whereMonth('purchase_date', date('m'))->sum('grand_total') }}</h6>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="me-2">
                        <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>
                        </div>
                        <div class="d-flex flex-column">
                        <small>Selling</small>
                        <h6 class="mb-0">{{ App\Models\Selling_summary::whereMonth('selling_date', date('m'))->sum('grand_total') }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-body">
                    <div class="text-center">
                        <span class="badge bg-success">{{ date('D') }}</span>
                    </div>
                </div>
                <div class="text-center fw-semibold pt-3 mb-2">Company Growth</div>
                    <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                    <div class="d-flex">
                        <div class="me-2">
                        <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>
                        </div>
                        <div class="d-flex flex-column">
                        <small>Purchase</small>
                        <h6 class="mb-0">{{ App\Models\Purchase_summary::whereDate('purchase_date', date('Y-m-d'))->sum('grand_total') }}</h6>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="me-2">
                        <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>
                        </div>
                        <div class="d-flex flex-column">
                        <small>Selling</small>
                        <h6 class="mb-0">{{ App\Models\Selling_summary::whereDate('selling_date', date('Y-m-d'))->sum('grand_total') }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
    <!--/ Total Revenue -->
    <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                <div class="card-title">
                                    <h5 class="text-nowrap mb-2">Purchase Report</h5>
                                    <span class="badge bg-label-warning rounded-pill">Total</span>
                                </div>
                                <div class="mt-sm-auto">
                                    <h3 class="mb-0">{{ $purchase_summaries->sum('grand_total') }}</h3>
                                </div>
                            </div>
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                <div class="card-title">
                                    <h5 class="text-nowrap mb-2">Selling Report</h5>
                                    <span class="badge bg-label-warning rounded-pill">Total</span>
                                </div>
                                <div class="mt-sm-auto">
                                    <h3 class="mb-0">{{ $selling_summaries->sum('grand_total') }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="badge bg-label-success rounded-pill my-3">Total Stock ({{ $purchase_summaries->sum('grand_total') - $selling_summaries->sum('grand_total') }})</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-3 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                    <img src="{{ asset('admin') }}/img/icons/unicons/paypal.png" alt="Credit Card" class="rounded" />
                    </div>
                </div>
                <span class="d-block mb-1">Purchase Cash Total</span>
                <h3 class="card-title text-success text-nowrap mb-2">{{ $purchase_summaries->sum('payment_amount') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-3 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                    <img src="{{ asset('admin') }}/img/icons/unicons/paypal.png" alt="Credit Card" class="rounded" />
                    </div>
                </div>
                <span class="d-block mb-1">Purchase Cash Due</span>
                <h3 class="card-title text-danger text-nowrap mb-2">{{ $purchase_summaries->sum('grand_total') - $purchase_summaries->sum('payment_amount') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-3 mb-4">
        <div class="card">
            <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                <img src="{{ asset('admin') }}/img/icons/unicons/cc-primary.png" alt="Credit Card" class="rounded" />
                </div>
            </div>
            <span class="fw-semibold d-block mb-1">Selling Cash Total</span>
            <h3 class="card-title text-success mb-2">{{ $selling_summaries->sum('payment_amount') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-3 mb-4">
        <div class="card">
            <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                <img src="{{ asset('admin') }}/img/icons/unicons/cc-primary.png" alt="Credit Card" class="rounded" />
                </div>
            </div>
            <span class="fw-semibold d-block mb-1">Selling Cash Due</span>
            <h3 class="card-title text-danger mb-2">{{ $selling_summaries->sum('grand_total') - $selling_summaries->sum('payment_amount') }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Statistics -->
    <div class="col-md-6 col-lg-6 order-0 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between pb-0">
          <div class="card-title mb-0">
            <h5 class="m-0 me-2">Statistics</h5>
          </div>
        </div>
        <div class="card-body mt-5">
          <ul class="p-0 m-0">
            <li class="d-flex mb-4 pb-1">
              <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-primary"
                  ><i class="bx bx-mobile-alt"></i
                ></span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-0">Category</h6>
                </div>
                <div class="user-progress">
                  <small class="fw-semibold">{{ $categories }}</small>
                </div>
              </div>
            </li>
            <li class="d-flex mb-4 pb-1">
              <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-success"><i class="bx bx-closet"></i></span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-0">Brand</h6>
                </div>
                <div class="user-progress">
                  <small class="fw-semibold">{{ $brands }}</small>
                </div>
              </div>
            </li>
            <li class="d-flex mb-4 pb-1">
              <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-0">Product</h6>
                </div>
                <div class="user-progress">
                  <small class="fw-semibold">{{ $products }}</small>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!--/ Statistics -->
    <!-- Expense Overview -->
    <div class="col-md-6 col-lg-6 order-1 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <div class="card-title mb-0">
                    <h5 class="m-0 me-2">Expenses Statistics</h5>
                </div>
            </div>
            <div class="card-body px-0">
                <div class="d-flex p-4 pt-3">
                    <div class="avatar flex-shrink-0 me-3">
                        <img src="{{ asset('admin') }}/img/icons/unicons/wallet.png" alt="User" />
                    </div>
                    <div>
                        <small class="text-muted d-block">Total Expense</small>
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0 me-1">{{ App\Models\Expense::sum('expense_cost') }}</h6>
                        </div>
                    </div>
                </div>
                <div class="d-flex p-4 pt-3">
                    <div class="avatar flex-shrink-0 me-3">
                        <img src="{{ asset('admin') }}/img/icons/unicons/wallet.png" alt="User" />
                    </div>
                    <div>
                        <small class="text-muted d-block">Expenses This Year</small>
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0 me-1">{{ App\Models\Expense::whereYear('expense_date', date('Y'))->sum('expense_cost') }}</h6>
                        </div>
                    </div>
                </div>
                <div class="d-flex p-4 pt-3">
                    <div class="avatar flex-shrink-0 me-3">
                        <img src="{{ asset('admin') }}/img/icons/unicons/wallet.png" alt="User" />
                    </div>
                    <div>
                        <small class="text-muted d-block">Expenses This Month</small>
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0 me-1">{{ App\Models\Expense::whereMonth('expense_date', date('m'))->sum('expense_cost') }}</h6>
                        </div>
                    </div>
                </div>
                <div class="d-flex p-4 pt-3">
                    <div class="avatar flex-shrink-0 me-3">
                        <img src="{{ asset('admin') }}/img/icons/unicons/wallet.png" alt="User" />
                    </div>
                    <div>
                        <small class="text-muted d-block">Expenses Today</small>
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0 me-1">{{ App\Models\Expense::whereMonth('expense_date', date('m'))->sum('expense_cost') }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Expense Overview -->
</div>
<div class="row">
    <!-- Purchase Summary Start -->
    <div class="col-md-12 col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Purchase Summary</h5>
            </div>
            <div class="card-body">
                <ul class="p-0 m-0">
                    @forelse ($purchase_summaries->take(6) as $purchase_summary)
                    <li class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                            <img src="{{ asset('admin') }}/img/icons/unicons/paypal.png" alt="User" class="rounded" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <small class="text-muted d-block mb-1">{{ $purchase_summary->purchase_date }}</small>
                                <h6 class="mb-0">{{ $purchase_summary->relationtosupplier->supplier_name }}</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                                <h6 class="mb-0">{{ $purchase_summary->grand_total }}</h6>
                                <span class="text-muted">{{ $purchase_summary->payment_status }}</span>
                            </div>
                        </div>
                    </li>
                    @empty
                    <div class="alert alert-danger">
                        <strong>Not Found</strong>
                    </div>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <!-- Purchase Summary End -->

    <!-- Selling Summary Start -->
    <div class="col-md-12 col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Selling Summary</h5>
            </div>
            <div class="card-body">
                <ul class="p-0 m-0">
                    @forelse ($selling_summaries->take(6) as $selling_summary)
                    <li class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                            <img src="{{ asset('admin') }}/img/icons/unicons/paypal.png" alt="User" class="rounded" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <small class="text-muted d-block mb-1">{{ $selling_summary->selling_date }}</small>
                                <h6 class="mb-0">{{ $selling_summary->relationtocustomer->customer_name }}</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                                <h6 class="mb-0">{{ $selling_summary->grand_total }}</h6>
                                <span class="text-muted">{{ $selling_summary->payment_status }}</span>
                            </div>
                        </div>
                    </li>
                    @empty
                    <div class="alert alert-danger">
                        <strong>Not Found</strong>
                    </div>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <!--/ Selling Summary End -->
</div>
@endsection

@section('script')
<script>

</script>
@endsection
