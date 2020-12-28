<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro Grupo Médico</a></h3>
        <div>
            <form name="form_grupomedico" id="form_grupomedico" action="<?= base_url() ?>cadastros/grupomedico/gravar" method="post">
                <fieldset>
                    <div class="row">
                        <div class="col-lg-4">
                            <label>Nome</label>
                            <input type="hidden" name="grupomedicoid" class="texto10" value="<?= @$obj->_operador_grupo_id; ?>" />
                            <input type="text" name="txtNome" class="form-control" value="<?= @$obj->_nome; ?>" />
                        </div>
                    </div>
                </fieldset>
                <hr/>
                <button class="btn btn-outline-success btn-sm" type="submit" name="btnEnviar">Enviar</button>
                <button class="btn btn-outline-warning btn-sm" type="reset" name="btnLimpar">Limpar</button>
                <button class="btn btn-outline-primary btn-sm" type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });


    $(document).ready(function(){
        jQuery('#form_grupomedico').validate( {
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