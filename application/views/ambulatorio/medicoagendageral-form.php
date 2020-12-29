<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <label>Bloqueio / Altera&ccedil;&otilde;s</label>
        <div>
            <form name="form_medicoagenda" id="form_medicoagenda" action="<?= base_url() ?>ambulatorio/agenda/gravarmedicogeral" method="post">
                <fieldset>
                    <div class="row">
                        <div class="col-lg-2">
                            <label>A&ccedil;&atilde;o</label>
                            <select name="txtacao" size="1" class="form-control" id="teste"  >
                                <option value="Bloquear">Bloquear</option>
                                <option value="Alterarmedico">Alterar medico</option>
                                <option value="Excluir">Excluir hor&aacute;rios</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label>Medico</label>
                            <?
                            $operador_id = $this->session->userdata('operador_id');
                            $perfil_id = $this->session->userdata('perfil_id');
                            ?>
                            <select name="medico" id="medico" class="form-control">
                                <option value=""></option>
                                <?
                                foreach ($medicos as $value) {
                                    if (($value->operador_id == $operador_id && $perfil_id == 4) || $perfil_id != 4) {
                                        ?>
                                        <option value="<?= $value->operador_id; ?>"><?php echo $value->nome; ?></option>
                                        <?
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label>Salas</label>
                            <select name="sala" id="sala" class="form-control">
                                <option value=""></option>
                                <? foreach ($salas as $value) : ?>
                                    <option value="<?= $value->exame_sala_id; ?>"><?php echo $value->nome; ?></option>
                                <? endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label>Data inicio</label>
                            <input type="text"  id="datainicio" name="datainicio" class="form-control"/>
                        </div>
                        <div class="col-lg-2">
                            <label>Data fim</label>
                            <input type="text"  id="datafim" name="datafim" class="form-control"/>
                        </div>
                        <div class="col-lg-2">
                            <label>Hora inicio</label>
                            <input type="text" alt="time" id="horainicio" name="horainicio" class="form-control"/>
                        </div>
                        <div class="col-lg-2">
                            <label>Hora fim</label>
                            <input type="text" alt="time" id="horafim" name="horafim" class="form-control"/>
                        </div>
                        <div class="col-lg-4">
                            <label>Observacao</label>
                            <textarea type="text" name="txtobservacao" cols="55" class="form-control"></textarea>
                        </div>
                        <br>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="custom-control custom-checkbox mb-3">
                                    <input class="custom-control-input" id="customCheck1" type="checkbox" name="txtsegunda">
                                    <label class="custom-control-label" for="customCheck1">
                                        <span>Segunda-feira &nbsp;</span>
                                    </label>
                                </div>
                                <div class="custom-control custom-checkbox mb-3">
                                    <input class="custom-control-input" id="customCheck2" type="checkbox" name="txtterca">
                                    <label class="custom-control-label" for="customCheck2">
                                        <span>Terça-feira &nbsp;</span>
                                    </label>
                                </div>
                                <div class="custom-control custom-checkbox mb-3">
                                    <input class="custom-control-input" id="customCheck3" type="checkbox" name="txtquarta">
                                    <label class="custom-control-label" for="customCheck3">
                                        <span>Quarta-Feira &nbsp;</span>
                                    </label>
                                </div>
                                <div class="custom-control custom-checkbox mb-3">
                                    <input class="custom-control-input" id="customCheck4" type="checkbox" name="txtquinta">
                                    <label class="custom-control-label" for="customCheck4">
                                        <span>Quinta-feira &nbsp;</span>
                                    </label>
                                </div>
                                <div class="custom-control custom-checkbox mb-3">
                                    <input class="custom-control-input" id="customCheck5" type="checkbox" name="txtsexta">
                                    <label class="custom-control-label" for="customCheck5">
                                        <span>Sexta-feira &nbsp;</span>
                                    </label>
                                </div>
                                <div class="custom-control custom-checkbox mb-3">
                                    <input class="custom-control-input" id="customCheck6" type="checkbox" name="txtsabado">
                                    <label class="custom-control-label" for="customCheck6">
                                        <span>Sabado &nbsp;</span>
                                    </label>
                                </div>
                                <div class="custom-control custom-checkbox mb-3">
                                    <input class="custom-control-input" id="customCheck7" type="checkbox" name="txtdomingo">
                                    <label class="custom-control-label" for="customCheck7">
                                        <span>Domingo &nbsp;</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            <hr/>
                <button class="btn btn-outline-default btn-sm" type="submit" name="btnEnviar">Enviar</button>
                <button class="btn btn-outline-default btn-sm" type="reset" name="btnLimpar">Limpar</button>
                <button class="btn btn-outline-default btn-sm" type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

    $(function () {
        $("#datainicio").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });
    $(function () {
        $("#datafim").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(function () {
        $("#accordion").accordion();
    });

    $(document).ready(function () {
        jQuery('#form_medicoagenda').validate({
            rules: {
                medico: {
                    required: true
                },
                datainicio: {
                    required: true
                },
                datafim: {
                    required: true
                },
                horainicio: {
                    required: true
                },
                horafim: {
                    required: true
                }
            },
            messages: {
                medico: {
                    required: "*"
                },
                datainicio: {
                    required: "*"
                },
                datafim: {
                    required: "*"
                },
                horainicio: {
                    required: "*"
                },
                horafim: {
                    required: "*"
                }
            }
        });
    });

</script>