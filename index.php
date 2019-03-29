<html>
<form action="index.php" method="POST">
<input type="text" id="cnpj" name="cnpj">
<button name="submit">Verificar</button>
</form>
</html>
<?php
if(isset($_POST['submit'])) {
	include_once 'Funcoes.php';
	$funcao = new Funcoes;

	$cnpj = $_POST['cnpj'];
	$cnpj = preg_replace("/[^0-9]/", "", $cnpj); //REMOVE TODAS AS LETRAS E CARACTERES ESPECIAIS QUE PODEM VIR NO PARAMENTRO(DEIXA APENAS NUMEROS)
	validaCnpj($cnpj);
}

function validaCnpj($cnpj){
	if(strlen($cnpj) < 14){
		?><p style="color:red"><?php echo 'CNPJ muito curto'; ?></p><?php
	}else{
		
		//-----PRIMEIRA PARTE DA VERIFICAÇÃO----------
		$pesos = array (5,4,3,2,9,8,7,6,5,4,3,2);
		$arrayCnpj = array();
		$soma = 0;
		$cnpjVerificador = "";
		
		for($x=0;$x<=11;$x++){
			$arrayCnpj[$x] = $cnpj[$x];
			$soma = ($cnpj[$x] * $pesos[$x]) + $soma;
			
			$cnpjVerificador = $cnpjVerificador . "" . $cnpj[$x] . "";
			
		}
		//$cnpjVerificador = ($soma % 11) == 1 ? $cnpjVerificador . "0" : "";
		if(($soma % 11) < 2){
			$cnpjVerificador = $cnpjVerificador . "" . "0"; 
		}else{
			$cnpjVerificador = $cnpjVerificador . "" .(11 - (($soma % 11)));
		}
		//-----SEGUNDA PARTE DA VERIFICAÇÃO----------
		$soma = 0;
		array_unshift($pesos,6,); //ADCIONA UM NOVO VALOR NOS PESOS.
		for($x=0;$x<=12;$x++){
			$soma = ($cnpj[$x] * $pesos[$x]) + $soma;
		}
			
		if(($soma % 11) < 2){
			$cnpjVerificador = $cnpjVerificador . "" . "0"; 
		}else{
			$cnpjVerificador = $cnpjVerificador . "" . (11 - (($soma % 11)));
		}
		//echo $cnpjVerificador; echo '<p>';
		//echo $cnpj;
		if($cnpj == $cnpjVerificador) {
			?><p style="color:blue"><?php echo 'CNPJ VÁLIDO'; ?></p><?php
		}else{
			?><p style="color:red"><?php echo 'CNPJ INVÁLIDO'; ?></p><?php
		}
	}	
}
?>