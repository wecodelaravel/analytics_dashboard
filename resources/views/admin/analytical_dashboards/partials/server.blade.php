{{-- ===========================================================  --}}
<div class="row">
	<div class="col-md-3 col-md-offset-8">
		<div class="box box-default collapsed-box">
			<div class="box-header with-border">
				<h3 class="box-title">Server Info</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				</div>
				<!-- /.box-tools -->
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<table class="table table-hover">
					<tr>
						<th>Name</th>
						<th>Version</th>
					</tr>
					<tr>
						<td>PHP</td>
						<td>{{  phpversion() }}</td>
					</tr>
					<tr>
						<td>Laravel</td>
						<td>{{ App::VERSION() }}</td>
					</tr>
					<tr>
						<td>CMS</td>
						<td>1.0.0</td>
					</tr>
				</table>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
</div>
{{-- ===========================================================  --}}