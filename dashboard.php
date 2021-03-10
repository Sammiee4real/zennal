<?php include ("header.php") ?>
<?php include ("sidebar.php") ?>
<?php //include ("nav.php") ?>

<div class="main-panel">
        <div class="main-content">  <!-- main-content -->
          <div class="content-wrapper">
            <div class="container-fluid"><!--Statistics cards Starts-->
<div class="row">
	<div class="col-xl-6 col-lg-6 col-md-6 col-12">
		<div class="card bg-white">
			<div class="card-body">
				<div class="card-block pt-2 pb-0">
					<div class="media">
						<div class="media-body white text-left">
							<h4 class="font-medium-5 card-title mb-0">$4567</h4>
							<span class="grey darken-1">Total Sales</span>
						</div>
						<div class="media-right text-right">
							<i class="icon-wallet font-large-1 warning"></i>
						</div>
					</div>
				</div>
				<div id="Widget-line-chart1" class="height-150 lineChartWidget WidgetlineChart1 mb-2">
				</div>

			</div>
		</div>
	</div>
	<div class="col-xl-6 col-lg-6 col-md-6 col-12">
		<div class="card bg-white">
			<div class="card-body">
				<div class="card-block pt-2 pb-0">
					<div class="media">
						<div class="media-body white text-left">
							<h4 class="font-medium-5 card-title mb-0">$9822</h4>
							<span class="grey darken-1">Total Value</span>
						</div>
						<div class="media-right text-right">
							<i class="icon-basket-loaded font-large-1 success"></i>
						</div>
					</div>
				</div>
				<div id="Widget-line-chart2" class="height-150 lineChartWidget WidgetlineChart2 mb-2">
				</div>
			</div>
		</div>
	</div>
</div>
<!--Statistics cards Ends-->

<!--Line with Area Chart 1 Starts-->
<div class="row match-height">
	<div class="col-xl-8 col-lg-12 col-12">
		<div class="card">
			<div class="card-header">
        		<div class="card-title-wrap bar-success">
					<h4 class="card-title">Product Valuation</h4>
				</div>
			</div>
			<div class="card-body">
				<div class="card-block">
					<div id="line-chart" class="height-300 lineChart lineChartShadow">						
					</div>
				</div>
			</div>
		</div>
	</div>
  <div class="col-xl-4 col-lg-12 col-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title-wrap bar-danger">
          <h4 class="card-title">Today's Activity</h4>
        </div>
      </div>
      <div class="card-body">
        <div class="col-12 timeline-left" id="activity">
          <div class="timeline">
            <ul class="list-unstyled base-timeline activity-timeline">
              <li class="">
                <div class="timeline-icon bg-danger">
                  <i class="fa fa-tasks"></i>
                </div>
                <div class="act-time">Today</div>
                <div class="base-timeline-info">
                  <a href="#" class="text-uppercase text-danger">Task Added</a>
                </div>
                <small class="text-muted">
                                    25 mins ago
                                </small>
              </li>
              <li class="">
                <div class="timeline-icon bg-primary">
                  <i class="fa fa-handshake-o"></i>
                </div>
                <div class="act-time">Yesterday</div>
                <div class="base-timeline-info">
                  <a href="#" class="text-uppercase text-primary">Deal Added</a>
                </div>
                <small class="text-muted">
                                    23 hours ago
                                </small>
              </li>
              <li class="">
                <div class="timeline-icon bg-dark">
                  <i class="fa fa-tasks"></i>
                </div>
                <div class="act-time">09 March</div>
                <div class="base-timeline-info">
                  <a href="#" class="text-uppercase text-dark">Task Updated</a>
                </div>
                <small class="text-muted">
                                    15 days ago
                                </small>
              </li>
              <li class="">
                <div class="timeline-icon bg-warning">
                  <i class="fa fa-handshake-o"></i>
                </div>
                <div class="act-time">04 March</div>
                <div class="base-timeline-info">
                  <a href="#" class="text-uppercase text-warning">Started Task</a>
                </div>
                <small class="text-muted">
                                    20 days ago
                                </small>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Line with Area Chart 1 Ends-->



            </div>
          </div>
        </div>

      <?php include ("footer.php") ?>  