<?php
include('bootstrapheader.php');
?>
<h1>FAQ 2</h1>
<div class="panel-group" id="accordion" style="margin-top: 20px">
<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse0">What is HTML?</a></h4></div><div id="collapse0" class="panel-collapse collapse"><div class="panel-body"><p>HTML stands for HyperText Markup Language. HTML is the main markup language for describing the structure of Web pages.</p></div></div></div><div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse1">What is Twitter Bootstrap?</a></h4></div><div id="collapse1" class="panel-collapse collapse"><div class="panel-body"><p>Twitter Bootstrap is a powerful front-end framework for faster and easier web development. It is a collection of CSS and HTML conventions.</p></div></div></div><div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse2">What is CSS?</a></h4></div><div id="collapse2" class="panel-collapse collapse"><div class="panel-body"><p>CSS stands for Cascading Style Sheet. CSS allows you to specify various style properties for a given HTML element such as colors, backgrounds, fonts etc.</p></div></div></div><div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Is HTML moeilijk?</a></h4></div><div id="collapse3" class="panel-collapse collapse"><div class="panel-body"><p><p>Nee, helemaal niet.</p></p></div></div></div><div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse4">Is CSS moeilijk?</a></h4></div><div id="collapse4" class="panel-collapse collapse"><div class="panel-body"><p><p>Ja, wel een beetje.</p></p></div></div></div></div>
</div>
<?= include('bootstrapfooter.php') ?></div>
</div>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="bootstrap-3.2.0/js/bootstrap.min.js"></script>
<script src="bootstrap-3.2.0/js/bootstrap-hover-dropdown.js"></script>
<script src="bootstrap-3.2.0/js/bootstrap-touch-carousel.js"></script>
<script src="fancybox/jquery.fancybox.js"></script>
<script>
$(function() {
  $(".navbar-toggle").click(function() {
		$('#menu').toggle('slide', { direction: 'left' }, 500);	
  });
  var url = window.location.pathname;
  var filename = url.substr(url.lastIndexOf('/') + 1);
	if (filename == 'nieuwsbrief.php'){
	  filename = 'nieuwsbrief.php?id=$id';
	}
  $('.navbar a[href$="' + filename + '"]').parent().addClass("active");
	$("a#registratielink").fancybox({
	  'autoDimensions' : true,
		'helpers' : {overlay : {closeClick: false}},
		'href': '#registratieformulier'}).trigger('click'); 		 	
});
</script>
</body>
</html>