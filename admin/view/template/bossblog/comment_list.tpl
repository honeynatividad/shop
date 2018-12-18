<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
		  <div class="pull-right"><a href="<?php echo $insert; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a> <a href="<?php echo $repair; ?>" data-toggle="tooltip" title="<?php echo $button_rebuild; ?>" class="btn btn-default"><i class="fa fa-refresh"></i></a>
			<button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-blog-comment').submit() : false;"><i class="fa fa-trash-o"></i></button>
		  </div>
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
		<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" id="module">
					<li><a href="<?php echo $boss_category; ?>"> <?php echo $text_boss_category; ?></a></li>
					<li><a href="<?php echo $boss_articles; ?>"> <?php echo $text_boss_articles; ?></a></li>
					<li class="active"><a href="<?php echo $boss_comments; ?>"> <?php echo $text_boss_comments; ?></a></li>							
					<li><a href="<?php echo $boss_settings; ?>"> <?php echo $text_boss_settings; ?></a></li>							
				</ul>
				<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-blog-comment" class="form-horizontal">
				<table class="table table-bordered table-hover">
					  <thead>
						<tr>
						  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
						  <td class="text-left"><?php if ($sort == 'bad.name') { ?>
							<a href="<?php echo $sort_article; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_article; ?></a>
							<?php } else { ?>
							<a href="<?php echo $sort_article; ?>"><?php echo $column_article; ?></a>
							<?php } ?></td>
						  <td class="text-left"><?php if ($sort == 'bc.author') { ?>
							<a href="<?php echo $sort_author; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_author; ?></a>
							<?php } else { ?>
							<a href="<?php echo $sort_author; ?>"><?php echo $column_author; ?></a>
							<?php } ?></td>
						  <td class="text-left"><?php if ($sort == 'bc.email') { ?>
							<a href="<?php echo $sort_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_email; ?></a>
							<?php } else { ?>
							<a href="<?php echo $sort_email; ?>"><?php echo $column_email; ?></a>
							<?php } ?></td>
						  <td class="text-left">
							  <?php echo $column_comment; ?>
							</td>
						  <td class="text-right"><?php if ($sort == 'bc.status') { ?>
							<a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
							<?php } else { ?>
							<a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
							<?php } ?></td>
						  <td class="text-left"><?php if ($sort == 'bc.date_added') { ?>
							<a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
							<?php } else { ?>
							<a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
							<?php } ?></td>
						  <td class="text-right"><?php echo $column_action; ?></td>
						</tr>
					  </thead>
					  <tbody>
						<?php if ($comments) { ?>
						<?php foreach ($comments as $comment) { ?>
						<tr>
						  <td class="text-center"><?php if ($comment['selected']) { ?>
							<input type="checkbox" name="selected[]" value="<?php echo $comment['blog_comment_id']; ?>" checked="checked" />
							<?php } else { ?>
							<input type="checkbox" name="selected[]" value="<?php echo $comment['blog_comment_id']; ?>" />
							<?php } ?></td>
						  <td class="text-left"><?php echo $comment['name']; ?></td>
						  <td class="text-left"><?php echo $comment['author']; ?></td>
						  <td class="text-right"><?php echo $comment['email']; ?></td>
						  <td class="text-left"><?php echo $comment['text']; ?></td>
						  <td class="text-right"><?php echo $comment['status']; ?></td>
						  <td class="text-right"><?php echo $comment['date_added']; ?></td>
						  <td class="text-right"><a href="<?php echo $comment['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
						</tr>
						<?php } ?>
						<?php } else { ?>
						<tr>
						  <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
						</tr>
						<?php } ?>
					  </tbody>
					</table>
					
				</form>
				<div class="row">
				  <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
				  <div class="col-sm-6 text-right"><?php echo $text_pagination; ?></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>