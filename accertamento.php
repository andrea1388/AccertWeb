<?
	include 'base.php';
  RedirectSeMancaCookie();
  $readonly=!isset($_REQUEST["edit"]);
  try {
    $id=$_REQUEST["id"];
  }
  catch (Exception $e) {};
	if(!empty($id)) {
    $conn = ConnettiAlDB();
    $stmt = $conn->prepare("SELECT * FROM Accertamento where idAccertamento=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
      die("id non trovato");
    };
    $row = $result->fetch_assoc();
    $nuovo=false;
    

    } else 
    {
      $nuovo=true;
      $readonly=false;
      $row['numero']="";    
      $row['anno']=""; 
      $row['data']="";
      $row['luogo']="";
      $row['descrizione']="";
      $row['descrizione_estesa']="";
      $row['targa']="";
    }

?>
<!DOCTYPE html>
<html lang="it">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accertamento</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
    <? include 'menu.php'; ?>
    <h1>Accertamento</h1>
    <div id="datigenerali">
    <form class="form-horizontal" method="post" action="salvaAccertamento.php">
    	<input type="hidden" name="id" value="<? echo $id; ?>">
      <? GeneraFormGroup($row['numero'],"numero","Numero",true); ?>
      <? GeneraFormGroup($row['anno'],"anno","Anno",true); ?>

      <div class="form-group">
          <label for="Data" class="col-sm-2 control-label">Data/Ora</label>
          <div class="col-sm-5">
            <input type="text" class="form-control" id="Data" placeholder="Data" name="Data" <? if(isset($row['data'])) echo "value='" .date("j/n/Y",strtotime($row['data']))."'"; ?><? if($readonly) echo "readonly";?>>
          </div>
          <div class="col-sm-5">
            <input type="text" class="form-control" id="Ora" placeholder="Ora" name="Ora" <? if(isset($row['data'])) echo "value='" .date("G:i:s",strtotime($row['data']))."'"; ?><? if($readonly) echo "readonly";?>>
          </div>
      </div>

      <? GeneraFormGroup($row['luogo'],"luogo","Luogo",$readonly); ?>
      <? GeneraFormGroup($row['descrizione'],"descrizione","Descrizione",$readonly); ?>


      <div class="form-group">
          <label for="Descrizioneestesa" class="col-sm-2 control-label">Descrizione estesa</label>
          <div class="col-sm-10">
          <textarea rows="4" cols="50" id="Descrizioneestesa" class="form-control"  placeholder="Descrizione estesa" name="descrizione_estesa" <? if($readonly) echo "readonly"; ?>> <? if(isset($row['descrizione_estesa'])) echo trim($row['descrizione_estesa']); ?></textarea>
          </div>
      </div>
      <? GeneraFormGroup($row['targa'],"targa","Targa",$readonly); ?>


	  <!--
		  Lista attività 
	  -->
    <? if(!$nuovo) :?>
      <div class="form-group">
          <label class="col-sm-2 control-label">Lista Attivit&agrave;</label>
          <div class="col-sm-10">
            <table class="table table-hover">
              <tr><td>Attivit&agrave;</td><td>Data</td></tr>
              <?
                  $stmt = $conn->prepare("SELECT * FROM Attivita where idAccertamento=?");
                  $stmt->bind_param("i", $_REQUEST["idAccertamento"]);
                  $stmt->execute();
                  $result = $stmt->get_result();
                  while($row = $result->fetch_assoc()) echo "<tr><td>".$row['descrizione']."</td><td>".date("G:i:s",strtotime($row['data']))."</td></tr>";
              ?>
            </table>          
          </div>
      </div>


	  <!--
		  Lista documenti 
	  -->
      <div class="form-group">
          <label class="col-sm-2 control-label">Lista Documenti</label>
          <div class="col-sm-10">
            <table class="table table-hover">
              <tr><td>Descrizione</td><td>Data documento</td><td></td><td></td></tr>
              <?
                  $stmt = $conn->prepare("SELECT * FROM Documento where idAccertamento=?");
                  $stmt->bind_param("i", $_REQUEST["idAccertamento"]);
                  $stmt->execute();
                  $result = $stmt->get_result();
                  while($row = $result->fetch_assoc()) {
                    echo "<tr><td>".$row['descrizione']."</td><td>".date("G:i:s",strtotime($row['dataDocumento']))."</td>\n";
                    echo "<td><a href='scaricafile.php?idDocumento=".$row['idDocumento']."'>Apri</a></td>";
                    echo "<td><a href='rimuovifile.php?idDocumento=".$row['idDocumento']."'>Elimina</a></td></tr>";
                  }
                  $conn->close();
              ?>
            </table>          
          </div>
      </div>
      <?php endif; ?> 
      
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default">Salva</button>
          <button type="button" class="btn btn-default" onclick="window.location='accertamento.php?edit&id=<? echo $id;?>'">Abilita modifiche</button>    

        </div>
      </div>
    </form>
    </div>

	</div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>
