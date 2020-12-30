<div class="content ficha_ceatox">
    <div class="accordion">
        <legend class="singular"><b>Nova Inadimplência - Dados do Paciente</b></legend>
            <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/exametemp/gravarinadimplencia" method="post">
                <div class="row">
                        <fieldset>
                            <div class="col-lg-5">
                                <div>
                                    <label>Nome</label>                      
                                    <input type="text" id="txtNome" name="nome"  class="form-control" value="<?= $paciente['0']->nome; ?>" readonly/>
                                    <input type="hidden" id="txtpaciente_id" name="txtpaciente_id"  value="<?= $paciente_id; ?>"/>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div>
                                    <label>Sexo</label>
                                    <input type="text" id="txtSexo" name="sexo"  class="form-control" value="<?
                                    if ($paciente['0']->sexo == "M"):echo 'Masculino'; endif;
                                    if ($paciente['0']->sexo == "F"):echo 'Feminino'; endif;
                                    if ($paciente['0']->sexo == "O"):echo 'Outro'; endif;
                                    ?>" readonly/>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div>
                                    <label>Nascimento</label>
                                    <input type="text" name="nascimento" id="txtNascimento" class="form-control" alt="date" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" readonly/>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div>
                                    <label>Idade</label>
                                    <input type="text" name="idade" id="txtIdade" class="form-control" alt="numeromask" value="<?= $paciente['0']->idade; ?>" readonly />
                                </div>
                            </div>
                        </fieldset>
                </div>
                <br>
                <div class="row">
                    <legend class="singular"><b>Dados Inadimplencia</b></legend>
                    <fieldset>
                        <div class="col-lg-4">
                            <div>
                                <label>Convenio</label>
                                <select name="convenio1" id="convenio1" class="form-control" required>
                                    <option value="">Selecione</option>
                                    <? foreach ($convenio as $item) : ?>
                                        <option value="<?= $item->convenio_id; ?>"><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div>
                                <label>Procedimento</label>
                                <select name="procedimento1" id="procedimento1" class="form-control chosen-select" data-placeholder="Selecione" tabindex="1" required="">
                                    <option value="">Selecione</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div>
                                <label>Valor Unitario</label>
                                <input type="text" name="valor1" id="valor" class="form-control" required/>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <label>Observação</label>
                                <textarea class="form-control" name="observacaoinadimplencia" rows="2"></textarea>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <br><br>
                <fieldset>
                    <div>
                        <label>&nbsp;</label>
                        <button class="btn btn-outline-success btn-sm" type="submit" name="btnEnviar">Adicionar</button>
                    </div>
                </fieldset>
            </form>
    </div>
</div>

<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

    $(function () {
        $('#convenio1').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniotodos', {convenio1: $(this).val(), ajax: true}, function (j) {
                    var options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                    }
//                    $('#procedimento1').html(options).show();
                    $('#procedimento1 option').remove();
                    $('#procedimento1').append(options);
                    $("#procedimento1").trigger("chosen:updated");
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento1 option').remove();
                $('#procedimento1').append('');
                $("#procedimento1").trigger("chosen:updated");
//                $('#procedimento1').html('<option value="">-- Escolha um exame --</option>');
            }
        });
    });


    $(function () {
        $('#procedimento1').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: $(this).val(), ajax: true}, function (j) {
                    options = "";
                    options += j[0].valortotal;
                   

                    document.getElementById("valor").value = options;
                    $('.carregando').hide();
                });
            } else {
                $('#valor').html('value=""');
            }
        });
    });
    <? 
    if(@$permissoes[0]->ajuste_pagamento_procedimento == 't'){ 
        ?>
        $(function () {
            $('#procedimento1').change(function () {
                if ($(this).val()) {
                    $('.carregando').show();

                    var procedimento = $(this).val();
                    $("#formapamento").prop('required', false);
                    $("#valorAjuste").val('');

                    $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento1', {procedimento1: $(this).val(), ajax: true}, function (j) {

                        verificaAjustePagamentoProcedimento(procedimento);
                        var options = '<option value="">Selecione</option>';
                        for (var c = 0; c < j.length; c++) {
                            if (j[c].forma_pagamento_id != null) {
                                options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                            }
                        }
                        $('#formapamento').html(options).show();
                        $('.carregando').hide();

                    });
                }
            });
        });
        <? 
    } 
    ?>

    
    function verificaAjustePagamentoProcedimento(procedimentoConvenioId){
        <? if(@$permissoes[0]->ajuste_pagamento_procedimento == 't'){ ?>
            $.getJSON('<?= base_url() ?>autocomplete/verificaAjustePagamentoProcedimento', {procedimento: procedimentoConvenioId, ajax: true}, function (p) {
                if (p.length != 0) {
                    $("#formapamento").prop('required', true);
                }
            });
        <? } ?>
    }

    function buscaValorAjustePagamentoProcedimento(){                                    
        $.getJSON('<?= base_url() ?>autocomplete/buscaValorAjustePagamentoProcedimento', {procedimento: $('#procedimento1').val(), forma: $('#formapamento').val(), ajax: true}, function (p) {
            if (p.length != 0) {
                $("#valorAjuste").val(p[0].ajuste);
            }
            else{
                $("#valorAjuste").val('');
            }
        });
    }

</script>