<?php require_once(DIR_SYSTEM . 'library/btform.php'); $btform = new Btform();?>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
		  <div class="pull-right">
			<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
		  <h1><?php echo $heading_title; ?></h1>
		  <ul class="breadcrumb">
			<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
			<?php } ?>
		  </ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php if ($success) { ?>
		<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i><?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-slider" class="form-horizontal">
					<?php if(!empty($slider)){ ?>
					<table id="module" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<td width="50px">#id</td>
								<td width="20%px">Name</td>
								<td width="100px">Number slider</td>
								<td width="100px">Status</td>
								<td width="40%">Action</td>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1;?>
							<?php if(!empty($slider)){ ?>
							<tr>
								<td width="50px"><?php echo $slider['slider_id']; ?></td>
								<td width="20%px"><?php echo 'Slider '.$i; ?></td>
								<td width="100px"><?php echo $slider['total']; ?></td>
								<td width="100px"><?php echo ($status)?'Enable':'Disable'; ?></td>
								<td width="40%"><p><a class="btn btn-primary" href="<?php echo $slider['edit_link']; ?>" >Edit</a> <a class="btn btn-warning" href="<?php echo $slider['setting_link']; ?>" >Setting</a></p></td>
							</tr>
							<?php $i++;?>
							<?php }else{ ?>
								<tr><td colspan="6"><?php echo 'No slide'; ?></td></tr>
							<?php } ?>
						</tbody>
					</table>
					<?php } else{ ?>
					
					<div class="form-group">
					<div class="bt-button col-sm-12">
						<p><a class="btn btn-primary" href="<?php echo $modulesetting; ?>" >Create New Slider </a></p>
					</div>
					</div>
					
					<?php } ?>
					
					<div class="form-group">
					<div class="bt-support col-sm-12">
						<div class="about-module">
							<h2>ABOUT BOSS REVOLUTION SLIDER</h2>
							<ul>
								<li>Author: CodeSpot</li>
								<li>Version:  1.0</li>
								<li>Opencart Compatibility: v2.0.x</li>
								<li>Email: support@bossthemes.com</li>
							</ul>
							<p>Slider Revolution is a fully developed slide displaying system offering the capability to show images, videos and captions paired with simple, modern and fancy 3D transitions. On top of that, Slider Revolution is fully responsive and mobile optimized and can take on any dimensions.</p>
						</div>
						<div class="about-bossthemes">
							<h2>ABOUT BOSSTHEMES.COM</h2>
							<p>BossThemes.com is a Premium OpenCart Themes &amp; OpenCart Templates Provider. We have been implementing eCommerce solutions for over 10 years and our talented team has more than 50 developers and consultants passionate about eCommerce. Our deep understanding of ecommerce, user experience design and online marketing makes us the perfect choice to help you with your new Opencart ecommerce website. </p>
						</div>
					</div>
					</div>
				</form>
			
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>