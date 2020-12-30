<?
$perfil_id = $this->session->userdata('perfil_id');
?>
<div class="content  " > <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a class="btn btn-outline-danger btn-round btn-sm" href="<?php echo base_url() ?>ambulatorio/exametemp/carregarcredito/<?= $paciente_id ?>">
            Novo Crédito
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Crédito</a></h3>

        <div>
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Paciente</th>
                    <th>Data</th>  
                    <th>Valor (R$)</th> 
                    <th>Transferência</th>
                    <th>Observação</th>
                    <th><center>Detalhes</center></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th colspan="6" style="text-align:center">Saldo: R$ <?= number_format($valortotal[0]->saldo, 2, ',', '') ?></th>
                </tr>
            </tfoot>
        </table>
        </div>

        <h3 class="singular"><a href="#">Histórico Créditos Utilizados</a></h3>

            <div>
            <table id="example2" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Procedimento</th>  
                        <th>Valor (R$)</th> 
                        <th>Data</th>
                        <th>Operador</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="5" style="text-align:center">Total de Crédito utilizado: </th>
                    </tr>
                </tfoot>
            </table>
            <br><br><br><br><br><br><br><br><br><br><br><br>
            </div>

    </div>

</div> <!-- Final da DIV content -->


<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-dialog-centered" role="document" id="removemodal">
    
  </div>
</div>


<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });
    function confirmarEstorno(credito_id, paciente_id) {
//        alert('<?= base_url() ?>ambulatorio/exametemp/excluircredito/'+credito_id+'/'+paciente_id+'?justificativa=');
        var resposta = prompt("Informe o motivo do estorno.");
        if (resposta == null || resposta == "") {
            return false;
        } else {
            window.open('<?= base_url() ?>ambulatorio/exametemp/excluircredito/' + credito_id + '/' + paciente_id + '?justificativa=' + resposta, '_self');
//            alert(resposta);
        }
    }

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
                            <?if ($perfil_id == 1 || ($gerente_recepcao_top_saude && $perfil_id == 5)) {?>
                            '<a class="btn btn-outline-warning btn-round btn-sm"  href="#" onclick="confirmarEstorno('+paciente_credito_id+','+paciente_id+')">Estornar</a>'+
                            <?}?>
                            '</div>'+
                            '<div class="modal-footer">'+
                                '<button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>'+
                            '</div>'+
                        '</div>'+
                '</div>');
    }

    $(document).ready(function() {
        $('#example').DataTable( {
            "ajax": "<?=base_url()?>datatable/listarcredito/<?=$paciente_id?>",
            "columns": [
                { "data": "paciente" },
                { "data": "data" },
                { "data": "valor" },
                { "data": "paciente_transferencia" },
                { "data": "observacaocredito" },
                { "data": "detalhe" }
            ],
            "filter": true,
            "language": {
                "url": "<?=base_url()?>bootstrap/DataTables/Portuguese-Brasil.json"
            }   
        } );

        $('#example2').DataTable( {
            "ajax": "<?=base_url()?>datatable/listarcreditosusados/<?=$paciente_id?>",
            "columns": [
                { "data": "paciente" },
                { "data": "procedimento" },
                { "data": "valor" },
                { "data": "data" },
                { "data": "operador_cadastro" }
            ],
            "filter": false,
            "language": {
                "url": "<?=base_url()?>bootstrap/DataTables/Portuguese-Brasil.json"
            },
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
    
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '.')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
    
                // Total over all pages
                total = api
                    .column( 2 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
    
                // Total over this page
                pageTotal = api
                    .column( 2, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
    
                // Update footer
                $( api.column( 2 ).footer() ).html(
                    'Total de Crédito utilizado: R$ '+total +''
                );
            }  
        } );
    } );
</script>
