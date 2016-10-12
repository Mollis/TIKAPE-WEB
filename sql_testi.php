<?php
   class MyDB extends SQLite3
   {
      function __construct()
      {
         $this->open('forum.db');
      }
   }
   $db = new MyDB();
   if(!$db){
      echo $db->lastErrorMsg();
   } else {
      echo "Opened database successfully\n";
   }

   $ret = $db->exec($sql);
   if(!$ret){
     echo $db->lastErrorMsg();
   } else {
      echo $db->changes(), " Record deleted successfully\n";
   }

   $sql =<<<EOF
      SELECT * from Kayttaja;
EOF;
   $ret = $db->query($sql);
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
   	  echo "<div class='container'>";
	  echo "<div class='row'>";
	  echo "<div class='col-md-4'>";
      echo "<strong>ID = ". $row['kayttaja_id'] . "</strong>";
	  echo "</div>";
	  echo "<div class='col-md-8'>";
      echo "NAME = ". $row['nimimerkki'] ."\n";
	  echo "</div>";
	  echo "</div>";
	  echo "</div>";
   }
   echo "Operation done successfully\n";
   $db->close();
?>