<? $empresa_logada = $this->session->userdata('empresa_id'); ?>
<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="accordion">
        <legend class="singular"><b>Agenda Geral</b></legend>
        <div name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/exametemp/gravarpacienteencaixegeral" method="post">
            <div class="row">
                <fieldset>
                    <div class="col-lg-2">
                        <div>
                            <label>Data</label>
                            <input type="date"  id="data_ficha" name="data_ficha" class="form-control" required />
                            <input type="hidden" name="txtpaciente_id"  value="<?= @$obj->_ambulatorio_pacientetemp_id; ?>" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div>
                            <label>Sala</label>
                            <select name="sala" id="sala" class="form-control" required>
                                <option value="" >Selecione</option>
                                <? foreach ($salas as $item) : ?>
                                    <option value="<?= $item->exame_sala_id; ?>" <? if (count($salas) == 1) echo 'selected';?>>
                                        <?= $item->nome; ?>
                                    </option>
                                <? endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div>
                            <label>Médico</label>

                            <?php
                            if ($this->session->userdata('perfil_id') == 4 && $this->session->userdata('medico_agenda') == 't') {
                                ?>
                                <select name="medico" id="medico" class="form-control" required>

                                    <? foreach ($medico as $item) : ?>
                                        <?php if ($item->operador_id == $this->session->userdata('operador_id')) { ?>
                                            <option value="<?= $item->operador_id; ?>" selected><?= $item->nome; ?></option>
                                        <?php } ?>
                                    <? endforeach; ?>
                                </select>
                            <?php }else { ?>
                                <select name="medico" id="medico" class="form-control" required>
                                    <option value="" >Selecione</option>
                                    <? foreach ($medico as $item) : ?>
                                        <option value="<?= $item->operador_id; ?>"><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>

                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div>
                            <label>Empresa</label>
                            <select name="empresa" id="empresa" class="form-control">
                                <option value="">Selecione</option>
                                <?
                                foreach ($empresas as $value) :
                                    ?>
                                    <option value="<?= $value->empresa_id; ?>" <?
                                    if ($empresa_logada == $value->empresa_id) {
                                        echo 'selected';
                                    }
                                    ?>><?php echo $value->nome; ?></option>
                                <? endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div>
                            <label>Horários</label>
                            <input type="text" id="horarios" class="form-control" name="horarios" required/>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div>
                            <label>Convênio *</label>
                            <select name="convenio1" id="convenio1" class="form-control" required>
                                <option value="">Selecione</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div>
                            <label>Procedimento *</label>
                            <select  name="procedimento1" id="procedimento1" class="form-control" required>
                                <option value="">Selecione</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div>
                            <label>Observa&ccedil;&otilde;es</label>
                            <input type="text" id="observacoes" class="form-control" name="observacoes" />
                        </div>
                    </div>
                </fieldset>
                <div class="row">
                    <fieldset>
                    <legend><b>Paciente</b></legend>
                        <div class="col-lg-5">
                            <div>
                                <label>Nome</label>
                                <input type="hidden" id="txtNomeid" class="form-control" name="txtNomeid" readonly="true" />
                                <input type="text" id="txtNome" name="txtNome" class="form-control" />
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div>
                                <label>Dt de nascimento</label>
                                <input type="date" name="nascimento" id="nascimento" class="form-control"/>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div>
                                <label>End.</label>
                                <input type="text" id="txtEnd" class="form-control" name="txtEnd" />
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Telefone</label>
                                <input type="text" id="telefone" class="texto02" name="telefone"/>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Celular</label>
                                <input type="text" id="celular" class="texto02" name="celular"/>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Whatsapp</label>
                                <input type="text" id="whatsapp" class="texto02" name="whatsapp"/>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>CPF</label>
                                <input type="text" id="txtcpf" class="texto02" name="txtcpf" alt="cpf" value=""/>
                            </div>
                        </div>




                        <div>
                            <label>&nbsp;</label>
                            <button type="submit" name="btnEnviar">Adicionar</button>
                        </div>
                    </fieldset>
                </div>
            </div>
        </form>
    </div>



</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script>
    function mascaraTelefone(campo) {

        function trata(valor, isOnBlur) {

            valor = valor.replace(/\D/g, "");
            valor = valor.replace(/^(\d{2})(\d)/g, "($1)$2");

            if (isOnBlur) {

                valor = valor.replace(/(\d)(\d{4})$/, "$1-$2");
            } else {

                valor = valor.replace(/(\d)(\d{3})$/, "$1-$2");
            }
            return valor;
        }

        campo.onkeypress = function (evt) {

            var code = (window.event) ? window.event.keyCode : evt.which;
            var valor = this.value

            if (code > 57 || (code < 48 && code != 0 && code != 8 && code != 9)) {
                return false;
            } else {
                this.value = trata(valor, false);
            }
        }

        campo.onblur = function () {

            var valor = this.value;
            if (valor.length < 13) {
                this.value = ""
            } else {
                this.value = trata(this.value, true);
            }
        }

        campo.maxLength = 14;
    }


</script>
<script type="text/javascript">
    jQuery("#telefone")
            .mask("(99) 9999-9999?9")
            .focusout(function (event) {
                var target, phone, element;
                target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                phone = target.value.replace(/\D/g, '');
                element = $(target);
                element.unmask();
                if (phone.length > 10) {
                    element.mask("(99) 99999-999?9");
                } else {
                    element.mask("(99) 9999-9999?9");
                }
            });

    jQuery("#celular")
            .mask("(99) 9999-9999?9")
            .focusout(function (event) {
                var target, phone, element;
                target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                phone = target.value.replace(/\D/g, '');
                element = $(target);
                element.unmask();
                if (phone.length > 10) {
                    element.mask("(99) 99999-999?9");
                } else {
                    element.mask("(99) 9999-9999?9");
                }
            });

    jQuery("#whatsapp")
            .mask("(99) 9999-9999?9")
            .focusout(function (event) {
                var target, phone, element;
                target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                phone = target.value.replace(/\D/g, '');
                element = $(target);
                element.unmask();
                if (phone.length > 10) {
                    element.mask("(99) 99999-999?9");
                } else {
                    element.mask("(99) 9999-9999?9");
                }
            });



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

    function carregarConvenios(){
        var medico = $('#medico').val();
        if (medico != '') {
                var empresa = $('#empresa').val();
                if(empresa != ''){
                    $('.carregando').show();
                    $.getJSON('<?= base_url() ?>autocomplete/medicoconveniojson', {exame: medico, empresa_id: empresa, ajax: true}, function (j) {
                    var options = '<option value=""></option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].convenio_id + '">' + j[i].nome + '</option>';
                    }
                    $('#convenio1').html(options).show();
                    $('.carregando').hide();
                });
                }else{
                    $('#convenio1').html('<option value="">-- Escolha uma Empresa --</option>');
                }
            } else {
                $('#convenio1').html('<option value="">-- Escolha um Médico --</option>');
            }
    }

    $(function () {
        $('#medico').change(function () {
            carregarConvenios();
        });
    });

    $(function () {
        $('#empresa').change(function () {
            carregarConvenios();
        });
    });

    $(function () {
        $('#convenio1').change(function () {
//                            alert('entrou');
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniomedico', {convenio1: $(this).val(), teste: $("#medico").val(), empresa_id: $("#empresa").val()}, function (j) {
                    options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                    }
                    $('#procedimento1').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento1').html('<option value="">Selecione</option>');
            }
        });
    });

    $(function () {
        $("#txtNome").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=paciente",
            minLength: 10, // Todas as telas de agendamento eu coloquei esse comentario. Quando for alterar esse valor, basta ir em "Localizar em Projetos" e pesquisar por ele.
            focus: function (event, ui) {
                $("#txtNome").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtNome").val(ui.item.value);
                $("#txtNomeid").val(ui.item.id);
                $("#telefone").val(ui.item.itens);
                $("#celular").val(ui.item.celular);
                $("#whatsapp").val(ui.item.whatsapp);
                $("#nascimento").val(ui.item.valor);
                $("#txtEnd").val(ui.item.endereco);
                $("#txtcpf").val(ui.item.cpf);
                return false;
            }
        });
    });
    
    $(function () {
        $('#data_ficha').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/medicoconveniojson', {exame: $("#medico").val(), ajax: true}, function (j) {
                    var options = '<option value=""></option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].convenio_id + '">' + j[i].nome + '</option>';
                    }
                    $('#convenio1').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#convenio1').html('<option value="">-- Escolha um hora --</option>');
            }
        });
    });


    $(function () {
        $("#accordion").accordion();
    });



    jQuery("#nascimento").mask("99/99/9999");
    jQuery("#horarios").mask("99:99");
    
    
    $(function () {
        $("#txtcpf").autocomplete({            
            source: "<?= base_url() ?>index.php?c=autocomplete&m=pacienteporcpf",
            minLength: 2,
            focus: function (event, ui) {
                $("#txtcpf").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtNome").val(ui.item.value);
                $("#txtNomeid").val(ui.item.id);
                $("#telefone").val(ui.item.itens);
                $("#celular").val(ui.item.celular);
                $("#nascimento").val(ui.item.valor);
                $("#whatsapp").val(ui.item.whatsapp);
                $("#txtEnd").val(ui.item.endereco);
                $("#txtcpf").val(ui.item.cpf);
                return false;
            }
        });
    });

</script>
