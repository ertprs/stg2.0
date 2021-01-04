<style>
    .espacoextra{
        margin-top: 10px;
    }
</style>

<div class="content ficha_ceatox">
    <div>
        <?
        $sala = "";
        $ordenador1 = "";
        $sala_id = "";
        $medico_id = "";
        $medico = "";
        $medico_solicitante = "";
        $medico_solicitante_id = "";
        $convenio_paciente = "";
        $empresa = $this->guia->listarempresapermissoes(); 
        $odontologia_alterar = $empresa[0]->odontologia_valor_alterar; 
        $bt_autorizar = false;

        foreach($exames as $item){
            if($item->autorizacao_finalizada != "t"){
               $bt_autorizar = true;
               break;
            } 
        }
        ?>
        <div>
            <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravarorcamento" method="post">
                <fieldset>
                <div class="panel-body ">
                    <div class="alert alert-info"><b>Dados do paciente</b></div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div>
                                    <label>Nome</label>
                                    <input type="text" id="txtNome" name="nome"  class="form-control" value="<?= $paciente['0']->nome; ?>" readonly/>
                                    <input type="hidden" id="txtpaciente_id" name="txtpaciente_id"  value="<?= $paciente_id; ?>"/>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div>
                                    <label>Sexo</label>
                                    <select name="sexo" id="txtSexo" class="form-control" disabled>
                                        <option value="M" <?
                                        if ($paciente['0']->sexo == "M"):echo 'selected';
                                        endif;
                                        ?>>Masculino</option>
                                        <option value="F" <?
                                        if ($paciente['0']->sexo == "F"):echo 'selected';
                                        endif;
                                        ?>>Feminino</option>
                                        <option value="O" <?
                                        if ($paciente['0']->sexo == "O"):echo 'selected';
                                        endif;
                                        ?>>Outros</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div>
                                    <label>Nascimento</label>
                                    <input type="text" name="nascimento" id="txtNascimento" class="form-control" alt="date" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" onblur="retornaIdade()" readonly/>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div>
                                    <label>CPF</label>
                                    <input type="text" name="cpf" id="cpf" class="form-control" value="<?= @$paciente['0']->cpf ?>" readonly/>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div>
                                    <?
                                    $telefone = $paciente['0']->celular;
                                    if($paciente['0']->telefone != '') $telefone = $paciente['0']->telefone;
                                    ?>
                                    <label>Telefone</label>
                                    <input type="text" name="cpf" id="cpf" class="form-control texto03" value="<?= @$telefone ?>" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div class="panel-body">
                    <div class="alert alert-info"><b>Ficha</b></div>
                    <fieldset>
                        <div class="row">

                                <div class="col-lg-2">
                                    <div class="espacoextra">
                                        <label class="tabela_header">Empresa*</label>
                                        <select  name="empresa1" id="empresa1" class="form-control" required="">
                                            <option value="">Selecione</option>
                                            <?
                                            $lastEmp = $exames[count($exames) - 1]->empresa_id;
                                            foreach ($empresasLista as $item) : ?>
                                                <option <? if ($lastEmp == $item->empresa_id) echo 'selected'; ?> value="<?= $item->empresa_id; ?>"><?= $item->nome; ?></option>
                                            <? endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="espacoextra">
                                        <label class="tabela_header">Convenio*</label>
                                        <select  name="convenio1" id="convenio1" class="form-control texto04">
                                            <option value="-1">Selecione</option>
                                            <?
                                            $lastConv = $exames[count($exames) - 1]->convenio_id;
                                            foreach ($convenio as $item) :
                                                ?>
                                                <option value="<?= $item->convenio_id; ?>" <? if ($lastConv == $item->convenio_id) echo 'selected'; ?>>
                                                    <?= $item->nome; ?>
                                                </option>
                                            <? endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="espacoextra">
                                        <label class="tabela_header">Grupo</label>
                                        <select  name="grupo1" id="grupo1" class="form-control" >
                                            <option value="">Selecione</option>
                                            <?
                                            $lastGrupo = $exames[count($exames) - 1]->grupo;
                                            foreach ($grupos as $value) :
                                                ?>
                                                <option value="<?= $value->nome; ?>" <? if ($lastGrupo == $value->nome) echo 'selected'; ?>>
                                                    <?= $value->nome; ?>
                                                </option>
                                            <? endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="espacoextra">
                                        <label class="tabela_header">Procedimento*</label>
                                        <select name="procedimento1" id="procedimento1" required class="form-control" data-placeholder="Selecione" tabindex="1">
                                            <option value="">Selecione</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="espacoextra">
                                        <label class="tabela_header">Data Preferência</label>
                                        <input type="text" name="txtdata" id="txtdata" alt="date" class="form-control"/>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="espacoextra">
                                        <label class="tabela_header">Horário Preferência</label>
                                        <select name="turno_preferencia" id="turno_preferencia" class="form-control" >
                                            <option value="">Selecione</option>
                                            <option value="manha" <?if(@$exames[count($exames)-1]->turno_prefencia == "manha") echo 'selected';?>>Manhã</option>
                                            <option value="tarde" <?if(@$exames[count($exames)-1]->turno_prefencia == "tarde") echo 'selected';?>>Tarde</option>
                                            <option value="noite" <?if(@$exames[count($exames)-1]->turno_prefencia == "noite") echo 'selected';?>>Noite</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="espacoextra">
                                        <label class="tabela_header">Qtde*</label>
                                        <input type="text" name="qtde1" id="qtde1" value="1" class="form-control"/>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="espacoextra">
                                        <label class="tabela_header">V. Unit</label>
                                        <input type="text" name="valor1" id="valor1" class="form-control" readonly=""/>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="espacoextra">
                                        <label class="tabela_header">Forma de Pagamento</label>
                                        <select name="formapamento" id="formapamento" class="form-control" >
                                            <option value="">Selecione</option>
                                            <? foreach ($forma_pagamento as $item) : ?>
                                                <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>
                                            <? endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="espacoextra">
                                        <label class="tabela_header">V. Ajuste</label>
                                        <input type="text" name="ajustevalor1" id="ajustevalor1" class="form-control" readonly=""/>
                                    </div>
                                </div>
                        </div>
                    </fieldset>
                </div>
                
                <div class="panel-body">                           
                    <button class="btn btn-success btn-round btn-sm" type="submit" name="btnEnviar">Adicionar</button>
                </div>
            </form>
            
            <div class="panel-body">
            <fieldset>
                <div class="alert alert-info"><b>Orçamento Atual</b></div>
                <?
                $total = 0;
                $totalCartao = 0;
                $orcamento = 0;
                if (count($exames) > 0) {
                    ?>
                    <table id="table_agente_toxico" border="0" class="example display" style="width:100%">
                        <thead>
                            <tr>
                                <th colspan="10"><span style="font-size: 12pt; font-weight: bold;">Operador Responsável: <?= @$responsavel[0]->nome ?></span></th>
                            </tr>
                            <tr>
                                <th class="tabela_header">Convenio</th>
                                <th class="tabela_header">Grupo</th>
                                <th class="tabela_header">Procedimento</th>
                                <th class="tabela_header">Forma de Pagamento</th>
                                <th class="tabela_header" width="80">Descrição</th>
                                <th class="tabela_header">V. Total</th>
                                <th class="tabela_header">V. Ajuste</th>
                                <th class="tabela_header">Data</th>
                                <th class="tabela_header">Horário de Preferência</th>
                                <th class="tabela_header"></th>
                            </tr>
                        </thead>
                        <?
                        $estilo_linha = "tabela_content01";
                        foreach ($exames as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            $total = $total + $item->valor_total;
                            $totalCartao = $totalCartao + $item->valor_total_ajustado;
                            $orcamento = $item->orcamento_id;
                            
                            switch ($item->turno_prefencia){
                                case 'manha':
                                    $turno = "Manhã";
                                    break;
                                case 'tarde':
                                    $turno = "Tarde";
                                    break;
                                case 'noite':
                                    $turno = "Noite";
                                    break;
                                default:
                                    $turno = "Não informado";
                                    break;
                            }
                            ?>
                            <tbody>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->grupo; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento . "-" . $item->codigo; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->forma_pagamento; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao_procedimento; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->valor_total; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->valor_total_ajustado; ?></td>
                                    
                                    <td class="<?php echo $estilo_linha; ?>">
                                        <? if ($item->data_preferencia != "") echo date("d/m/Y", strtotime($item->data_preferencia)); 
                                           else echo "Não informado";?>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= ($item->horario_preferencia != '') ? date("H:i", strtotime($item->horario_preferencia)) : 'Não-Informado' ?></td>
                                    <td class="<?php echo $estilo_linha; ?>">
                                        <a href="<?= base_url() ?>ambulatorio/guia/excluirorcamento/<?= $item->ambulatorio_orcamento_item_id ?>/<?= $item->paciente_id ?>/<?= $item->orcamento_id ?>" class="delete">
                                        </a>
                                    </td>
                                </tr>

                            </tbody>
                            <?
                        }
                    ?>
                        <tfoot>
                            <tr>
                                <th class="tabela_footer" colspan="2" style="vertical-align: top;">
                                    Valor Total: <?php echo number_format($total, 2, ',', '.'); ?>
                                </th>
                                <th class="tabela_footer" colspan="2" style="vertical-align: top;">
                                    Valor Total Ajustado: <?php echo number_format($totalCartao, 2, ',', '.'); ?>
                                </th>
                                <th colspan="3" align="center">
                                    <center>
                                        <div class="bt_linkf">
                                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/impressaoorcamento/" . $orcamento; ?> ', '_blank', 'width=600,height=600');">Imprimir Or&ccedil;amento</a>
                                        </div>
                                    </center>
                                    <center>
                                        <div class="bt_linkf">
                                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/orcamentocadastrofila/" . $orcamento; ?> ', '_blank', 'width=600,height=600');">Fila de Impressão</a>
                                        </div>
                                    </center>
                                </th>
                                <th colspan="2" align="center">
                                    <?   
                                    if ($bt_autorizar) {  ?>
                                        <center>
                                            <div class="bt_linkf">
                                                <a href="<?= base_url() . "ambulatorio/exame/gravarautorizarorcamento/" . $orcamento; ?>" target='_blank'>Autorizar Orçamento</a>
                                            </div>
                                        </center>
                                    <? } ?>
                                    <center>
                                        <div class="bt_linkf">
                                            <a href="<?= base_url() . "ambulatorio/guia/transformaorcamentocredito/" . $orcamento; ?>" target='_blank'>Transformar em Crédito</a>
                                        </div>
                                    </center>
                                </th>
                                <th>
                                     <center>
                                        <div class="bt_linkf">
                                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/transformaorcamentotcd/" . $orcamento; ?> ', '_blank', 'width=600,height=600');"  >Transformar em TCD</a>
                                        </div>
                                    </center>
                                </th>
                            </tr>
                        </tfoot>
                    </table> 
                    </fieldset>
                    </div>
                    <?
                    foreach($orcamentos as $value){
                        
                        $total = 0;
                        $totalCartao = 0;
                        $orcamento = 0;
                        $autorizado = false;
                    
                        if($value->qtdeproc == 0) continue;?>
                        <div class="panel-body">
                        <fieldset>
                            <table id="table_agente_toxico" class="example display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th colspan="11"><span style="font-size: 12pt; font-weight: bold;">Operador Responsável: <?= @$value->responsavel ?></span></th>
                                    </tr>
                                    <tr>
                                        <th class="tabela_header">Empresa</th>
                                        <th class="tabela_header">Convenio</th>
                                        <th class="tabela_header">Grupo</th>
                                        <th class="tabela_header">Procedimento</th>
                                        <th class="tabela_header">Forma de Pagamento</th>
                                        <th class="tabela_header">Descrição</th>
                                        <th class="tabela_header">V. Total</th>
                                        <th class="tabela_header">V. Ajuste</th>
                                        <th class="tabela_header">Data</th>
                                        <th class="tabela_header">Horário de Preferência</th>
                                        <th class="tabela_header"></th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                            <?

                            $estilo_linha = "tabela_content01";
                            foreach($orcamentoslista as $item){
                                if ($item->orcamento_id == $value->ambulatorio_orcamento_id) {

                                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                                    $total = $total + $item->valor_total;
                                    $totalCartao = $totalCartao + $item->valor_total_ajustado;

                                    $orcamento = $item->orcamento_id;
                                    
                                    if ($item->autorizacao_finalizada == 't'){
                                        $autorizado = true;
                                    }

                                    switch ($item->turno_prefencia) {
                                        case 'manha':
                                            $turno = "Manhã";
                                            break;
                                        case 'tarde':
                                            $turno = "Tarde";
                                            break;
                                        case 'noite':
                                            $turno = "Noite";
                                            break;
                                        default:
                                            $turno = "Não informado";
                                            break;
                                    } ?>
                                        <tr>
                                            <td class="<?php echo $estilo_linha; ?>"> <?= $item->empresa; ?> </td>
                                            <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                            <td class="<?php echo $estilo_linha; ?>"><?= $item->grupo; ?></td>
                                            <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento . "-" . $item->codigo; ?></td>
                                            <td class="<?php echo $estilo_linha; ?>"><?= $item->forma_pagamento; ?></td>
                                            <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao_procedimento; ?></td>
                                            <td class="<?php echo $estilo_linha; ?>"><?= $item->valor_total; ?></td>
                                            <td class="<?php echo $estilo_linha; ?>"><?= $item->valor_total_ajustado; ?></td>
                                            <td class="<?php echo $estilo_linha; ?>">
                                                <? if ($item->data_preferencia != "") echo date("d/m/Y", strtotime($item->data_preferencia)); 
                                                   else echo "Não informado";?>
                                            </td>
                                            <td class="<?php echo $estilo_linha; ?>"><?= ($item->horario_preferencia != '') ? date("H:i", strtotime($item->horario_preferencia)) : 'Não-Informado' ?></td>
                                            <td hidden><?=$value->ambulatorio_orcamento_id;?></td>
                                        </tr>
                                <?
                                }
                            }
                            ?>
                                        

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="tabela_footer" colspan="2" style="vertical-align: top;">
                                        Valor Total: <?php echo number_format($total, 2, ',', '.'); ?>
                                    </th>
                                    <th class="tabela_footer" colspan="2" style="vertical-align: top;">
                                        Valor Total Ajustado: <?php echo number_format($totalCartao, 2, ',', '.'); ?>
                                    </th>
                                    <th colspan="3" align="center">
                                        <center>
                                            <div class="bt_linkf">
                                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/procedimentoplano/impressaoorcamentorecepcao/" . $value->ambulatorio_orcamento_id; ?> ', '_blank', 'width=600,height=600');">Imprimir Or&ccedil;amento</a>
                                            </div>
                                        </center>
                                        <center>
                                            <div class="bt_linkf">
                                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/procedimentoplano/orcamentorecepcaofila/" . $value->ambulatorio_orcamento_id; ?> ', '_blank', 'width=600,height=600');">Fila de Impressão</a>
                                            </div>
                                        </center>
                                    </th>
                                    <th colspan="3" align="center">
                                        <? if (!$autorizado) { ?>
                                                <center>
                                                    <div class="bt_linkf">
                                                        <a href="<?= base_url() . "ambulatorio/exame/gravarautorizarorcamento/" . $value->ambulatorio_orcamento_id; ?>" target='_blank'>Autorizar Orçamento</a>
                                                    </div>
                                                </center>
                                        <? } ?>
                                        <center>
                                            <div class="bt_linkf">
                                                <a href="<?= base_url() . "ambulatorio/guia/transformaorcamentocredito/" . $value->ambulatorio_orcamento_id; ?>" target='_blank'>Transformar em Crédito</a>
                                            </div>
                                        </center>
                                    </th>
                                    <th>
                                     <center>
                                        <div class="bt_linkf">
                                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/transformaorcamentotcd/" . $value->ambulatorio_orcamento_id; ?> ', '_blank', 'width=600,height=600');"  >Transformar em TCD</a>
                                        </div>
                                    </center>
                                  </th>
                                </tr>
                            </tfoot>
                            </table> 
                        </fieldset>
                        </div>
                        <?
                    }
                }
            ?> 
        </div> 
    </div> 
