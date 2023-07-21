<?php
	
include "conexao.php";
	
if(isset($_GET['doc']))
{
//URL do arquivo
$url = "docs/".$_GET['doc'];

//Limpando o cache
clearstatcache();

$sql = "SELECT * FROM arquivos WHERE Arquivo = '".$_GET['doc']."'";
$sql_temp = $CONN->query( $sql );
while($temp = $sql_temp->fetch(PDO::FETCH_ASSOC)){
	$NmArquivo             = $temp["NmArquivo"];
}

//Verificando se o caminho do arquivo existe ou não
if(file_exists($url)) {

//Definindo headers
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($NmArquivo).'"');
header('Content-Length: ' . filesize($url));
header('Pragma: public');

//Limpando buffer de saída do sistema
flush();

readfile($url,true);

//Fim
die();
}
else{
echo "O caminho do arquivo não existe.";
}
}
echo "O caminho do arquivo não está definido."


?>