<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Sala</a></h3>
        <div>
            <form name="form_sala" id="form_sala" action="<?= base_url() ?>ambulatorio/sala/gravar" method="post">
                <fieldset>
                    <div class="row">
                        <div class="col-lg-4">
                            <div>
                                <label>Nome</label>
                                <input type="hidden" name="txtexamesalaid" class="texto10" value="<?= @$obj->_exame_sala_id; ?>" />
                                <input type="text" name="txtNome" class="form-control" value="<?= @$obj->_nome; ?>" />
                            </div>
                        </div>
                        <? if (@ $empresapermissao[0]->tabela_bpa == 't') { ?>
                            <div class="col-lg-2">
                                <div>
                                    <label title="Codigo CNES">Código CNES</label>
                                    <input type="text"  maxlength="7" minlength="7"  name="cod_cnes" id="cod_cnes" value="<?= @$obj->_cod_cnes ?>" class="form-control">
                                </div>
                            </div>
                        <? } ?>
                        <div class="col-lg-2">
                            <div>
                                <label>Armazem Estoque</label>
                                <select name="armazem" id="armazem" class="form-control">
                                    <option value="">SELECIONE</option>
                                    <? foreach ($armazem as $value) : ?>
                                        <option value="<?= $value->estoque_armazem_id; ?>"
                                            <?
                                            if (@$obj->_armazem_id == $value->estoque_armazem_id) {
                                                echo 'selected';
                                            }
                                            ?>><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Armazem Farmacia</label>
                                <select name="armazem_farmacia" id="armazem_farmacia" class="form-control">
                                    <option value="">SELECIONE</option>
                                    <? foreach ($armazem_farmacia as $value) : ?>
                                        <option value="<?= $value->farmacia_armazem_id; ?>"
                                            <?
                                            if (@$obj->_armazem_farmacia_id == $value->farmacia_armazem_id) {
                                                echo 'selected';
                                            }
                                            ?>><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Toten Sala ID</label>
                                <input type="number" name="toten_sala_id" class="form-control" value="<?= @$obj->_toten_sala_id; ?>" />
                            </div>
                        </div>
                        <?
                        $empresa_id = $this->session->userdata('empresa_id');

                        $data['retorno_permissao'] = $this->sala->listarpermissao($empresa_id);


                        if ($data['retorno_permissao'][0]->hora_agendamento == 't') { ?>
                            <div class="col-lg-2">
                                <div>
                                    <label>Hora Início</label>
                                    <input type="text" alt="time" name="hora_inicio" class="form-control " value="<?= @$obj->_hora_inicio; ?>" />
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div>
                                    <label>Hora Fim</label>
                                    <input type="text" alt="time" name="hora_fim" class="form-control " value="<?= @$obj->_hora_fim; ?>" />
                                </div>
                            </div>
                        <? } else {

                        }
                        ?>

                    </div>
                </fieldset>
                <hr/>
                <button class="btn btn-outline-success btn-sm" type="submit" name="btnEnviar">Enviar</button>
                <button class="btn btn-outline-warning btn-sm" type="reset" name="btnLimpar">Limpar</button>
                <!--<button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>-->
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
//    $('#btnVoltar').click(function () {
//        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
//    });

    $(function () {
        $("#accordion").accordion();
    });


    $(document).ready(function () {
        jQuery('#form_sala').validate({
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






    function frm_number_only_exc() {
// allowed: numeric keys, numeric numpad keys, backspace, del and delete keys
        if (event.keyCode == 37 || event.keyCode == 38 || event.keyCode == 39 || event.keyCode == 40 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || (event.keyCode < 106 && event.keyCode > 95)) {
            return true;
        } else {
            return false;
        }
    }

    $(document).ready(function () {

        $("input#cod_cnes").keydown(function (event) {

            if (frm_number_only_exc()) {

            } else {
                if (event.keyCode < 48 || event.keyCode > 57) {
                    event.preventDefault();
                }
            }
        });

    });







</script>