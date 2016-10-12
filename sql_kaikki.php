<!DOCTYPE html>
<html>
	<head>
        <link type = "text/css" rel="stylesheet" href="stylesheet.css"/>
        <title>FORUM</title>
        <meta charset="UTF-8">
        <meta name="description" content="Foorumi">
        <meta name="keywords" content="HTML,CSS,XML,JavaScript">
        <meta name="author" content="Harri Huttunen" >

            <!-- Bootstrap -->
	    <link href="css/bootstrap.min.css" rel="stylesheet">
	    <!-- Custom styles for this template -->
	    <link href="/navbar/navbar.css" rel="stylesheet">
	    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->	
	</head>
	<body>
	<?php 
		class MyDB extends SQLite3 {
			function __construct() {
				$this->open('forum.db');
			}
		}
		$db = new MyDB();
		
		   if(!$db){
		      echo $db->lastErrorMsg();
		   } else {
		      echo "Opened database successfully\n";
		   }
		$tietokoneet = "SELECT * FROM Viesti LEFT JOIN Kayttaja ON Viesti.lahettaja = Kayttaja.kayttaja_id AND Viesti.alue = 1 AND Viesti.lainattu_viesti IS NULL";
		
		
		$ret = $db->query($tietokoneet);
		echo "<h1>Alue: Tietokoneet</h1>";
		echo "<p>Otsikot</p>";
		while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
		    
		?>
		<div class = "well">
			<button type='button' class='btn btn-primary btn-lg' data-toggle='modal' data-target='#myModal<?php echo $row['viesti_id']; ?>'><?php echo $row['otsikko'];?></button> 
			<span class = 'label label-info'><?php echo date('F j Y', strtotime($row['pvm_kellonaika']))?></span>
			<br>
			<div class = 'modal-fade' id = 'myModal<?php echo $row['viesti_id'];?>' tabindex = '-1' role = 'dialog' arial-labelledby = 'portfolioModallabel' aria-hidden='true'>
		    <div class="modal-dialog" role = "document">
		        <div class="modal-content">
		            <div class="modal-header">
		                <h4 class="modal-title" id="portfolioModallabel"><?php echo $row['otsikko']; ?></h4>
		            </div>
		            <div class = "modal-body text-center">
		            	<p class="line-height-medium"><?php $row['viesti'];?></p>
		            </div>
		            <?php
		            	$haku = "SELECT * FROM Viesti WHERE alue = 1 AND lainattu_viesti =" . $row['viesti_id'];
						$ret2 = $db->query($haku);
						$puoli = true;
						while($row2 = $ret2->fetchArray(SQLITE3_ASSOC)) {
							
						if($puoli) {
					?>	
		            	<div class="modal-body text-left">
		                	<span class ="label label-success" data-toggle="tooltip" data-placement="left" title = "<?php $row2['otsikko'];?>"><?php echo $row2['viesti']; ?></span>
		            	</div>
					<?php
						} else {
					?>
						<div class="modal-body text-right">
		                	<p class="line-height-small"><?php echo $row2['viesti']. ' || Lähettäjä: ' . $row2['lahettaja_id']; ?></p>
						</div>
					<?php
					 }if ($puoli) {
					 	$puoli = false;
					 } else {
					 	$puoli = true;
					 }}
					?>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		            </div>
		        </div>
					
			</div>
			
			</div>
		</div>
		<?php  
		}
		$db->close();

		
		?>

		

	<script>
	$(document).ready(function()){
		$('[data-toggle="tooltip"]').tooltip();
	});	
	</script>
	</body>
