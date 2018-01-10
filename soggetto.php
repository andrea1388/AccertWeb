<?
  class Soggetto {
    public $nome;
    public $societa;
    public $dataNascita;
    public $luogoNascita;
    public $residenza;
    public $indirizzo;
    public $tel;
    public $mail;
    public $documento;
    public $idSoggetto;

  }
	include 'base.php';
  RedirectSeMancaCookie();
  $conn = ConnettiAlDB();
  $idaccertamento=isset($_REQUEST["idAccertamento"])? intval($_REQUEST["idAccertamento"]) : 0;
  $ruolo=isset($_REQUEST["ruolo"])? intval($_REQUEST["ruolo"]) : 0;
  $descrizioneruolo=isset($_REQUEST["descrizioneruolo"])? EscapeIfNotEMptyOrNull($conn,$_REQUEST["descrizioneruolo"]) : NULL;  
	if(!empty($_REQUEST["idSoggetto"])) {
    $stmt = $conn->prepare("SELECT * FROM Soggetto where idSoggetto=?");
    $stmt->bind_param("i", $_REQUEST["idSoggetto"]);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
      die("id non trovato");
    };
    $sogg=$result->fetch_object("Soggetto");
    $nuovo=false;
    $readonly=!isset($_REQUEST["edit"]);
  } else {
      $nuovo=true;
      $sogg=new Soggetto();
      $dn="";
      $readonly=false;
      if(isset($_REQUEST["nome"])) $sogg->nome=$_REQUEST["nome"];
  }
  $conn->close();
    
?>
<!DOCTYPE html>
<html lang="it">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Soggetto</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
    <? include 'menu.php'; ?>
    <h1>Soggetto</h1>
    <div id="datigenerali">
    <form class="form-horizontal" method="post" action="salvaSoggetto.php">
      <input type="hidden" name="idSoggetto" value="<?echo $sogg->idSoggetto; ?>">
      <input type="hidden" name="idAccertamento" value="<?echo $idaccertamento; ?>">
      <input type="hidden" name="ruolo" value="<?echo $ruolo; ?>">
      <input type="hidden" name="descrizioneruolo" value="<?echo $descrizioneruolo; ?>">
      <? GeneraFormGroup($sogg->nome,"nome","Nome",$readonly); ?>
      <? GeneraFormGroup($sogg->societa,"societa","Societ&agrave;",$readonly); ?>
      <? GeneraFormGroup(FormattaData($sogg->dataNascita,"d/m/Y"),"dataNascita","Data di nascita",$readonly); ?>
      <? GeneraFormGroup($sogg->luogoNascita,"luogoNascita","Luogo di nascita",$readonly); ?>
      <? GeneraFormGroup($sogg->residenza,"residenza","Luogo di residenza o domicilio",$readonly); ?>
      <? GeneraFormGroup($sogg->indirizzo,"indirizzo","Indirizzo",$readonly); ?>
      <? GeneraFormGroup($sogg->tel,"tel","Telefono",$readonly); ?>
      <? GeneraFormGroup($sogg->mail,"mail","e-mail",$readonly); ?>
      <? GeneraFormGroup($sogg->documento,"documento","Documento",$readonly); ?>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default">Salva</button>
          <? if($readonly) :?>
          <button type="button" class="btn btn-default" onclick="window.location='soggetto.php?edit&idSoggetto=<? echo $_REQUEST["idSoggetto"];?>'">Abilita modifiche</button>    
          <?php endif; ?> 
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
