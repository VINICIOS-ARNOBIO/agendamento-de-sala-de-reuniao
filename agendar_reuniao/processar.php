<?php

include_once("../conexao/conexao.php");

// Obtém os dados do formulário
$nome = $_POST["nome"];
$assunto = $_POST["assunto"];
$sala = $_POST["sala"];
$data = $_POST["data"];
$inicio = $_POST["inicio"];
$termino = $_POST["termino"];


// Verifica se já existe uma reserva para a sala de reunião na data e horário selecionados
$sql = "SELECT * FROM agendamentos WHERE sala = '$sala' AND data = '$data' AND ((inicio <= '$inicio' AND termino > '$inicio') OR (inicio < '$termino' AND termino >= '$termino'))";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
  // Já existe uma reserva para o horário selecionado
  echo "Já existe uma reserva para a sala de reunião na data e horário selecionados. Por favor, selecione outro horário ou outra sala de reunião.";
} elseif($inicio > $termino) {
  //verifica se o horario fornecido é valido
  echo "Insira um horario valido, não é possivel que o horario de saida seja antes que o horario de entrada!!!!";
  echo "<br><br><a href='index.php'>Voltar</a>";

}else {
  // Insere os dados do agendamento da sala no banco de dados
  $sql = "INSERT INTO agendamentos (nome, assunto, sala, data, inicio, termino) VALUES ('$nome', '$assunto', '$sala', '$data', '$inicio', '$termino')";

  if ($mysqli->query($sql) === TRUE) {
    echo "Agendamento realizado com sucesso!";
    echo "<br><br><a href='index.php'>Voltar</a>";
  } else {
    echo "Erro ao agendar sala: " . $mysqli->error;
    echo "<br><br><a href='index.php'>Voltar</a>";
  }
}



$mysqli->close();

?>