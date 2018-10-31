<?php
require_once ('cms_fns.php');
require_once ('forms_fns.php');

page_header('Existing Contracts','main');
$user = str_replace("'","''",strtoupper($_SERVER['LOGON_USER']));
/*
text_search();
vend_dept_search();
department_search(); 
*/
?>
<script src="jquery-1.7.2.min.js"></script>
<script>
$(document).ready(function() {
	$('.searchtabs a').click(function() {
		
		var $this = $(this);
		$('.panel').hide();
		$('.searchtabs a.active').removeClass('active');
		$this.addClass('active').blur();
		var panel = $this.attr('href');
		$(panel).fadeIn(250);
		return false;
	}); //end click
	$('.searchtabs li:first a').click();
}); // end ready
</script>


<div class="searchpanels">
    <ul class="searchtabs">
		<li><a href="#textpanel">text search</a></li>
		<li><a href="#vendorpanel">vendor search</a></li>
		<li><a href="#deptpanel">department search</a></li>
	</ul>
    
	<div class="panelcontainer">
	
		<div class="panel" id="textpanel">
			<?php text_search(); ?>
		</div>
		
		<div class="panel" id="vendorpanel">
			<?php vend_dept_search(); ?>
		</div>
		
		<div class="panel" id="deptpanel">
			<?php department_search(); ?>
		</div>
		
	</div>
</div>




<?php
page_footer();
?>