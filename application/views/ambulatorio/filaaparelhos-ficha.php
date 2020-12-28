
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de aparelho</a></h3>
        <div>
            <form name="form_sala" id="form_sala" action="<?= base_url() ?>ambulatorio/exame/gravaraparelho" method="post">
                <fieldset>
                    <div class="row">
                        <div class="col-lg-4">
                            <div>
                                <label>Nome do aparelho</label>
                                <input type="text" name="txtAparelho" id="txtAparelho" class="form-control" value="<?= @$obj[0]->aparelho; ?>" required/>
                                <input type="hidden" name="fila_aparelhos_id" id="fila_aparelhos_id" class="form-control" value="<?= @$obj[0]->fila_aparelhos_id; ?>"  />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div>
                                <label>Número de série</label>
                                <input type="text" name="txtNumserie" id="txtNumserie" class="form-control" value="<?= @$obj[0]->num_serie; ?>"/>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <hr/>
                <button class="btn btn-outline-success btn-sm" type="submit" name="btnEnviar">Enviar</button>
                <button class="btn btn-outline-default btn-sm" type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

 
 
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>ambulatorio/exame/listarfilaaparelho');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });

 
 $(function () {
    $("#txtNome").autocomplete({
        source: "<?= base_url() ?>index.php?c=autocomplete&m=paciente",
        minLength: 3,
        focus: function (event, ui) {
            $("#txtNome").val(ui.item.label);
            return false;
        },
        select: function (event, ui) {
            $("#txtNome").val(ui.item.value);
            $("#paciente_id").val(ui.item.id);
            return false;
        }
    });
});
</script>

