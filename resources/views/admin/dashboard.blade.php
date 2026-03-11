<!-- resources/views/admin/dashboard.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>
.small, small {
    font-size: 1.2em !important;
}
.text-white-50 {
    color: #fff !important;
}
.admin-widget {
  min-height: 120px;
  border-radius: 1rem;
  overflow: hidden;
  position: relative;
  background: transparent;
  transition: transform 0.18s;
}
.admin-widget:hover {
  transform: translateY(-4px) scale(1.02);
  box-shadow: 0 8px 32px rgba(44,62,80,0.08);
}
.widget-icon {
  width: 54px;
  height: 54px;
  background: rgba(255,255,255,0.14);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
  color: #fff;
  box-shadow: 0 2px 12px 0 rgba(0,0,0,0.06);
}
.widget-bg {
  position: absolute;
  left: 0; top: 0;
  width: 100%; height: 100%;
  z-index: 0;
  opacity: 0.92;
  pointer-events: none;
}
.widget-bg-blue {
  background: linear-gradient(135deg, #275efe 0%, #6fa3f7 100%);
}
.widget-bg-green {
  background: linear-gradient(135deg, #1d976c 0%, #93f9b9 100%);
}
.widget-bg-orange {
  background: linear-gradient(135deg, #fa8c16 0%, #ffe08a 100%);
}
.widget-bg-purple {
  background: linear-gradient(135deg, #7b2ff2 0%, #f357a8 100%);
}
.card.admin-widget .card-body {
  position: relative;
  z-index: 2;
}
</style>

<style>
.widget-bg-teal    { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
.widget-bg-yellow  { background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%); }
.widget-bg-cyan    { background: linear-gradient(135deg, #00c6ff 0%, #0072ff 100%); }
</style>
<style>
.widget-bg-red { background: linear-gradient(135deg, #f857a6 0%, #ff5858 100%); }
</style>

<div class="row g-4">
  <!-- Total Properties -->
  <div class="col-xl-3 col-md-6">
    <div class="card admin-widget border-0 shadow position-relative overflow-hidden">
      <div class="widget-bg widget-bg-blue"></div>
      <div class="card-body d-flex align-items-center">
        <div class="widget-icon flex-shrink-0">
          <i class="fas fa-building"></i>
        </div>
        <div class="ms-3">
          <div class="fw-bold text-white-50 small mb-1">Total Properties</div>
          <div class="h4 text-white mb-0">{{ $totalProperties }}</div>
        </div>
      </div>
    </div>
  </div>
  <!-- Active Listings -->
  <div class="col-xl-3 col-md-6">
    <div class="card admin-widget border-0 shadow position-relative overflow-hidden">
      <div class="widget-bg widget-bg-green"></div>
      <div class="card-body d-flex align-items-center">
        <div class="widget-icon flex-shrink-0">
          <i class="fas fa-check-circle"></i>
        </div>
        <div class="ms-3">
          <div class="fw-bold text-white-50 small mb-1">Active Listings</div>
          <div class="h4 text-white mb-0">{{ $activeProperties }}</div>
        </div>
      </div>
    </div>
  </div>
  <!-- Inactive Listings -->
  <div class="col-xl-3 col-md-6">
    <div class="card admin-widget border-0 shadow position-relative overflow-hidden">
      <div class="widget-bg widget-bg-orange"></div>
      <div class="card-body d-flex align-items-center">
        <div class="widget-icon flex-shrink-0">
          <i class="fas fa-times-circle"></i>
        </div>
        <div class="ms-3">
          <div class="fw-bold text-white-50 small mb-1">Inactive Listings</div>
          <div class="h4 text-white mb-0">{{ $inactiveProperties }}</div>
        </div>
      </div>
    </div>
  </div>
  <!-- Total Users -->
  <div class="col-xl-3 col-md-6">
    <div class="card admin-widget border-0 shadow position-relative overflow-hidden">
      <div class="widget-bg widget-bg-purple"></div>
      <div class="card-body d-flex align-items-center">
        <div class="widget-icon flex-shrink-0">
          <i class="fas fa-users"></i>
        </div>
        <div class="ms-3">
          <div class="fw-bold text-white-50 small mb-1">Total Users</div>
          <div class="h4 text-white mb-0">{{ $totalUsers }}</div>
        </div>
      </div>
    </div>
  </div>

<!-- Transactions -->
<div class="col-xl-3 col-md-6">
    <div class="card admin-widget border-0 shadow position-relative overflow-hidden">
      <div class="widget-bg widget-bg-teal"></div>
      <div class="card-body d-flex align-items-center">
        <div class="widget-icon flex-shrink-0">
          <i class="fas fa-exchange-alt"></i>
        </div>
        <div class="ms-3">
          <div class="fw-bold text-white-50 small mb-1">Transactions</div>
          <div class="h4 text-white mb-0">{{ $totalTransactions }}</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Revenue (Total AED) -->
  <div class="col-xl-3 col-md-6">
    <div class="card admin-widget border-0 shadow position-relative overflow-hidden">
      <div class="widget-bg widget-bg-yellow"></div>
      <div class="card-body d-flex align-items-center">
        <div class="widget-icon flex-shrink-0">
          <i class="fas fa-coins"></i>
        </div>
        <div class="ms-3">
          <div class="fw-bold text-white-50 small mb-1">Revenue (AED)</div>
          <div class="h4 text-white mb-0">AED {{ number_format($totalRevenue, 2) }}</div>
        </div>
      </div>
    </div>
  </div>

  <!-- New Users This Month -->
  <div class="col-xl-3 col-md-6">
    <div class="card admin-widget border-0 shadow position-relative overflow-hidden">
      <div class="widget-bg widget-bg-cyan"></div>
      <div class="card-body d-flex align-items-center">
        <div class="widget-icon flex-shrink-0">
          <i class="fas fa-user-plus"></i>
        </div>
        <div class="ms-3">
          <div class="fw-bold text-white-50 small mb-1">New Users (This Month)</div>
          <div class="h4 text-white mb-0">{{ $newUsersThisMonth }}</div>
        </div>
      </div>
    </div>
  </div>
  <!-- Pending Approvals -->
  <div class="col-xl-3 col-md-6">
    <div class="card admin-widget border-0 shadow position-relative overflow-hidden">
      <div class="widget-bg widget-bg-red"></div>
      <div class="card-body d-flex align-items-center">
        <div class="widget-icon flex-shrink-0">
          <i class="fas fa-hourglass-half"></i>
        </div>
        <div class="ms-3">
          <div class="fw-bold text-white-50 small mb-1">Pending Approvals</div>
          <div class="h4 text-white mb-0">{{ $pendingApprovals }}</div>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- You can add more widgets below for transactions, revenue, etc. -->

<div class="row mt-4">
  <div class="col-lg-8 mb-4">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <h6 class="mb-3">Properties Added Per Month ({{ now()->year }})</h6>
        <canvas id="propertiesBarChart" style="height:260px;"></canvas>
      </div>
    </div>
  </div>

  <div class="col-lg-4 mb-4">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <h6 class="mb-3">Listings Status</h6>
        <canvas id="propertyStatusChart" style="height:220px;"></canvas>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('propertiesBarChart').getContext('2d');
const propertiesBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($months),
        datasets: [{
            label: 'Properties',
            data: @json($propertyCounts),
            backgroundColor: 'rgba(52, 144, 220, 0.7)',
            borderRadius: 8,
            maxBarThickness: 34,
        }]
    },
    options: {
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});
</script>

<script>
const statusCtx = document.getElementById('propertyStatusChart').getContext('2d');
const propertyStatusChart = new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Active', 'Inactive'],
        datasets: [{
            data: [{{ $active }}, {{ $inactive }}],
            backgroundColor: [
                'rgba(16, 185, 129, 0.85)',  // Green
                'rgba(255, 107, 107, 0.85)'  // Red
            ],
            borderWidth: 1,
        }]
    },
    options: {
        plugins: {
            legend: { position: 'bottom' }
        },
        cutout: '70%',
    }
});
</script>
@endsection

