<?php session_start();
if (isset($_GET['pagina'])){
  $pagina = $_GET['pagina'];
}
if (isset($_GET['tabel'])){
  $tabel = $_GET['tabel'];
}
$titel = ucfirst($pagina);	
include('bootstrapheader.php');
if ((isset($_SESSION['webmaster']))OR(isset($_SESSION['assistent']))){
if ($pagina != 'nieuw'){
  $sql="SELECT * FROM $tabel WHERE onderwerp = '$pagina'";
  $resultaat = $db->query($sql);	
  if ($regel = $resultaat->fetch_array()){
    $onderwerp = $regel['onderwerp'];	
    $inhoud = $regel['inhoud'];
	  $id = $regel['id'];
  }
	$resultaat->free();
}
if ($pagina == 'nieuw'){
  $onderwerp = 'nieuw';
}
if (isset($_POST['inhoud'])){
$inhoud = $db->real_escape_string($_POST['inhoud']);
$onderwerp = $_POST['onderwerp'];
$rubriek = $_POST['rubriek'];
$id = $_POST['id'];
$datum = date("Y-m-d");
if ($inhoud == ""){
  echo "<script>window.document.location=\"$_SERVER[PHP_SELF]?tabel=$tabel&pagina=$pagina\"</script>";
}  
else {
  if (($pagina == 'nieuw')AND($tabel != 'faq_bootstrap')){
	  $sql = "INSERT INTO $tabel (onderwerp, inhoud, datum) VALUES ('$onderwerp', '$inhoud', '$datum')";
  }
	if (($pagina == 'nieuw')AND($tabel == 'faq_bootstrap')){
	  $sql = "INSERT INTO $tabel (vraag, antwoord, rubriek) VALUES ('$onderwerp', '$inhoud', '$rubriek')";
  }
  if ($pagina != 'nieuw'){
    $sql = "UPDATE $tabel SET inhoud = '$inhoud' WHERE id = '$id'";	
  }
	$resultaat = $db->query($sql);	
	if ($pagina == 'nieuw'){
	  echo "<script>window.document.location=\"home.php\"</script>";
	}
	elseif ($tabel == 'content_bootstrap'){
	  echo "<script>window.document.location=\"$onderwerp.php\"</script>";
	}
	elseif ($tabel == 'nieuwsbrieven_bootstrap'){
	  echo "<script>window.document.location=\"nieuwsbrief.php?id=$id\"</script>";
	}
	elseif ($tabel == 'faq_bootstrap'){
	  echo "<script>window.document.location=\"faq.php\"</script>";
	}
}	
}	
if (isset($_POST['verwijderen'])){
  $id = $_POST['id'];
  $sql="DELETE from $tabel WHERE id = '$id'";
	$resultaat = $db->query($sql);	
	echo "<script type=\"text/javascript\">window.document.location=\"home.php\"</script>";
}
}
?>
<h1>Update <?php echo "$pagina"; ?></h1>
<form id="updateformulier" action="<?php echo "$_SERVER[PHP_SELF]?tabel=$tabel&pagina=$pagina"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return postForm()">
<input type="hidden" name="id" value="<?php echo "$id"; ?>">
<label for="onderwerp">Onderwerp</label>
<p><input class="form-control" style="width: 50%" type="text" name="onderwerp" value="<?php echo "$onderwerp"; ?>"></p>
<?php if ($tabel == 'faq_bootstrap'){?>
<label for="rubriek">Rubriek</label>
<p><input class="form-control" style="width: 50%" type="text" name="rubriek" value="<?php echo "$rubriek"; ?>"></p>
<?php } ?>
<p><textarea id="editor" name="inhoud"><?php echo "$inhoud"; ?></textarea></p>
<button type="submit" class="btn btn-primary" name="opslaan">Opslaan</button>
<button type="submit" class="btn btn-primary" name="verwijderen">Verwijderen</button>
</form>
<script>
tinymce.init({
    content_css : ["bootstrap-3.2.0/css/bootstrap.min.css", "bootstrapstijlblad.css"],
    file_browser_callback : elFinderBrowser,
    selector: "textarea",
		language: "nl",
		height: "300", 
    menu : { 
        edit   : {title : 'Edit'  , items : 'undo redo | cut copy paste pastetext | selectall'},
        insert : {title : 'Insert', items : 'link | image'},
        format : {title : 'Format', items : 'formats | removeformat'},
        table  : {title : 'Table' , items : 'inserttable tableprops deletetable | cell row column'},
        tools  : {title : 'Tools' , items : 'code fullscreen'}
    },
    save_enablewhendirty: true,
    save_onsavecallback: function() {document.getElementById('updateformulier').submit();},
		plugins: ["textcolor", "elfinder", "save", "link", "image", "code", "fullscreen", "table"],
		toolbar: [
        "formats save undo redo | bold italic underline forecolor | bullist numlist | link image | alignleft aligncenter alignright alignjustify | code fullscreen"
    ]
 });
function elFinderBrowser (field_name, url, type, win) {
    tinymce.activeEditor.windowManager.open({
    file: 'tinymce/plugins/elfinder/index.php',
    title: 'Afbeeldingen',
    width: 1000,  
    height: 450,
    resizable: 'yes'
  }, {
    setUrl: function (url) {
      win.document.getElementById(field_name).value = url;
    }
  });
  return false;
} 
var postForm = function() {
	var inhoud = $('textarea[name="inhoud"]').html($('#editor').code());
}
</script>
<?php
include('bootstrapfooter.php');
?>
