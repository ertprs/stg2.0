<title>Termo TCD</title>
<?
$termotcdmanual[0]->termo_tcd = str_replace("</html>", '', $termotcdmanual[0]->termo_tcd);
$termotcdmanual[0]->termo_tcd = str_replace("</body>", '', $termotcdmanual[0]->termo_tcd);

$listprocedimentos = '';
foreach($procedimentos as $item){ $listprocedimentos .= $item->procedimento.", "; }
$termotcdmanual[0]->termo_tcd = str_replace("_empresa_", $empresas[0]->razao_social, $termotcdmanual[0]->termo_tcd);
$termotcdmanual[0]->termo_tcd = str_replace("_pacientes_", $pacientes[0]->nome, $termotcdmanual[0]->termo_tcd);
$termotcdmanual[0]->termo_tcd = str_replace("_emp_endereco_", '', $termotcdmanual[0]->termo_tcd);
$termotcdmanual[0]->termo_tcd = str_replace("_emp_cnpj_", preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $empresas[0]->cnpj), $termotcdmanual[0]->termo_tcd);
$termotcdmanual[0]->termo_tcd = str_replace("_rg_paciente_", $pacientes[0]->rg, $termotcdmanual[0]->termo_tcd);
$termotcdmanual[0]->termo_tcd = str_replace("_cpf_paciente_", preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $pacientes[0]->cpf), $termotcdmanual[0]->termo_tcd);
$termotcdmanual[0]->termo_tcd = str_replace("_endereco_paciente_", $pacientes[0]->logradouro.", ".$pacientes[0]->numero.", ".$pacientes[0]->bairro.", ".$pacientes[0]->cidade.", ".$pacientes[0]->estado.", ". $pacientes[0]->cep, $termotcdmanual[0]->termo_tcd);
$termotcdmanual[0]->termo_tcd = str_replace("_valor_procedimento_", number_format($valor_total,2,",","."), $termotcdmanual[0]->termo_tcd);
$termotcdmanual[0]->termo_tcd = str_replace("_valor_por_extenso_", $extenso, $termotcdmanual[0]->termo_tcd);
$termotcdmanual[0]->termo_tcd = str_replace("_procedimentos_", $listprocedimentos, $termotcdmanual[0]->termo_tcd);
$termotcdmanual[0]->termo_tcd = str_replace("_data_cadastro_", date('d',strtotime($tcd[0]->data_cadastro)).".".date('m',strtotime($tcd[0]->data_cadastro)).".".date('Y',strtotime($tcd[0]->data_cadastro)), $termotcdmanual[0]->termo_tcd);
$termotcdmanual[0]->termo_tcd = str_replace("_data_quitacao_", date('d/m/Y', strtotime("+ 60 days", strtotime($tcd[0]->data_cadastro))), $termotcdmanual[0]->termo_tcd);
$termotcdmanual[0]->termo_tcd = str_replace("_data_quitacao_", date('d/m/Y', strtotime("+ 60 days", strtotime($tcd[0]->data_cadastro))), $termotcdmanual[0]->termo_tcd);
$termotcdmanual[0]->termo_tcd = str_replace("<!-- pagebreak -->", '<pagebreak>', $termotcdmanual[0]->termo_tcd);

echo $termotcdmanual[0]->termo_tcd;

switch (date("m")) {
    case "01":    $mes = 'Janeiro';     break;
    case "02":    $mes = 'Fevereiro';   break;
    case "03":    $mes = 'Março';       break;
    case "04":    $mes = 'Abril';       break;
    case "05":    $mes = 'Maio';        break;
    case "06":    $mes = 'Junho';       break;
    case "07":    $mes = 'Julho';       break;
    case "08":    $mes = 'Agosto';      break;
    case "09":    $mes = 'Setembro';    break;
    case "10":    $mes = 'Outubro';     break;
    case "11":    $mes = 'Novembro';    break;
    case "12":    $mes = 'Dezembro';    break; 
}
?>

São Paulo, <?= date('d')?> de <?= $mes; ?> de <?= date('Y');?>. 
<br>
<br>
______________________________________________________________
<br>
<b>NOME COMPLETO DO DEVEDOR <b>
<br>
<br>
__________________________________________________________
<br> 
<b><?= $empresas[0]->razao_social; ?> </b>
<br>
<br> 
TESTEMUNHAS: 
<br>
<br>
_________________________________________<br>
Nome <br>
CPF<br>
CIRG nº.
<br>
<br>


_________________________________________<br>
Nome<br>
CPF<br>
CIRG nº.<br>


    </body>
</html>