</div> <!-- Final da DIV content -->

<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-dialog-centered" role="document" id="removemodal">
    
  </div>
</div>

<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<style>
    .chosen-container{ margin-top: 5pt;}
    #procedimento1_chosen a { width: 100%; }
</style>
<script type="text/javascript">

$(document).ready(function() {
    var table =  $('table.display').DataTable({
            "language": {
                "url": "<?=base_url()?>bootstrap/DataTables/Portuguese-Brasil.json"
            },
            "paging":   false,
            "ordering": false,
            "info":     false,
            "filter": false,
        });

        //     $('table.display tbody').on('click', 'tr', function () {
        //     var data = table.row(this).data();
        //     console.log(data);
        //     alert( 'Um passo a frete' );
        // } );
        
    } );


    $("tr").on('click',function() {
        var horario;
         var tableData = $(this).children("td").map(function(){
         return $(this).text();
         }).get();
         horario =    $.trim(tableData[0]);
         console.log(tableData);
         $('p.text').text(horario+' selecionado');
        //  $('#myModal').modal('show');
    });
    
    $('.btn-salvar').on('click',function(){
      alert('Salvo');
       $('#modal-texto').modal('hide');
    });

    function abrirModal(paciente_credito_id, paciente_id){
        $("#removemodal").remove();

        var nome = '';
        var data = '';
        var valor = '';
        var observacao = '';

        $.ajax({
            type: "POST",
            data: {
                paciente_credito_id: paciente_credito_id
                },
            url: "<?= base_url() ?>ambulatorio/exametemp/infocredito/",
            dataType: 'json',
            async: false,
                success: function (i) {
                    nome = i[0].paciente;
                    data = i[0].data;
                    valor = i[0].valor;
                    transferencia = i[0].paciente_transferencia;
                    observacao = i[0].observacaocredito
                },
                error: function (i) {
                    alert('Erro');
                }    
            });

        $("#myModal").append(
                    '<div class="modal-dialog modal-dialog-centered" role="document" id="removemodal">'+
                        '<div class="modal-content">'+
                            '<div class="modal-header">'+
                                '<h5 class="modal-title" id="exampleModalLongTitle">Ações</h5>'+
                                '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                                '<span aria-hidden="true">&times;</span>'+
                                '</button>'+
                            '</div>'+
                            '<div class="modal-body">'+
                            '<b>Paciente:</b> '+nome+'<br>'+
                            '<b>Data:</b> '+data+'<br>'+
                            '<b>Valor:</b> '+valor+'<br>'+
                            '<b>Transferencia:</b> '+transferencia+'<br>'+
                            '<b>Observação:</b> '+observacao+'<br>'+
                            '<br>'+
                            '<a class="btn btn-outline-warning btn-round btn-sm" target="_black" href="<?=base_url()?>ambulatorio/exametemp/gerarecibocredito/'+paciente_credito_id+'/'+paciente_id+'">Recibo</a>'+
                            '<a class="btn btn-outline-warning btn-round btn-sm" href="<?=base_url()?>ambulatorio/exametemp/trasnferircredito/'+paciente_credito_id+'/'+paciente_id+'"> Transferir</a>'+
                            <?//if ($perfil_id == 1 || ($gerente_recepcao_top_saude && $perfil_id == 5)) {?>
                            '<a class="btn btn-outline-warning btn-round btn-sm"  href="#" onclick="confirmarEstorno('+paciente_credito_id+','+paciente_id+')">Estornar</a>'+
                            <?//}?>
                            '</div>'+
                            '<div class="modal-footer">'+
                                '<button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>'+
                            '</div>'+
                        '</div>'+
                '</div>');
    }

