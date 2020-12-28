 
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Sigla</a></h3>
        <div>
            <form name="form_sala" id="form_sigla" action="<?= base_url() ?>ambulatorio/guia/gravarsigla" method="post">
                <fieldset>
                    <div class="row">
                        <div class="col-lg-4">
                            <div>
                                <label>Nome</label>
                                <input type="hidden" name="txtSiglaid" id="txtSiglaid" class="form-control" value="<?= @$sigla[0]->sigla_id; ?>" />
                                <input type="text" name="txtNome" id="txtNome" class="form-control" value="<?= @$sigla[0]->nome; ?>" required=""/>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <hr/>
                <button class="btn btn-outline-success btn-sm" type="submit" name="btnEnviar">Enviar</button>
                <!--<button type="reset" name="btnLimpar">Limpar</button>-->
                <button class="btn btn-outline-default btn-sm" type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>ambulatorio/guia/listarsigla/');
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