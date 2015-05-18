<footer><hr>
      <p>&copy; 2015 Glen Lauwers &middot; <a href="mailto:glenlauwers@hotmail.com">glenlauwers@hotmail.com</a></p>
    </footer>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="bootstrap-3.2.0/js/bootstrap-touch-carousel.js"></script>
    <script src="bootstrap-3.2.0/js/typeahead.js"></script>
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