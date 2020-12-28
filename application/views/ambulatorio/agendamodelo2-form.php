<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a class="btn btn-outline-primary btn-sm" href="<?= base_url() ?>ambulatorio/agenda">
            Voltar
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Horario</a></h3>
        <div>
            <form name="form_horariostipo" id="form_horariostipo" action="<?= base_url() ?>ambulatorio/agenda/gravarmodelo2" method="post">
                <fieldset>
                    <div class="row">
                        <div class="col-lg-4">
                            <div>
                                <label>Nome*</label>
                                <input type="hidden" name="txthorariostipoID" value="<?= @$obj->_agenda_id; ?>" />
                                <input type="text" name="txtNome" class="texto10 bestupper form-control" value="<?= @$obj->_nome; ?>" required/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div>
                                <label>Medico *</label>
                                <select name="medico_id" id="txtmedico" class="form-control" required>
                                    <option value="">Selecione</option>
                                    <? foreach ($medico as $item) : ?>
                                        <option value="<?= $item->operador_id; ?>"><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div>
                                <label>Tipo Agenda *</label>
                                <select name="tipo_agenda" id="tipo_agenda" class="form-control" required>
                                    <option value="">Selecione</option>
                                    <? foreach ($tipo as $item) : ?>
                                        <option value="<?= $item->ambulatorio_tipo_consulta_id; ?>"><?= $item->descricao; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
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
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });

    $(document).ready(function(){
        jQuery('#form_horariostipo').validate( {
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                },
                txtTipo: {
                    required: true
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                txtTipo: {
                    required: "*"
                }
            }
        });
    });

</script>