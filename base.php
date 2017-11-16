<?

  function RedirectSeMancaCookie() {
    if(!isset($_COOKIE['idutente'])) header('Location: login.php');
  }
  function GeneraFormGroup($valore,$nomecampo,$placeholder,$readonly) {
    echo "<div class=\"form-group\">\n";
    echo "<label for=\"" .$nomecampo . "\" class=\"col-sm-2 control-label\">" . $placeholder. "</label>\n";
    echo "<div class=\"col-sm-10\">\n";
    echo "<input type=\"text\" class=\"form-control\" id=\"" . $nomecampo . "\"";
    echo " placeholder=\"" .$placeholder. "\" name=\"".$nomecampo."\"";
    if(isset($valore)) echo "value='" .$valore."'";
    if($readonly) echo "readonly";
    echo ">\n";
    echo "</div>\n";
    echo "</div>\n";
  }

  function ConnettiAlDB() {
    $username = "policeapps";
    $password = "";
    $host = "localhost";
    $database = "my_policeapps";
  
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    $conn->set_charset("utf8");
    return $conn;
  }

  function EscapeIfNotEMptyOrNull($conn,$nullableval) {
    return ($nullableval != '') ? $conn->real_escape_string($nullableval) : NULL;
  }

?>