<div class="box bt-filter not-animated" data-animate="fadeInLeft" data-delay="200">
  <div class="box-heading"><h3><?php echo $heading_title; ?></h3></div>
    <div class="box-content"><div class="list">
    <?php foreach ($filter_groups as $filter_group) { ?>
    <a class="title"><?php echo $filter_group['name']; ?></a>
	<?php if($filter_group['show_image']=='image'){ ?>
		<div class="bt-filter-image">
			<div id="filter-group<?php echo $filter_group['filter_group_id']; ?>">
				<ul>
				<?php foreach ($filter_group['filter'] as $filter) { ?>
					<li <?php echo(in_array($filter['filter_id'], $filter_category))?'class="active"':''; ?>><a title="<?php echo $filter['name']; ?>" href="<?php echo $filter['filter_id']; ?>" ><img alt="<?php echo $filter['name']; ?>" src="<?php echo $filter['image']; ?>" /></a></li>
				<?php } ?>
				</ul>
			</div>
		</div>
	<?php }else{ ?>
		<div class="">
		  <div id="filter-group<?php echo $filter_group['filter_group_id']; ?>">
			<ul>
			<?php foreach ($filter_group['filter'] as $filter) { ?>
				<li <?php echo(in_array($filter['filter_id'], $filter_category))?'class="active"':''; ?>><a title="<?php echo $filter['name']; ?>" href="<?php echo $filter['filter_id']; ?>"><span class="fe-checkbox"></span> <?php echo $filter['name']; ?></a></li>
			<?php } ?>
			</ul>
		  </div>
		</div>
	<?php } ?>
	
    <?php } ?>
  </div></div>
</div>
<?php global $request;?>
<script type="text/javascript"><!--
var filter = [];
<?php if (isset($request->get['filter'])){ ?>
 <?php $filters =  explode(',', (string)$request->get['filter']); ?> 
	<?php foreach($filters as $filter){ ?>
	filter.push(<?php echo $filter; ?>);
	<?php } ?>
<?php } ?>
var idarr = '';
<?php foreach ($filter_groups as $filter_group) { ?>
	<?php if($filter_group == end($filter_groups)){ ?>
		mark = '';
	<?php }else{ ?>
		mark = ',';
	<?php } ?>
	idarr = idarr + '#filter-group<?php echo $filter_group['filter_group_id']; ?> ul li a'+ mark;
<?php } ?>
$(function () {
    $(idarr).click(function (event) {
      event.preventDefault();
	  $(this).parent('li').toggleClass('active');	  
	  var a = filter.indexOf(parseInt($(this).attr('href')));
	  if(a == -1){
		filter.push(parseInt($(this).attr('href')));
	  }else{
		filter.splice(a,1)
	  }
      var url = '<?php echo $action; ?>&filter=' + filter.join(',');
      $.ajax({
        type: 'GET',
        url: url,
        data: {},
        beforeSend: function( xhr ) {
			$("#tags-load").show();
        },
        complete: function (data) {          
          $('#content').html($("#content", data.responseText).html());
          history.pushState({
            page: url
          }, url, url);      
          $("#tags-load").hide();
		  handleGridList();
        }
      });
    });
});

$(document).ready(function(){

	$( document ).ajaxComplete(function() {

		//handleGridList();

	});
})
function handleGridList(){
	if (typeof boss_quick_shop == 'function') { 
		boss_quick_shop(); 
	}
	
	dataAnimate();
	
	$('#list-view').click(function() {
		$('#content .product-layout > .clearfix').remove();

		$('#content .product-layout').attr('class', 'product-layout product-list col-xs-12');

		localStorage.setItem('display', 'list');
	});

	// Product Grid
	$('#grid-view').click(function() {
		$('#content .product-layout').attr('class', 'product-layout product-grid col-md-4 col-sm-4 col-xs-12');	
		 localStorage.setItem('display', 'grid');
	});
	if (localStorage.getItem('display') == 'list') {
		$('#list-view').trigger('click');
	} else {
		$('#grid-view').trigger('click');
	}
}

//--></script> 
