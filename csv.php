<body>
<div id="container">
<div id="form">

<?php
session_start();

$bdServidor = '25.71.230.218';
$bdUsuario = 'siscont';
$bdSenha = 'contabilidade';
$bdBanco = 'contabilidade';

$conexao = mysqli_connect($bdServidor, $bdUsuario, $bdSenha, $bdBanco);

if(mysqli_connect_errno($conexao)){
  echo "Erro na conexão!";
  die();
}

$deleterecords1 = "TRUNCATE TABLE BP"; //Esvaziar a tabela
$deleterecords2 = "TRUNCATE TABLE DRE"; //Esvaziar a tabela
$deleterecords3 = "TRUNCATE TABLE DFC"; //Esvaziar a tabela
mysqli_query($conexao, $deleterecords1);
mysqli_query($conexao, $deleterecords2);
mysqli_query($conexao, $deleterecords3);

//Transferir o arquivo
if (isset($_POST['submit'])) {

    if (is_uploaded_file($_FILES['filename']['tmp_name'])) {
        echo "<h1>" . "File ". $_FILES['filename']['name'] ." transferido com sucesso ." . "</h1>";
        echo "<h2>Exibindo o conteúdo:</h2>";
        readfile($_FILES['filename']['tmp_name']);
    }

    //Importar o arquivo transferido para o banco de dados
    $handle = fopen($_FILES['filename']['tmp_name'], "r");

    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $import_BP="INSERT into bp(conta_bp, ano1_bp, ano2_bp) values('$data[0]','$data[1]','$data[2]')";
        $import_DRE="INSERT into dre(conta_dre, ano1_dre, ano2_dre) values('$data[3]','$data[4]','$data[5]')";
        $import_DFC="INSERT into dfc(conta_dfc, ano1_dfc, ano2_dfc) values('$data[6]','$data[7]','$data[8]')";

        mysqli_query($conexao, $import_BP) or die(mysqli_error());
        mysqli_query($conexao, $import_DRE) or die(mysqli_error());
        mysqli_query($conexao, $import_DFC) or die(mysqli_error());
    }

    fclose($handle);

    print "Importação feita.";

//Visualizar formulário de transferência
} else {

    print "Transferir novos arquivos CSV selecionando o arquivo e clicando no botão Upload<br />\n";

    print "<form enctype='multipart/form-data' action='#' method='post'>";

    print "Nome do arquivo para importar:<br />\n";

    print "<input size='50' type='file' name='filename'><br />\n";

    print "<input type='submit' name='submit' value='Upload'></form>";

}

?>

</div>
</div>
</body>