//    $(".select-data").hide();
//    $(".input-data").hide();
var array_datas = [];
//    var array_datas_teste = [];
    
//     $(document).ready(function() {
    function date_picker (){
        $("#txtdata").datepicker({
            beforeShowDay: function(d) {
        // normalize the date for searching in array
            var dmy = "";
            dmy += ("00" + d.getDate()).slice(-2) + "-";
            dmy += ("00" + (d.getMonth() + 1)).slice(-2) + "-";
            dmy += d.getFullYear();
//            console.log(dmy);
            return [$.inArray(dmy, array_datas) >= 0 ? true : false, ""];
            },
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
//    });
    }
    date_picker();
    $(function () {
        $('#procedimento1').change(function () {
            $.getJSON('<?= base_url() ?>autocomplete/horariosdisponiveisorcamento', {grupo1: $("#grupo1").val(), empresa1: $('#empresa1').val(), ajax: true}, function (j) {
//                                   alert('teste');
                if(j.length > 0){
                     array_datas = [];

                    var options = '<option value="">Selecione</option>';
                    for (var c = 0; c < j.length; c++) {
                        if (j[c].data != null) {
                           
                            array_datas.push(j[c].data_formatada_picker);
                            options += '<option value="' + j[c].data + '">' + j[c].data_formatada + '</option>';
                        }
                    }
//                    console.log(array_datas);
//                    $("#txtdata").datepicker("refresh");
                    date_picker();
//                    $('select#txtdata').html(options).show();
                    $('.carregando').hide();
                   
                    
                }else{
                    array_datas = [];
                    date_picker();
                }
            });
        });
    });
    var manha = '';
    var tarde = '';
    var noite = '';
    var hora = '';
    $(function () {
        $('#txtdata').change(function () {
//            alert('asd');
            $.getJSON('<?= base_url() ?>autocomplete/horariosdisponiveisorcamentodata', {grupo1: $("#grupo1").val(), empresa1: $('#empresa1').val(), data:  $('#txtdata').val(),  ajax: true}, function (j) {
//                    console.log(j);
                    if(j.length > 0){
//                    alert('teste');
                    var options = '<option value="">Selecione</option>';
                    manha = '';
                    tarde = '';
                    noite = '';
                    hora = '';
                    for (var c = 0; c < j.length; c++) {
                        if (j[c].inicio != null) {
                            hora = j[c].inicio;
                            if(parseInt(hora.substring(0, 2)) < 12 && manha == ''){
                                manha = j[c].inicio;
                                options += '<option value="' + manha + '">' + manha.substring(0, 5) + '</option>';
                            }
                            if(parseInt(hora.substring(0, 2)) < 18 && parseInt(hora.substring(0, 2)) > 11 && tarde == ''){
                                tarde = j[c].inicio;
                                options += '<option value="' + tarde + '">' + tarde.substring(0, 5) + '</option>';
                            }
                            if(parseInt(hora.substring(0, 2)) > 17 && noite == ''){
                                noite = j[c].inicio;
                                options += '<option value="' + noite + '">' + noite.substring(0, 5) + '</option>';
                            }
                            
                        }
                    }
                    
                    
                    
                    
                    $('#turno_preferencia').html(options).show();
                    $('.carregando').hide();
                   
                    
                }
            });
        });
    });
    
    
//    var availableDates = ["9-5-2011","14-5-2011","15-5-2011"];

    

    
    $(function () {
        $('#empresa1').change(function () {
            $.getJSON('<?= base_url() ?>autocomplete/horariosdisponiveisorcamento', {grupo1: $("#grupo1").val(), empresa1: $('#empresa1').val(), ajax: true}, function (j) {
//                                   alert('teste');
                if(j.length > 0){
                     array_datas = [];

                    var options = '<option value="">Selecione</option>';
                    for (var c = 0; c < j.length; c++) {
                        if (j[c].data != null) {
                           
                            array_datas.push(j[c].data_formatada_picker);
                            options += '<option value="' + j[c].data + '">' + j[c].data_formatada + '</option>';
                        }
                    }
//                    console.log(array_datas);
                    $("#txtdata").datepicker("refresh");
//                    $('select#txtdata').html(options).show();
                    $('.carregando').hide();
                   
                    
                }
            });
        });
    });
    // $(function () {
    //     $("input#txtdata").datepicker({
    //         autosize: true,
    //         changeYear: true,
    //         changeMonth: true,
    //         monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
    //         dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
    //         buttonImage: '<?= base_url() ?>img/form/date.png',
    //         dateFormat: 'dd/mm/yy'
    //     });
    // });
    
    // $(".select-data").show();
    // $(".input-data").hide();
    
    $(function () {
        $('#procedimento1').change(function () {
            $.getJSON('<?= base_url() ?>autocomplete/horariosdisponiveisorcamento', {procedimento1: $("#procedimento1").val(), empresa1: $('#empresa1').val(), ajax: true}, function (j) {
                if(j.length > 0){
                    var options = '<option value="">Selecione</option>';
                    for (var c = 0; c < j.length; c++) {
                        if (j[c].data != null) {
                            options += '<option value="' + j[c].data + '">' + j[c].data_formatada + '</option>';
                        }
                    }
                    $('select#txtdata').html(options).show();
                    $('.carregando').hide();
                    
                }
            });
        });
    });
    
    $(function () {
        $('#empresa1').change(function () {
            $.getJSON('<?= base_url() ?>autocomplete/horariosdisponiveisorcamento', {procedimento1: $("#procedimento1").val(), empresa1: $('#empresa1').val(), ajax: true}, function (j) {
                if(j.length > 0){
                    var options = '<option value="">Selecione</option>';
                    for (var c = 0; c < j.length; c++) {
                        if (j[c].data != null) {
                            options += '<option value="' + j[c].data + '">' + j[c].data_formatada + '</option>';
                        }
                    }
                    $('select#txtdata').html(options).show();
                    $('.carregando').hide();
                    
                }
            });
        });
    });

                                if ($('#convenio1').val() != '-1') {
                                    if($('#grupo1').val() == ''){
                                        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio', {convenio1: $('#convenio1').val(), ajax: true}, function (j) {
                                            options = '<option value=""></option>';
                                            for (var c = 0; c < j.length; c++) {
                                                options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                            }
    //                                        $('#procedimento1').html(options).show();

                                            $('#procedimento1 option').remove();
                                            $('#procedimento1').append(options);
                                            $("#procedimento1").trigger("chosen:updated");
                                            $('.carregando').hide();
                                        });
                                    }
                                    else {
                                        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupoorcamento', {grupo1: $('#grupo1').val(), convenio1: $('#convenio1').val()}, function (j) {
                                            options = '<option value=""></option>';
    //                                        alert('ola');
                                            for (var c = 0; c < j.length; c++) {
                                                options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                            }

                                            $('#procedimento1 option').remove();
                                            $('#procedimento1').append(options);
                                            $("#procedimento1").trigger("chosen:updated");
    //                                        $('#procedimento1').html(options).show();
                                            $('.carregando').hide();
                                        });
                                    }
                                }

                                $(function () {
                                    $('#grupo1').change(function () {
                                        $('.carregando').show();
                                        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupoorcamento', {grupo1: $(this).val(), convenio1: $('#convenio1').val()}, function (j) {
                                            options = '<option value=""></option>';
                                            for (var c = 0; c < j.length; c++) {
                                                options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                            }

                                            $('#procedimento1 option').remove();
                                            $('#procedimento1').append(options);
                                            $("#procedimento1").trigger("chosen:updated");
//                                            $('#procedimento1').html(options).show();
                                            $('.carregando').hide();
                                        });
                                    });
                                });

                                $(function () {
                                    $("#data").datepicker({
                                        autosize: true,
                                        changeYear: true,
                                        changeMonth: true,
                                        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                                        dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                                        buttonImage: '<?= base_url() ?>img/form/date.png',
                                        dateFormat: 'dd/mm/yy'
                                    });
                                });

                                $(function () {
                                    $("#accordion").accordion();
                                });


                                $(function () {
                                    $("#medico1").autocomplete({
                                        source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                        minLength: 3,
                                        focus: function (event, ui) {
                                            $("#medico1").val(ui.item.label);
                                            return false;
                                        },
                                        select: function (event, ui) {
                                            $("#medico1").val(ui.item.value);
                                            $("#crm1").val(ui.item.id);
                                            return false;
                                        }
                                    });
                                });

                                $(function () {
                                    $('#convenio1').change(function () {
                                        if ($(this).val()) {
                                            $('.carregando').show();
                                            $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenioorcamento', {convenio1: $(this).val(), ajax: true}, function (j) {
                                                options = '<option value=""></option>';
                                                for (var c = 0; c < j.length; c++) {
                                                    options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                }
//                                                console.log(options);
//                                                $('#procedimento1').html(options).show();

                                                $('#procedimento1 option').remove();
                                                $('#procedimento1').append(options);
                                                $("#procedimento1").trigger("chosen:updated");
                                                $('.carregando').hide();
                                            });
                                            if ($('#grupo1').val() != '') {
                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupoorcamento', {grupo1: $('#grupo1').val(), convenio1: $('#convenio1').val()}, function (j) {
                                                    options = '<option value=""></option>';
                                                    for (var c = 0; c < j.length; c++) {
                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                    }
//                                                    $('#procedimento1').html(options).show();

                                                    $('#procedimento1 option').remove();
                                                    $('#procedimento1').append(options);
                                                    $("#procedimento1").trigger("chosen:updated");
                                                    $('.carregando').hide();
                                                });
                                            }

                                        } else {
                                            $('#procedimento1').html('<option value="">Selecione</option>');
                                        }
                                    });
                                });


                                 $(function () {
                                    $('#procedimento1').change(function () {
                                        console.log('teste');
                                        if ($(this).val()) {
                                            $('.carregando').show();
                                            $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: $(this).val(), ajax: true}, function (j) {
                                                options = "";
                                                options += j[0].valortotal;
                                                if(j[0].grupo == 'LABORATORIAL'){
                                                    // $(".select-data").hide();
                                                    // $(".input-data").show();
                                                }
                                                else{
                                                    // $(".select-data").show();
                                                    // $(".input-data").hide();
                                                }
                                                
                                                <? if($odontologia_alterar == 't'){?>
                                                    if(j[0].grupo == 'ODONTOLOGIA'){
                                                        $("#valor1").prop('readonly', false);
                                                    }else{
                                                        $("#valor1").prop('readonly', true);
                                                    }    
                                                <? } ?>
                                                document.getElementById("valor1").value = options
                                                
                                                if( $('#formapamento').val() ){
                                                    $.getJSON('<?= base_url() ?>autocomplete/formapagamentoorcamento', {formapamento1: $('#formapamento').val(), ajax: true}, function (j) {
                                                        var ajuste = (j[0].ajuste == null) ? 0 : j[0].ajuste;

                                                        var valorajuste1 = parseFloat(($("#valor1").val() * ajuste) / 100) + parseFloat($("#valor1").val());
                                                        
                                                        $("#ajustevalor1").val(valorajuste1.toFixed(2));

                                                        $('.carregando').hide();
                                                    });
                                                }
//                                                else{
//                                                    $("#ajustevalor1").val(0);
//                                                }
                                                $('.carregando').hide();
                                            });
                                        } else {
                                            $('#valor1').html('value=""');
                                        }
                                    });
                                });

                                $(function () {
                                    $('#formapamento').change(function () {
                                        if ($(this).val()) {
                                            $('.carregando').show();
                                            $.getJSON('<?= base_url() ?>autocomplete/formapagamentoorcamento', {formapamento1: $(this).val(), ajax: true}, function (j) {
                                                var ajuste = (j[0].ajuste == null) ? 0 : j[0].ajuste;

                                                var valorajuste1 = parseFloat(($("#valor1").val() * ajuste) / 100) + parseFloat($("#valor1").val());

                                                $("#ajustevalor1").val(valorajuste1.toFixed(2));

                                                
                                                $('.carregando').hide();
                                            });
                                        }
                                        else{
                                            $("#ajustevalor1").val('');
                                        }
                                    });
                                });
</script>
