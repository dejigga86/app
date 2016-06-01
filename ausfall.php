<html> 
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body> 
<?php 
session_start();
if(isset($_SESSION["login"]) && $_SESSION["login"]==1)
      {?>
<div id="body">
<div id="left">
<?php
    echo '<form action="login.php" method="post"><input type="submit" name="submit1" value="Ausloggen">  </form>     ';
?>
</div>
<div id="right">
<?php
        $pdo = new PDO('mysql:host=localhost;dbname=appdatenbank', 'root', '');   
        echo '<table class="ausgabe"><tr>'  ; 
        print "<td><u>Name</u></td>";
        if(isset($_SESSION['rang']) && $_SESSION['rang'] == 0 ){ print "<td><u>Fachbereich</u></td>";}
        print "<td><u>Fach</u></td><td><u>Datum</u></td><td><u>Zeit</u></td><td><u>Grund</u></td><td></td></tr>";
        
        if(isset($_SESSION['rang']) && $_SESSION['rang'] !=0)
        {
   	      $sql = 'SELECT * FROM ausfaelle INNER JOIN backend ON backend.backID = ausfaelle.UID WHERE UID='.$_SESSION["UID"];
          foreach ($pdo->query($sql) as $row) 
          {
            echo '<tr><td>'  ; 
            print $row['name'] . "</td><td>";
            print $row['Fach'] . "</td><td>";
            print $row['Datum'] . "</td><td>";
            print $row['Zeit'] . "</td><td>";
            print $row['Grund'] . "</td><td>";
            $heute=date("y.m.d") ;
            if($heute<$row['Datum']){print "Dropbutton </td>";}
            else{print "Datum vergangen.";}
            print "</tr>";
          }
        }  
        else if(isset($_SESSION['rang']) && $_SESSION['rang'] == 0 )
        {
   	      $sql = 'SELECT backend.name, backend.Fachbereich, ausfaelle.Fach, ausfaelle.Datum ,ausfaelle.Zeit, ausfaelle.Grund   FROM ausfaelle INNER JOIN backend ON backend.backID = ausfaelle.UID '; 
          foreach ($pdo->query($sql) as $row) 
          {  
            echo '<tr><td>'  ; 
            print $row['name'] . "</td><td>";
            print $row['Fachbereich']. "</td><td>";
            print $row['Fach'] . "</td><td>";
            print $row['Datum'] . "</td><td>";
            print $row['Zeit'] . "</td><td>";
            print $row['Grund'] . "</td><td>";
            $heute=date("y.m.d") ;
            if($heute<$row['Datum']){print "Dropbutton </td>";}
            else{print "Datum vergangen.";}
            print "</tr>";
          }
        }
        echo '</table>';
        if(!isset($_POST['submit2']))
        {
           echo '<br /><br /><br /> Einen Ausfall eintragen: <br /> ';
           echo ' <form action="" method="post"> ';
           print 'Fach: '."<br />".' <select name="fach">
           <option value="Mathematik III">Mathematik III</option>
           <option value="Projectrealisierung BITS">Projectrealisierung BITS</option>
           <option value="Datenbanken">Datenbanken</option>
           <option value="Informatik I">Informatik I</option>
           </select>'. "\t <br /> ";
           print 'Datum:'."<br />".' <input type="date" size="40"  maxlength="250" name="datum">'. "\t <br /> ";
           print 'Zeit:'."<br />".'<select name="zeit1">';
           for($hours=0; $hours<24; $hours++)
           echo '<option value="'.str_pad($hours,2,'0',STR_PAD_LEFT).'">'.str_pad($hours,2,'0',STR_PAD_LEFT).'</option>';
           echo' </select>'. "\t ";
           print '<select name="zeit2">
           <option value="00">00</option>
           <option value="15">15</option>
           <option value="30">30</option>
           <option value="45">45</option>
           </select>'. "\t <br /> ";               
           print ' Grund:'."<br />".'<textarea name="grund" cols="50" rows="10"></textarea>'. "\t <br /> ";
           echo '<input type="submit" name="submit2" value="Eintragen">  </form> <br /><br /><br /> ';        
        } 
        else
        {
          $zeit=$_POST['zeit1'];
          $zeit.=":";
          $zeit.=$_POST['zeit2'];
          $zeit.=":00";
          
          $sql=("INSERT INTO ausfaelle(Fach, Datum, Zeit, Grund, UID)VALUES('".$_POST['fach']."','".$_POST['datum']."', '"  .$zeit."','".$_POST['grund']."','".$_SESSION['UID']."') ");
          $insert=$pdo->prepare($sql);
          //$insert->execute();
          echo '<br /><br />Ausfall eingetragen:<br /> '.$_POST['fach'].' am '.$_POST['datum'].' um '.$_POST['zeit1'].":".$_POST['zeit2'].' aufgrund von '.$_POST['grund'].'<br /><br />';  
          echo '<form action="" method="post">
          <input type="submit" name="submit3" value="mehr eintragen">  </form>     ';
        }
        print "</div> ";
    }
else
{ 
    echo 'Sie sind nicht eingeloggt, bitte kehren Sie zum Login zurück und geben Sie ihre Daten ein. <a href="login.php">Login-Seite</a>';
} ?>
</body>
</html>