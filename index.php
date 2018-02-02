<?php
try {
	$pdo = new PDO("mysql:dbname=projeto_comentarios;host=localhost", "root", "root");
} catch(PDOException $e) {
	echo "ERRO: ".$e->getMessage();
	exit;
}

if(isset($_POST['nome']) && empty($_POST['nome']) == false) {
	$nome = $_POST['nome'];
	$mensagem = $_POST['mensagem'];

	$sql = $pdo->prepare("INSERT INTO mensagens SET nome = :nome, msg = :msg, data_msg = NOW()");
	$sql->bindValue(":nome", $nome);
	$sql->bindValue(":msg", $mensagem);
	$sql->execute();
}
?>
<fieldset>
	<form method="POST">
		Nome:<br/>
		<input type="text" name="nome" /><br/><br/>

		Mensagem:<br/>
		<textarea name="mensagem"></textarea><br/><br/>

		<input type="submit" value="Enviar Mensagem" />
	</form>
</fieldset>
<br/><br/>

<?php
$sql = "SELECT * FROM mensagens ORDER BY data_msg DESC";
$sql = $pdo->query($sql);
if($sql->rowCount() > 0){
	foreach($sql->fetchAll() as $mensagem):
		?>
		<strong><?php echo $mensagem['nome']; ?></strong>-
		<?php  $dt=$mensagem['data_msg'];
				$year=substr($dt, 0,4);
				$month=substr($dt, 5,2);
				$day=substr($dt, 8,2);
				$hr=substr($dt, 10,6);
		echo $day."/".$month."/".$year."--".$hr; ?><br/>
		<?php echo $mensagem['msg']; ?>
		<hr/>
		<?php
	endforeach;
} else {
	echo "Não há mensagens.";
}
?>













