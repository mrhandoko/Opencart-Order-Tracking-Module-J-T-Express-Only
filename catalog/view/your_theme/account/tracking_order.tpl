<?php echo $header; ?><?php //echo $column_left; ?><?php //echo $column_right; ?>
<style>
	.control-label {
		text-align: left !important;
	}
	.form-group .col-xs-2 {
		padding-right: 0;
	}
</style>
<div class="rada-fake-23 hidden-xs hidden-sm">
	&nbsp;
</div>
<?php //echo $content_top; ?>
<div class="container" id="content">
	<div class="row">
		<div class="col-xs-12">
			<?php if ($error_warning) { ?>
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					<span class="sr-only">(error)</span>
					<?php echo $error_warning; ?>
				</div>
			<?php } ?>
			<div class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
					<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
				<?php } ?>
			</div>
	<div class="row">
		<div class="col-xs-12 col-md-8 col-md-offset-2">
			<h3><?php echo $heading_title; ?></h3>
			<br>
			<?php echo $text_details; ?>			
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
				<div class="form-group<?php echo ($error_order_id) ? " has-error has-feedback" : ""; ?>">
					<label for="order_id" class="col-xs-12 control-label">
						<span class="required">*</span> <?php echo $entry_order_id; ?>
					</label>
					<div class="col-xs-12">
						<textarea name="order_id" rows="5" value="<?php echo $order_id; ?>" class="form-control" id="order_id"><?php echo $order_id; ?></textarea>
						<?php if ($error_order_id) { ?>
							<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
							<span class="sr-only">(error)</span>
						<?php } ?>
					</div>
					<?php if ($error_order_id) { ?>
						<div class="col-xs-12 form-error">
							<?php echo $error_order_id; ?>
						</div>
					<?php } ?>
				</div>
		
				<div class="m-top-15">
					<div class="form-group" style="margin-bottom: 0;">
						<div class="col-xs-4">
							<button type="submit" class="btn btn-success"><?php echo $button_continue; ?></button>
						</div>
					</div>
				</div>
			</form>
			<?php if(!empty($tracking)) { ?>
			<br><br>
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th colspan="3">
							<center><h4>Tracking Result</h4></center>
						</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($tracking_result as $key) { ?>
					<?php $datetime = explode(' ', $key->acceptTime);
						$date = $datetime[0];
						$time = $datetime[1];
					?>
					<tr>
						<td><?=$date;?></td>
						<td><?=$time;?></td>
						<td><?=$key->acceptAddress?></td>
					</tr>
				<?php  }  ?>
				</tbody>
			</table>
			<?php } ?>
			<br>
			<?php echo $text_description; ?>	
		</div>
		</div>
		</div>
	</div>
</div>
<?php echo $content_bottom; ?>
<?php echo $footer; ?>
<?php exit; ?>
