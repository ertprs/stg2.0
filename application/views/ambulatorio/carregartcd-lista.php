<?
$perfil_id = $this->session->userdata('perfil_id');
?>

<div class="content  " > <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a class="btn btn-outline-danger btn-round btn-sm" href="<?php echo base_url() ?>ambulatorio/guia/orcamento/<?=$paciente_id?>/">
            Novo TCD
        </a>
    </div>

    <div class="accordion">
        <h3 class="singular"><a href="#">Manter TCD</a></h3>
        <fieldset style="height:100%" >
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Paciente</th>
                    <th>Data</th>  
                    <th>Valor (R$)</th> 
                    <th>Observação</th>
                    <th><center>Detalhes</center></th>
                </tr>
            </thead>
        </table>
        </fieldset>


            <h3 class="singular"><a href="#">Histórico TCD Utilizados</a></h3>
                <fieldset style="height:100%" >
                    <table id="example2" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Valor (R$)</th>  
                                <th>Data</th> 
                                <th>Operador</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th colspan="4" style="text-align:center">Total:</th>
                            </tr>
                        </tfoot>
                    </table>
                    <br><br><br><br><br><br><br><br><br><br><br><br>
                </fieldset>
        </div>



</div> <!-- Final da DIV content -->

<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-dialog-centered" role="document" id="removemodal">
    
  </div>
</div>


<script type="text/javascript">
    
$(function () {
        $(".accordion").accordion();
    });
    function confirmarEstorno(paciente_tcd_id, paciente_id) {
//        alert('<?= base_url() ?>ambulatorio/exametemp/excluircredito/'+credito_id+'/'+paciente_id+'?justificativa=');
        var resposta = prompt("Informe o motivo");
        if (resposta == null || resposta == "") {
            return false;
        } else {
            window.open('<?= base_url() ?>ambulatorio/exametemp/excluirtcd/' + paciente_tcd_id + '/' + paciente_id + '?justificativa=' + resposta, '_self');
//            alert(resposta);
        }
    }


    function abrirModal(paciente_tcd_id, faturado, paciente_id, orcamento_id){
        $("#removemodal").remove();

        var nome = '';
        var data = '';
        var valor = '';
        var observacao = '';

        if(faturado == 0){
            var faturar = '<a class="btn btn-outline-warning btn-round btn-sm"  href="#" onclick="faturartcd('+paciente_tcd_id+', '+paciente_id+')">Faturar</a>';
        }else{
            var faturar = '<a class="btn btn-outline-warning btn-round btn-sm" href="#">Faturado</a>';
        }

        $.ajax({
            type: "POST",
            data: {
                paciente_tcd_id: paciente_tcd_id
                },
            url: "<?= base_url() ?>ambulatorio/exametemp/infotcd/",
            dataType: 'json',
            async: false,
                success: function (i) {
                    nome = i[0].nome;
                    data = i[0].data;
                    valor = i[0].valor;
                    observacao = i[0].observacao;
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
                            '<b>Observação:</b> '+observacao+'<br>'+
                            '<br>'+
                            '<a class="btn btn-outline-warning btn-round btn-sm" target="_black" href="<?=base_url()?>ambulatorio/exametemp/listarimpressoesRPS/'+paciente_id+'/'+paciente_tcd_id+'">RPS</a>'+
                            '<a class="btn btn-outline-warning btn-round btn-sm"  href="#" onclick="imprimirtermo('+paciente_tcd_id+', '+paciente_id+', '+orcamento_id+')">Imprimir Termo</a>'+
                            faturar+ 
                            '<a class="btn btn-outline-warning btn-round btn-sm"  href="#" onclick="confirmarEstorno('+paciente_tcd_id+','+paciente_id+')">Estornar</a>'+
                            '</div>'+
                            '<div class="modal-footer">'+
                                '<button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>'+
                            '</div>'+
                        '</div>'+
                '</div>');
            
    }

    function imprimirtermo(paciente_tcd_id, paciente_id, orcamento_id){
        window.open("<?=base_url()?>ambulatorio/exametemp/imprimirtermotcd/"+paciente_id+"/"+orcamento_id+"/"+paciente_tcd_id+"", "_blank", "toolbar=no,Location=no,menubar=no,width=1000,height=650");
    }

    function faturartcd(paciente_tcd_id, paciente_id){
        window.open('<?=base_url()?>/ambulatorio/guia/faturarmodelo2tcd/'+paciente_tcd_id+'/'+paciente_id+'', '_blank', 'width=1000,height=800');
    }

    $(document).ready(function() {
        $('#example').DataTable( {
            "ajax": "<?=base_url()?>datatable/listartcd/<?=$paciente_id?>",
            "columns": [
                { "data": "nome" },
                { "data": "data" },
                { "data": "valor" },
                { "data": "observacao" },
                { "data": "detalhe" }
            ],
            "language": {
                "url": "<?=base_url()?>bootstrap/DataTables/Portuguese-Brasil.json"
            }
        } );

        $('#example2').DataTable( {
            "ajax": "<?=base_url()?>datatable/listartcdusados/<?=$paciente_id?>",
            "columns": [
                { "data": "nome" },
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
                    .column( 1 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
    
                // Total over this page
                pageTotal = api
                    .column( 1, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
    
                // Update footer
                $( api.column( 1 ).footer() ).html(
                    'Total de TCD utilizado: R$ '+total +''
                );
            }
        } );
    } );
</script>

