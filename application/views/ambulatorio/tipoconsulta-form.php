<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Tipo Agenda</a></h3>
        <div>
            <form name="form_sala" id="form_sala" action="<?= base_url() ?>ambulatorio/tipoconsulta/gravar" method="post">
                <fieldset>
                    <div class="row">
                        <div class="col-lg-4">
                            <label>Nome</label>
                            <input type="hidden" name="tipo_consulta_id" class="form-control" value="<?= @$obj->_ambulatorio_tipo_consulta_id; ?>" />
                            <input type="text" name="txtNome" class="form-control" value="<?= @$obj->_descricao; ?>" />
                        </div>
                        <div class="col-lg-2">
                            <label>Grupo</label>
                            <select name="grupo" id="grupo" class="form-control" >
                                <option value='' >Selecione</option>
                                <? foreach ($grupos as $grupo) { ?>
                                    <option value='<?= $grupo->nome ?>' <?
                                    if (@$obj->_grupo == $grupo->nome):echo 'selected';
                                    endif;
                                    ?>><?= $grupo->nome ?></option>
                                <? } ?>
                            </select>
                        </div>
                    </div>
                </fieldset>

                <hr/>
                <button class="btn btn-outline-success btn-sm" type="submit" name="btnEnviar">Enviar</button>
                <button class="btn btn-outline-warning btn-sm" type="reset" name="btnLimpar">Limpar</button>
                <button class="btn btn-outline-default btn-sm" type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>ambulatorio/tipoconsulta');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });


    $(document).ready(function(){
        jQuery('#form_sala').validate( {
            rules: {
                txtNome: {
                    required: true,
                    minlength: 2
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>