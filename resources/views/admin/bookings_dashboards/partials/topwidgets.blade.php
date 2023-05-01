<!-- =========================================================== -->

<div class="row">
	<div class="col-lg-3 col-xs-6">

		<div class="small-box bg-yellow">
			<div class="inner">
				<h3>{!! @$todays_appointments !!}</h3>
				<h4>Today's Appointments</h4>
			</div>
			<div class="icon">
				<i class="fa fa-clock-o"></i>
			</div>

		</div>
	</div>
	<div class="col-lg-3 col-xs-6">
		<div class="small-box bg-aqua">
			<div class="inner">
				<h3>{!! @$this_weeks_appointments !!}</h3>
				<h4>This Week's Appointments</h4>
			</div>
			<div class="icon">
				<i class="fa fa-calendar-o"></i>
			</div>

		</div>
	</div>
	<div class="col-lg-3 col-xs-6">
		<div class="small-box bg-maroon">
			<div class="inner">
				<h3>{!! @$this_months_appointments !!}<sup style="font-size: 20px"></sup></h3>
				<h4>This Month's Appointment's</h4>
			</div>
			<div class="icon">
				<i class="fa fa-at"></i>
			</div>

		</div>
	</div>

	<div class="col-lg-3 col-xs-6">
		<div class="small-box bg-red">
			<div class="inner">
				<h3>{{ @$total_bookings }}</h3>
				<h4>Total Bookings</h4>
			</div>
			<div class="icon">
				<i class="fa fa-calendar"></i>
			</div>

		</div>
	</div>


	<div class="col-md-12">



	</div>


</div>

<div class="row">
	<div class="col-lg-3 col-xs-6">

		<div class="small-box bg-purple">
			<div class="inner">
				<h3>{!! @$todays_bookings !!}</h3>
				<h4>Today's Bookings</h4>
			</div>
			<div class="icon">
				<i class="fa fa-calendar"></i>
			</div>

		</div>
	</div>

	<div class="col-lg-3 col-xs-6">

		<div class="small-box bg-green">
			<div class="inner">
				<h3>{{ @$this_weeks_bookings }}</h3>
				<h4>This Week's Bookings</h4>
			</div>
			<div class="icon">
				<i class="fa fa-calendar"></i>
			</div>

		</div>
	</div>

	<div class="col-lg-3 col-xs-6">

		<div class="small-box bg-orange">
			<div class="inner">
				<h3> {{ @$this_months_bookings }}</h3>
				<h4>Bookings This Month</h4>
			</div>
			<div class="icon">
				<i class="fa fa-calendar"></i>
			</div>

		</div>
	</div>

	<div class="col-lg-3 col-xs-6">

		<div class="small-box bg-primary">
			<div class="inner">
				<h3>{!! @$last_months_bookings !!}</h3>
				<h4> Bookings Last Month </h4>
			</div>
			<div class="icon">
				<i class="fa fa-users "></i>
			</div>

		</div>
	</div>
</div>

<!-- =========================================================== -->