<meta charset="utf8"/>
<div class="content"> <!-- Inicio da DIV content -->
    <?
    $i = 0;
    ?>
    <table>
        <thead>

            <? if (count(@$empresa) > 0) { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4"><?= $empresa[0]->razao_social; ?></th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODAS AS CLINICAS</th>
                </tr>
            <? } ?>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">FATURAMENTO POR GRUPO DE PRODUTO</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></th>
            </tr>
            <? if (count(@$medico) > 0) { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">MEDICO: <?= (@$medico[0]->operador != '')? $medico[0]->operador : 'TODOS'; ?></th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODAS AS CLINICAS</th>
                </tr>
            <? } ?>
            <? if (count(@$_POST['grupo']) == 0 || @in_array('0', @$_POST['grupo'])) { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: TODOS</th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: 
                      <?
                        if (@$_POST['grupo'] == '1') {
                            echo "SEM RM/TOMOGRAFIA";
                        }
                        if (count($_POST['grupo']) > 1 && @$_POST['grupo'] != '1') {
                            foreach ($_POST['grupo'] as $item) {
                                if ($item == '1') {
                                    echo 'SEM RM/TOMOGRAFIA' . ', ';
                                } else {
                                    echo $item . ', ';
                                }
                            }
                        }else{
                            echo $_POST['grupo'];                            
                        }
                        
                        ?></th>
                </tr>
            <? } ?>
            <? if ($conveniotipo == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODOS OS CONVENIOS</th>
                </tr>
            <? } elseif ($conveniotipo == "-1") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PARTICULARES</th>
                </tr>
            <? } elseif ($conveniotipo == "") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONVENIOS</th>
                </tr>
                <?
            } else {
                $i = 1;
                ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONVENIO: <?= $convenios[0]->nome; ?></th>
                </tr>

            <? } ?>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="5">&nbsp;</th>
            </tr>
            <? if (count($relatorio) > 0) {
                ?>

                <tr>
                    <td class="tabela_teste"><font size="-1">Grupo de produtos</th>
                    <td><font width="180px;"></td>
                    <td class="tabela_teste"><font size="-1">Grupo</th>
                    <td class="tabela_teste"><font size="-1">Código Tuss</th>
                    <td class="tabela_teste"><font size="-1">Quantidade</th>
                    <td class="tabela_teste" width="80px;"><font size="-1">Valor</th>
                    <td class="tabela_teste" width="80px;"><font size="-1">Percentual</th>
                </tr>
                <tr>
                    <th style='width:10pt;border:solid windowtext 1.0pt;
                        border-bottom:none;mso-border-top-alt:none;border-left:
                        none;border-right:none;' colspan="5">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $valor = 0;
                $valortotal = 0;
                $convenio = "";
                $y = 0;
                $qtde = 0;
                $qtdetotal = 0;
                $perc = 0;
                $perctotal = 0;

                foreach ($relatorio as $itens) :
                    $valortotal = $valortotal + $itens->valor;
                endforeach;

                foreach ($relatorio as $item) :
                    $i++;


                    if ($i == 1 || $item->convenio == $convenio) {
                        if ($i == 1) {
                            $y++;
                            ?>
                            <tr>
                                <td colspan="4"><font ><b><?= ($item->convenio); ?></b></td>
                            </tr>
                        <? }
                        ?>
                        <tr>
                            <td><font width="180px;"></td>
                            <td><font size="-2"><?= $item->nome; ?></td>
                            <td><font size="-2"><?= $item->grupo; ?></td>
                            <td><font size="-2"><?= $item->codigo; ?></td>
                            <td><font size="-2"><?= $item->quantidade; ?></td>
                            <td><font size="-2"><?= number_format($item->valor, 2, ',', '.') ?></td>
                        </tr>
                        <?php
                        $qtde = $qtde + $item->quantidade;
                        $qtdetotal = $qtdetotal + $item->quantidade;
                        $valor = $valor + $item->valor;
                        $perc = (($valor ) / $valortotal) * 100;
                        $convenio = $item->convenio;
                    } else {
                        ?>  
                        <tr>
                            <td><font width="180px;"></td>
                            <td ><font size="-1"><b>TOTAL <?= ($convenio); ?></b></td>
                            <td><font width="180px;"></td>
                            <td><font width="180px;"></td>
                            <td ><font size="-1"><b><?= $qtde; ?></b></td>
                            <td ><font size="-1"><b><?= number_format($valor, 2, ',', '.'); ?></b></td>
                            <td ><font size="-1"><b><?= substr($perc, 0, 4); ?>%</b></td>

                        </tr>
                        <tr><td></td></tr>
                        <tr><td></td></tr>
                        <tr>
                            <td colspan="3"><font ><b><?= ($item->convenio); ?></b></td>
                        </tr>
                        <tr>
                            <td><font width="180px;"></td>
                            <td><font size="-2"><?= $item->nome; ?></td>
                            <td><font size="-2"><?= $item->grupo; ?></td>
                            <td><font size="-2"><?= $item->codigo; ?></td>
                            <td><font size="-2"><?= $item->quantidade; ?></td>
                            <td><font size="-2"><?= number_format($item->valor, 2, ',', '.') ?></td>

                        </tr>


                        <?
                        $convenio = $item->convenio;

                        $qtde = 0;
                        $qtde = $qtde + $item->quantidade;
                        $qtdetotal = $qtdetotal + $item->quantidade;
                        $valor = 0;
                        $valor = $valor + $item->valor;
                        $perc = 0;
                        $perc = (($valor ) / $valortotal) * 100;
                        $y = 0;
                    }
                endforeach;
                ?>
                <tr>
                    <td><font width="180px;"></td>
                    <td ><font size="-1"><b>TOTAL <?= ($convenio); ?> </b></td>
                    <td><font width="180px;"></td>
                    <td><font width="180px;"></td>
                    <td ><font size="-1"><b><?= $qtde; ?></b></td>
                   
                    <td ><font size="-1"><b><?= number_format($valor, 2, ',', '.'); ?></b></td>
                    <td ><font size="-1"><b><?= substr($perc, 0, 4); ?>%</b></td>
                </tr>
            </tbody>
        </table>
        <hr>

    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
        <?
    }
    ?>

</div> <!-- Final da DIV content -->
<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>
