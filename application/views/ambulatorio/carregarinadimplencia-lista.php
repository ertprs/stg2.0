<?
$perfil_id = $this->session->userdata('perfil_id');
?>
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a class="btn btn-outline-danger btn-round btn-sm" href="<?php echo base_url() ?>ambulatorio/exametemp/carregarinadimplencia/<?= $paciente_id ?>">
            Nova Inadimplência
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Inadimplência</a></h3>



            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Data</th>  
                        <th>Valor (R$)</th> 
                        <th>Procedimento</th>
                        <th>Convênio</th>
                        <th>Observação</th>
                        <th><center>Detalhes</center></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="7" style="text-align:center">Saldo: R$ <?= number_format($valortotal[0]->saldo, 2, ',', '') ?></th>
                    </tr>
                </tfoot>
            </table>
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

    function confirmarEstorno(paciente_inadimplencia_id, paciente_id) {
        if (window.confirm("Deseja realmente excluir esse item?")) {
            window.open("sair.html", "Obrigado pela visita!");
            // window.open('<?= base_url()?>ambulatorio/exametemp/excluirinadimplencia/'+paciente_inadimplencia_id+'/'+paciente_id+'', '_self');
        }
    }

    function abrirModal(paciente_inadimplencia_id, paciente_id, agenda_exames_id, procedimento_convenio_id, guia_id, faturado){
        $("#removemodal").remove();

        var nome = '';
        var data = '';
        var valor = '';
        var procedimento = '';
        var convenio = '';
        var observacao = '';

        var faturar = ''
        var excluir = '';

        if(faturado == 0){
            if(agenda_exames_id != ''){
                faturar = '<a class="btn btn-outline-warning btn-round btn-sm"  href="#" onclick="faturarinadimplencia('+agenda_exames_id+', '+procedimento_convenio_id+', '+guia_id+')">Faturar</a>';
            }else{
                faturar = '<a class="btn btn-outline-warning btn-round btn-sm"  href="#" onclick="faturarinadimplencia2('+paciente_inadimplencia_id+', '+paciente_id+')">Faturar</a>';
            }
        }else{
            faturar = '<a class="btn btn-outline-warning btn-round btn-sm" href="#">Faturado</a>';
        }

        perfil_id = <?=$perfil_id?>;
        gerente_recepcao_top_saude = '<?=$gerente_recepcao_top_saude?>';

        if(agenda_exames_id == '' && perfil_id == 1 || (gerente_recepcao_top_saude == 't' && perfil_id == 5)){
            excluir = '<a class="btn btn-outline-warning btn-round btn-sm"  href="#" onclick="confirmarEstorno('+paciente_inadimplencia_id+','+paciente_id+')">Excluir</a>';
        }

        $.ajax({
            type: "POST",
            data: {
                paciente_inadimplencia_id: paciente_inadimplencia_id
                },
            url: "<?= base_url() ?>ambulatorio/exametemp/infoinadimplecia/",
            dataType: 'json',
            async: false,
                success: function (i) {
                    nome = i[0].paciente;
                    data = i[0].data;
                    valor = i[0].valor;
                    procedimento = i[0].procedimento;
                    convenio = i[0].convenio;
                    observacao = i[0].observacaoinadimplencia;
                },
                error: function (i) {
                    alert('Erro ao Carregar Informações');
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
                            '<b>Procedimento:</b> '+procedimento+'<br>'+
                            '<b>Convenio:</b> '+convenio+'<br>'+
                            '<b>Observação:</b> '+observacao+'<br>'+
                            '<br>'+
                            faturar+
                            excluir+
                            '</div>'+
                            '<div class="modal-footer">'+
                                '<button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>'+
                            '</div>'+
                        '</div>'+
                '</div>');
    }

    function faturarinadimplencia(agenda_exames_id, procedimento_convenio_id, guia_id){
        window.open('<?=base_url()?>/ambulatorio/guia/faturarmodelo2/'+agenda_exames_id+'/'+procedimento_convenio_id+'/'+guia_id+'', '_blank', 'width=1000,height=800');
    }
    function faturarinadimplencia2(paciente_inadimplencia_id, paciente_id){
        window.open('<?=base_url()?>/ambulatorio/exametemp/faturarinadimplencia/'+paciente_inadimplencia_id+'/'+paciente_id+'', '_blank', 'width=1000,height=800');
    }

    $(document).ready(function() {
        $('#example').DataTable( {
            "ajax": "<?=base_url()?>datatable/listarinadimplencia/<?=$paciente_id?>",
            "columns": [
                { "data": "paciente" },
                { "data": "data" },
                { "data": "valor" },
                { "data": "procedimento" },
                { "data": "convenio" },
                { "data": "observacao" },
                { "data": "detalhe" }
            ],
            "filter": true,
            "language": {
                "url": "<?=base_url()?>bootstrap/DataTables/Portuguese-Brasil.json"
            }   
        } );
    } );
</script>