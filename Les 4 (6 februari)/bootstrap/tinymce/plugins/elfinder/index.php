<?php session_start();
if (isset($_SESSION['webmaster'])){
echo <<<PAGINA
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>elFinder 2.0</title>
		<link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
		<link rel="stylesheet" type="text/css" media="screen" href="css/elfinder.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/theme.css">

		<script type="text/javascript" src="js/plugin.min.js"></script>
		<script src="js/i18n/elfinder.nl.js"></script>
		<script type="text/javascript" charset="utf-8">
		var FileBrowserDialogue = {
      init: function() {
      },
      mySubmit: function (URL) {
      parent.tinymce.activeEditor.windowManager.getParams().setUrl(URL);
      parent.tinymce.activeEditor.windowManager.close();
      }
    }
			$().ready(function() {
				var elf = $('#elfinder').elfinder({
				  lang: 'nl',
					url: 'php/connector.php',
					getFileCallback: function(file) {
            FileBrowserDialogue.mySubmit(file); 
      }
				}).elfinder('instance');
			});
		</script>
	</head>
	<body>
		<div id="elfinder"></div>
	</body>
</html>
PAGINA;
}
?>
