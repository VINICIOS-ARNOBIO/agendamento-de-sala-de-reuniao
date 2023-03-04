<?php
include_once("../conexao/conexao.php");

?>

<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="style.css">

    <title>Agendar Salas</title>
</head>
<body>
<div class="container">

	<div class="row align-items-end" id="conteudo-principal">
    	<div class="col-6" id="col-verificar">
				<h4 class="verificar-titulo"><b>VERIFIQUE A DISPONIBILIDADE</b></h4><br>
					<form id="consultar-agendamento" method="POST" action="">
						<label class="sala label-verificar">Selecione uma data:</label>
							<div class="md-form md-outline input-with-post-icon datepicker">
								<input name="data" placeholder="Select date" type="date" id="example" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
							</div><br>
							<script>
								var input = document.getElementById('data');
								input.addEventListener('change', function() {
									if (input.value != '<?php echo date('Y-m-d'); ?>') {
										input.removeAttribute('readonly');
									}
								});
							</script>
						<label class="sala label-verificar">Salas de Reunião:</label>
						<select id="sala" name="sala" class="form-select"  required>
							<option value="" selected></option>
							<optgroup label="Bauru">
								<option value="sala 1">sala 1</option>
							</optgroup>
							<optgroup label="Itapetitinga">
								<option value="sala 2">sala 2</option>
							</optgroup>
							<optgroup label="São José do Rio Preto">
								<option value="sala 3">sala 3</option>
							</optgroup>
							<optgroup label="Sorocaba">
								<option value="sala 4">sala 4</option>
								<option value="sala 5">sala 5</option>
								<option value="sala 6">sala 6</option>
								<option value="sala 7">sala 7</option>
								<option value="sala 8">sala 8</option>
								<option value="sala 9">sala 9</option>
							</optgroup>
        				</select>
					</form>
			<?php
				if (isset($_POST['data'])) {
					$data = $_POST['data'];
					$sala = $_POST['sala'];
					$sql = "SELECT * FROM agendamentos WHERE sala = '$sala' AND data = '$data'";
					$result = $mysqli->query($sql);
					$horarios = array(
						"08:00:00 - 08:30:00",
						"08:30:00 - 09:00:00",
						"09:00:00 - 09:30:00",
						"09:30:00 - 10:00:00",
						"10:00:00 - 10:30:00",
						"10:30:00 - 11:00:00",
						"11:00:00 - 11:30:00",
						"11:30:00 - 12:00:00",
						"12:00:00 - 12:30:00",
						"12:30:00 - 13:00:00",
						"13:00:00 - 13:30:00",
						"13:30:00 - 14:00:00",
						"14:00:00 - 14:30:00",
						"14:30:00 - 15:00:00",
						"15:00:00 - 15:30:00",
						"15:30:00 - 16:00:00",
						"16:00:00 - 16:30:00",
						"16:30:00 - 17:00:00",
						"17:00:00 - 17:30:00",
						"17:30:00 - 18:00:00",
						"18:00:00 - 18:30:00",
						"18:30:00 - 19:00:00"
					);
					?>
					<br><label class="texto-disponibilidade"><b>Disponibilidade da sala de <?php echo $sala ?> no dia <?php echo date('d/m/Y', strtotime($data)); ?>:</b></label>
					<ul>
						<?php
						foreach ($horarios as $horario) {
							$disponivel = true;
							$result->data_seek(0);
							while ($row = $result->fetch_assoc()) {
								if ($horario >= $row['inicio'] && $horario < $row['termino']) {
									$disponivel = false;
									break;
								}
							}
							if ($disponivel) {
								echo "<li style='color:green; list-style-type: none'><b>$horario - Disponível</b></li>";
							} else {
								$assunto = $row['assunto'];
								$autor = $row['nome'];
								echo "<li style='color:red; list-style-type: none'><b>$horario - $assunto ($autor)</b></li>";
							}
						}
						?>
					</ul>
					<?php
				}
				?>
    			</div>
    	<div class="col-6" id="col-agendar">
		<h4 class="agendar-titulo"><b>AGENDE UMA SALA DE REUNIÃO</b></h4><br>
		<form id="meuFormulario" method="POST" action="processar.php" onsubmit="return validarHorarios()">
			<label class="label-agendar">Nome:</label>
			<input name="nome" placeholder="Seu nome" type="text" id="example" class="form-control" required><br>

			<label class="label-agendar">Assunto:</label>
			<input name="assunto" placeholder="Assunto" type="text" id="example" class="form-control" required><br>

			<label class="label-agendar">Sala de Reunião:</label>
						<select id="sala" name="sala" class="form-select"  required>
							<option value="" selected></option>
							<optgroup label="Bauru">
								<option value="sala 1">sala 1</option>
							</optgroup>
							<optgroup label="Itapetitinga">
								<option value="sala 2">sala 2</option>
							</optgroup>
							<optgroup label="São José do Rio Preto">
								<option value="sala 3">sala 3</option>
							</optgroup>
							<optgroup label="Sorocaba">
								<option value="sala 4">sala 4</option>
								<option value="sala 5">sala 5</option>
								<option value="sala 6">sala 6</option>
								<option value="sala 7">sala 7</option>
								<option value="sala 8">sala 8</option>
								<option value="sala 9">sala 9</option>
							</optgroup>
        				</select><br>

			<div class="md-form md-outline input-with-post-icon datepicker">
			<label class="sala label-agendar">Data do agendamento:</label>
			<input name="data" placeholder="Select date" type="date" id="example" class="form-control" required>
			</div><br><br>

			<table style="width:100%">
				<tr>
					<td>
						<label class="label-agendar" for="inicio">Horário de Início:</label>
						<!-- <input type="time" name="inicio" required step="1800"> -->
						<select id="appearance-select" name="inicio" placeholder="Select date" required>
								<option value="" selected>-- : --</option>
								<option value="08:00">08:00</option>
								<option value="08:30">08:30</option>
								<option value="09:00">09:00</option>
								<option value="09:30">09:30</option>
								<option value="10:00">10:00</option>
								<option value="10:30">10:30</option>
								<option value="11:00">11:00</option>
								<option value="11:30">11:30</option>
								<option value="12:00">12:00</option>
								<option value="12:30">12:30</option>
								<option value="13:00">13:00</option>
								<option value="13:30">13:30</option>
								<option value="14:00">14:00</option>
								<option value="14:30">14:30</option>
								<option value="5:00">15:00</option>
								<option value="15:30">15:30</option>
								<option value="16:00">16:00</option>
								<option value="16:30">16:30</option>
								<option value="17:00">17:00</option>
								<option value="17:30">17:30</option>
								<option value="18:00">18:00</option>
								<option value="18:30">18:30</option>
						</select>
					</td>
					<td>
						<label class="label-agendar"for="termino">Horário de Término:</label>
						<!-- <input type="time" name="termino" required step="1800"> -->
						<select id="appearance-select" name="termino" placeholder="Select date" required>
								<option value="" selected>-- : --</option>
								<option value="08:30">08:30</option>
								<option value="09:00">09:00</option>
								<option value="09:30">09:30</option>
								<option value="10:00">10:00</option>
								<option value="10:30">10:30</option>
								<option value="11:00">11:00</option>
								<option value="11:30">11:30</option>
								<option value="12:00">12:00</option>
								<option value="12:30">12:30</option>
								<option value="13:00">13:00</option>
								<option value="13:30">13:30</option>
								<option value="14:00">14:00</option>
								<option value="14:30">14:30</option>
								<option value="5:00">15:00</option>
								<option value="15:30">15:30</option>
								<option value="16:00">16:00</option>
								<option value="16:30">16:30</option>
								<option value="17:00">17:00</option>
								<option value="17:30">17:30</option>
								<option value="18:00">18:00</option>
								<option value="18:30">18:30</option>
								<option value="19:00">19:00</option>
						</select>
					</td>
				</tr>
			</table><br><br>			

			<input type="submit" class="btn btn-secondary btn-lg btn-block" value="Agendar">
		</form>
    	</div>
	</div>
</div>
		<script>
			$(document).ready(function() {
				$('#sala').on('change', function() {
					$('#consultar-agendamento').submit();
				});
			});
		</script>
		<script>
			var input = document.getElementById('data');
			input.addEventListener('change', function() {
			if (input.value != '<?php echo date('Y-m-d'); ?>') {
				input.removeAttribute('readonly');
			}
		});
		</script>
		<script>
			function validarHorarios() {
			var inicio = document.getElementsByName("inicio")[0].value;
			var termino = document.getElementsByName("termino")[0].value;
			
			if (termino <= inicio) {
				alert("O horário de término da reunião deve ser depois do horário de início.");
				return false;
			}
			
			return true;
			}
		</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
	<script src="script.js"></script>
</body>
</html>