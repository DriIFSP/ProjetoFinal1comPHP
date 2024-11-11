<?php

$dir = "img/"; 
$nome= $_POST["func"];
$valor= $_POST["valor"];
$arquivo = $_FILES["foto"];
$foto = $_FILES['foto']['name'];


if($nome == "" || $valor == "" | $foto == "")
{
    echo "<script> 
        alert('Preencha todos os campos');
        history.back();
    </script>";
}
else
{
  
    if (move_uploaded_file($arquivo["tmp_name"], "$dir/".$arquivo["name"]))
    {
        echo "<script> 
          alert('Foto transferida');
        </script>";
    }
    else {
        echo "<script> 
        alert('Erro ao carregar o arquivo');
        history.back();
        </script>";
    } 

}

if($valor < 500.00)
  $bonus = $valor *0.01;
elseif($valor < 3001.00)
  $bonus = $valor *0.05;
elseif ($valor < 1001.00)
  $bonus = $valor *0.1;
else
  $bonus = $valor * 0.15;

$ano = date("Y");
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');
$mes =  strftime("%B");
$caminho = $dir.$foto;
echo $caminho;

//----------------------------------------------------------------
//INCLUSÃO NO BANCO DE DADOS
include 'conecta.inc';

$resul = mysqli_query($con, "Select * from tbfuncmes where mes='$mes'and ano='$ano'") or die ("Erro na consulta");
$total = mysqli_num_rows($resul);
if($total < 1)
{
    $sql= "Insert into tbfuncmes (nome, vrvenda, vrbonus, caminhoimg, mes, ano) values ('$nome',
    '$valor','$bonus','$caminho', '$mes', '$ano')";
    mysqli_query($con, $sql) or die ("Erro inclusão");
    echo "<script> alert ('Funcionário do mês incluído com sucesso!');
        history.back();
   </script>";
}
else
{
    echo "<script> alert ('Já foi cadastrado funcionário neste mês e ano anteriormente');
    history.back();
    </script>";
}


?>