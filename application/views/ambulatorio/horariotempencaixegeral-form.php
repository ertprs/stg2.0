<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/exametemp/gravarhorarioexameencaixegeral" method="post">
        <fieldset>
        <legend>Manter Exames</legend>
            <div class="row">
                <div class="col-lg-2">
                    <div>
                        <label>Data</label>
                        <input type="date"  id="data_ficha" name="data_ficha" class="form-control"  required/>
                        <input type="hidden" name="txtpaciente_id"  value="<?= @$obj->_ambulatorio_pacientetemp_id; ?>" />
                    </div>
                </div>
                <div class="col-lg-4">
                    <div>
                        <label>Sala</label>
                        <select name="sala" id="sala" class="form-control">
                            <option value="" >Selecione</option>
                            <? foreach ($salas as $item) : ?>
                                <option value="<?= $item->exame_sala_id; ?>" <? if (count($salas) == 1) echo 'selected'; ?>>
                                    <?= $item->nome; ?>
                                </option>
                            <? endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div>
                        <label>Medico</label>

                        <?php
                        if ($this->session->userdata('perfil_id') == 4 && $this->session->userdata('medico_agenda') == 't') {
                            ?>
                            <select name="medico" id="exame" class="form-control" required>
                                <? foreach ($medico as $item) : ?>
                                    <?php if ($item->operador_id == $this->session->userdata('operador_id')) { ?>
                                        <option value="<?= $item->operador_id; ?>"><?= $item->nome; ?></option>
                                    <?php } ?>
                                <? endforeach; ?>
                            </select>
                        <?php } else { ?>
                            <select name="medico" id="exame" class="form-control" required>
                                <option value="" >Selecione</option>
                                <? foreach ($medico as $item) : ?>
                                    <option value="<?= $item->operador_id; ?>"><?= $item->nome; ?></option>
                                <? endforeach; ?>
                            </select>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div>
                        <label>Tipo</label>
                        <select  name="tipo" id="tipo" class="form-control" >
                            <option value="EXAME">Exame</option>
                            <option value="CONSULTA">Consulta</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div>
                        <label>Horarios</label>
                        <input type="text" id="horarios" alt="time" class="form-control" name="horarios" required/>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div>
                        <label>Observa&ccedil;&otilde;es</label>
                        <input type="text" id="observacoes" class="form-control" name="observacoes" />
                    </div>
                </div>
            </div>
        </fieldset>
        <br>
        <fieldset>
            <div>
                <label>&nbsp;</label>
                <button class="btn btn-outline-success btn-sm" type="submit" name="btnEnviar">Adicionar</button>
            </div>
        </fieldset>


    </form>
</fieldset>



</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">


    $(function () {
        $("#data_ficha").datepicker({
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
        $("#txtNome").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=paciente",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtNome").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtNome").val(ui.item.value);
                $("#txtNomeid").val(ui.item.id);
                $("#telefone").val(ui.item.itens);
                $("#nascimento").val(ui.item.valor);
                return false;
            }
        });
    });


    $(function () {
        $("#accordion").accordion();
    });


    $(document).ready(function () {
        jQuery('#form_exametemp').validate({
            rules: {
                data_ficha: {
                    required: true
                },
                sala: {
                    required: true
                },
                medico: {
                    required: true
                },
                txtNome: {
                    required: true
                },
                horarios: {
                    required: true,
                    minlength: 5
                }
            },
            messages: {
                data_ficha: {
                    required: "*"
                },
                sala: {
                    required: "*"
                },
                medico: {
                    required: "*"
                },
                txtNome: {
                    required: "*"
                },
                horarios: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });


</script>
