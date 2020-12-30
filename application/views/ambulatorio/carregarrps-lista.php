<?
$perfil_id = $this->session->userdata('perfil_id');
?>
<div class="content  " > <!-- Inicio da DIV content -->

    <div id="accordion">
        <h3 ><a href="#">Impressão RPS</a></h3>


            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Procedimento</th>
                        <th><center>Detalhes</center></th>
                    </tr>
                </thead>
            </table>
            

    </div>

</div> <!-- Final da DIV content -->


<script type="text/javascript">
    
$(function () {
        $("#accordion").accordion();
    });

    function abrirImpressao(procedimento_tuss_id, paciente_id, paciente_tcd_id, procedimento_convenio_id){
        window.open('<?= base_url()?> ambulatorio/exametemp/imprimirtcd2/'+procedimento_tuss_id+'/'+paciente_id+'/'+paciente_tcd_id+'/'+procedimento_convenio_id+'', '_blank', 'toolbar=no,Location=no,menubar=no,width=1000,height=650');
    }

    $(document).ready(function() {
        $('#example').DataTable( {
            "ajax": "<?=base_url()?>datatable/listaprocedimentosRPS/<?=$paciente_tcd_id?>",
            "columns": [
                { "data": "procedimento" },
                { "data": "imprimir" }
            ],
            "language": {
                "url": "<?=base_url()?>bootstrap/DataTables/Portuguese-Brasil.json"
            }
        } );
    } );

</script>

