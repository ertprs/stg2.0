<?
$perfil_id = $this->session->userdata('perfil_id');
?>

<div class="content  " > <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a class="btn btn-outline-danger btn-round btn-sm" href="<?php echo base_url() ?>ambulatorio/procedimentoplano/orcamento/0/">
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

