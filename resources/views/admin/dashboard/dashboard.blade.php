@extends('admin.layouts.master')
@section('title','Dashboard')

@section('stylesheets')
<style>
	/* ===== Modern dashboard styling ===== */
	.dash-subheader {
		display:flex; align-items:center; justify-content:space-between;
		flex-wrap:wrap; gap:10px;
	}
	.dash-subheader h3 { margin:0; font-weight:600; color:#2c2e3e; }
	.dash-subheader .dash-date { color:#74788d; font-size:.95rem; }

	/* Stat cards - light shade format */
	.stat-card {
		position:relative; overflow:hidden; border:1px solid transparent; border-radius:14px;
		padding:15px 24px; height:100%;
		box-shadow:0 2px 10px rgba(0,0,0,.04);
		transition:transform .2s ease, box-shadow .2s ease;
	}
	.stat-card:hover { transform:translateY(-4px); box-shadow:0 10px 24px rgba(0,0,0,.10); }
	.stat-card .stat-icon {
		position:absolute; right:18px; top:50%; transform:translateY(-50%);
		font-size:3.5rem; line-height:1;
	}
	.stat-card .stat-label { font-size:.92rem; font-weight:600; letter-spacing:.3px; }
	.stat-card .stat-value { font-size:1.85rem; font-weight:700; line-height:1.1; margin-top:6px; }
	.stat-card .stat-sub  { font-size:.8rem; opacity:.85; margin-top:4px; }

	/* medium tinted backgrounds + accent colors */
	.bg-students      { background:#d9c6ef; border-color:#c4a9e6; }
	.bg-students      .stat-label,.bg-students .stat-value,.bg-students .stat-sub { color:#5a2d80; }
	.bg-students      .stat-icon { color:#7b4397; }

	.bg-subscriptions { background:#bfe9d6; border-color:#9bdcbd; }
	.bg-subscriptions .stat-label,.bg-subscriptions .stat-value,.bg-subscriptions .stat-sub { color:#0b6b5f; }
	.bg-subscriptions .stat-icon { color:#11998e; }

	.bg-users         { background:#fbe4b3; border-color:#f6d488; }
	.bg-users         .stat-label,.bg-users .stat-value,.bg-users .stat-sub { color:#9a6206; }
	.bg-users         .stat-icon { color:#e08e0b; }

	.bg-revenue       { background:#c4d7f2; border-color:#a3c0ea; }
	.bg-revenue       .stat-label,.bg-revenue .stat-value,.bg-revenue .stat-sub { color:#1d3c6e; }
	.bg-revenue       .stat-icon { color:#2a5298; }

	/* Period cards */
	.period-card {
		border:1px solid #ebedf3; border-radius:12px; background:#fff;
		padding:18px 20px; height:100%;
		box-shadow:0 2px 10px rgba(0,0,0,.04);
		transition:box-shadow .2s ease;
	}
	.period-card:hover { box-shadow:0 6px 18px rgba(0,0,0,.10); }
	.period-card .period-title {
		font-size:1.1rem; font-weight:600; text-transform:uppercase; letter-spacing:.5px;
		color:#177043; display:flex; align-items:center; gap:6px; margin-bottom:10px;
	}
	.period-row {
		display:flex; align-items:center; justify-content:space-between;
		padding:7px 0; border-bottom:1px dashed #eef0f5;
	}
	.period-row:last-child { border-bottom:0; }
	.period-row .lbl { color:#595d6e; font-size:1.1rem; display:flex; align-items:center; gap:6px; }
	.period-row .val { font-weight:700; color:#2c2e3e; font-size:1.05rem; }
	.dot { width:8px; height:8px; border-radius:50%; display:inline-block; }
	.dot-reg  { background:#7b4397; }
	.dot-sub  { background:#11998e; }
	.dot-rev  { background:#2a5298; }

	.chart-wrap { position:relative; height:360px; }
	.empty-chart { text-align:center; color:#a2a5b9; padding:60px 0; }
</style>
@endsection

@section('contents')

<!-- begin:: Content -->
<div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">

	<!-- Subheader -->
	<div class="dash-subheader" style="margin:6px 4px 22px 4px;">
		<h3><i class="flaticon2-line-chart kt-font-success"></i> &nbsp;Dashboard</h3>
		<span class="dash-date"><i class="flaticon2-calendar-3"></i> {{ \Carbon\Carbon::now()->format('l, d M Y') }}</span>
	</div>

	<!-- ===== Top stat cards ===== -->
	<div class="row">
		<div class="col-md-6 col-lg-3 mb-4">
			<div class="stat-card bg-students">
				<i class="flaticon-users-1 stat-icon"></i>
				<div class="stat-label">Students</div>
				<div class="stat-value">{{ number_format($stcount['stud_count']) }}</div>
				<div class="stat-sub">Total registrations</div>
			</div>
		</div>
		<div class="col-md-6 col-lg-3 mb-4">
			<div class="stat-card bg-subscriptions">
				<i class="flaticon-star stat-icon"></i>
				<div class="stat-label">Subscriptions</div>
				<div class="stat-value">{{ number_format($stcount['subs_count']) }}</div>
				<div class="stat-sub">Subscribed students</div>
			</div>
		</div>
		<div class="col-md-6 col-lg-3 mb-4">
			<div class="stat-card bg-users">
				<i class="flaticon2-user-outline-symbol stat-icon"></i>
				<div class="stat-label">Active Users</div>
				<div class="stat-value">{{ number_format($stcount['user_count']) }}</div>
				<div class="stat-sub">Currently active</div>
			</div>
		</div>
		<div class="col-md-6 col-lg-3 mb-4">
			<div class="stat-card bg-revenue">
				<i class="flaticon-coins stat-icon"></i>
				<div class="stat-label">Revenue</div>
				<div class="stat-value">₹{{ number_format($stcount['revenue']) }}</div>
				<div class="stat-sub">{{ number_format($stcount['pay_count']) }} payments received</div>
			</div>
		</div>
	</div>

	<!-- ===== Period breakdown ===== -->
	<div class="row">
		@php
			$periods = [
				['Today',  '🗓', 'td',  'tds',  'td'],
				['Weekly', '🗓', 'wek', 'weks', 'wek'],
				['Monthly','🗓', 'mon', 'mons', 'mon'],
				['Yearly', '🗓', 'yr',  'yrs',  'yr'],
			];
		@endphp
		@foreach($periods as $p)
			<div class="col-md-6 col-lg-3 mb-4">
				<div class="period-card">
					<div class="period-title"><span>{{ $p[1] }}</span> {{ $p[0] }}</div>
					<div class="period-row">
						<span class="lbl"><span class="dot dot-reg"></span> Registrations</span>
						<span class="val">{{ number_format($stcount[$p[2].'_count']) }}</span>
					</div>
					<div class="period-row">
						<span class="lbl"><span class="dot dot-sub"></span> Subscriptions</span>
						<span class="val">{{ number_format($stcount[$p[3].'_count']) }}</span>
					</div>
					<div class="period-row">
						<span class="lbl"><span class="dot dot-rev"></span> Revenue</span>
						<span class="val">₹{{ number_format($stcount[$p[4].'_rev']) }}</span>
					</div>
				</div>
			</div>
		@endforeach
	</div>
	

	<!-- ===== Analytics chart : active course-wise subscribed students ===== -->
	@php $datArr = json_decode($dat, true) ?: []; @endphp
	<div class="row">
		<div class="col-12">
			<div class="kt-portlet kt-portlet--height-fluid">
				<div class="kt-portlet__head">
					<div class="kt-portlet__head-label">
						<h3 class="kt-portlet__head-title" style="font-weight:700 !important;" >Course Subscriptions</h3>
						<span class="kt-portlet__head-desc" style="margin-left:10px;color:#74788d;">(Active)</span>
					</div>
					<div class="kt-portlet__head-toolbar">
						<a href="{{ url('question_attendees') }}" class="btn btn-primary">
							<i class="la la-list-alt"></i> Question Attendees
						</a>
						&nbsp;
						<a href="{{ url('attended_tests') }}" class="btn btn-brand">
							<i class="la la-check-circle"></i> Student Attended Tests
						</a>
					</div>
				</div>
				<div class="kt-portlet__body">
					@if(count($datArr) > 0)
						<div class="chart-wrap">
							<canvas id="qpAnalyticsChart"></canvas>
						</div>
					@else
						<div class="empty-chart">
							<i class="flaticon2-graph" style="font-size:3rem;"></i>
							<p style="margin-top:12px;">No active courses to display yet.</p>
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>

</div>
<!-- end:: Content -->

@endsection

@push('scripts')
@if(count($datArr) > 0)
<script>
	(function () {
		var labels = {!! json_encode(array_map('strval', array_column($datArr, 'y'))) !!};
		var counts = {!! json_encode(array_map('intval', array_column($datArr, 'a'))) !!};

		var ctx = document.getElementById('qpAnalyticsChart').getContext('2d');

		var grad = ctx.createLinearGradient(0, 0, 0, 360);
		grad.addColorStop(0, 'rgba(17,153,142,.95)');
		grad.addColorStop(1, 'rgba(56,239,125,.65)');

		new Chart(ctx, {
			type: 'bar',
			data: {
				labels: labels,
				datasets: [
					{
						label: 'Subscribed Students',
						data: counts,
						backgroundColor: grad,
						borderRadius: 6,
						maxBarThickness: 46
					}
				]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				legend: { position: 'top' },
				tooltips: { mode: 'index', intersect: false },
				scales: {
					xAxes: [{
						scaleLabel: { display: true, labelString: 'Course (Unique ID)' },
						gridLines: { display: false },
						ticks: { autoSkip: false }
					}],
					yAxes: [{
						scaleLabel: { display: true, labelString: 'Subscribed Students' },
						ticks: { beginAtZero: true, precision: 0 },
						gridLines: { color: '#eef0f5' }
					}]
				}
			}
		});
	})();
</script>
@endif
@endpush
