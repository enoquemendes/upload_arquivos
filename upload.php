<?PHP

include "conexao.php";

date_default_timezone_set('America/Sao_Paulo');

$momento_atual = date('Y-m-d H:i:s');

//dados form
$file_tmp  = $_FILES["arquivo"]["tmp_name"];
$file_name = $_FILES["arquivo"]["name"];
$file_size = $_FILES["arquivo"]["size"];
$file_type = $_FILES["arquivo"]["type"];

//obtém a extensão
$file_ext  = explode(".", $file_name);
$file_ext = strtolower(end($file_ext));

//cria novo nome
$new_file_name = trim(md5(time() . $file_name) . '.' . $file_ext);

//storage
$storage_upload = 'docs/';
$path_storage = $storage_upload . $new_file_name;

$vazio = '';

if(move_uploaded_file($file_tmp, $path_storage))
{
  $messagem ='Upload realizado com sucesso!';
  
    //salva no banco
	$salvaarq = "INSERT INTO arquivos (NmArquivo, Descricao, Arquivo, Tipo, Tamanho, DtHrEnvio) VALUES (:NmArquivo, :Descricao, :Arquivo, :Tipo, :Tamanho, :DtHrEnvio)";
	$salva = $CONN->prepare($salvaarq);
	$salva->bindValue(':NmArquivo',$file_name);
	$salva->bindValue(':Descricao',$vazio);
	$salva->bindValue(':Arquivo',$new_file_name);
	$salva->bindValue(':Tipo',$file_type);
	$salva->bindValue(':Tamanho',$file_size);
	$salva->bindValue(':DtHrEnvio',$momento_atual);
	$executa_bd = $salva->execute();
  
}else{
	
  $messagem = 'Falha no upload. Verifique se você tem permissão para salvar esse arquivo.';

}

if($executa_bd){
	echo "Upload Realizado! Clique <a href='download.php?doc=".$new_file_name."'>aqui para fazer o download!";
}else{
	echo "Erro no Upload! Clique <a href='index.php'>Tente Novamente";
}

?>