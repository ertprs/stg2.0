<div class="content ficha_ceatox">
    <div class="accordion">
        <legend class="singular"><b>Dados do Paciente</b></legend>
            <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/exametemp/gravartransferircredito" method="post">
                <div class="row">
                        <fieldset>
                            <div class="col-lg-5">
                                <div>
                                    <label>Nome</label>                      
                                    <input type="text" id="txtNome" name="nome"  class="form-control" value="<?= $paciente['0']->nome; ?>" readonly/>
                                    <input type="hidden" id="paciente_id" name="paciente_id"  value="<?= $paciente_id; ?>"/>
                                    <input type="hidden" id="credito_id" name="credito_id"  value="<?= $credito_id; ?>"/>
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
                <legend class="singular"><b>Transferir Créditos</b></legend>
                    <div class="row">
                        <fieldset>
                            <div class="col-lg-10   ">
                                <div>
                                    <label>Valor do Crédito</label>
                                    <input type="text" name="valorCredito" id="valorCredito" class="form-control" value="<?= number_format($credito['0']->valor, 2, ',', '.'); ?>" readonly/>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                <br>
                <legend class="singular"><b>Paciente que receberá o crédito</b></legend>
                    <div class="row">
                        <fieldset>
                            <div class="col-lg-5">
                                <div>
                                    <label>Nome</label>
                                    <input type="text" id="txtpaciente" class="form-control" name="txtpaciente" />
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div>
                                    <label>Prontuario</label>
                                    <input type="text" id="pacienteid" class="form-control" name="paciente_new_id" readonly/>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div>
                                    <label>Nascimento</label>
                                    <input type="text" name="txtdtnascimento" id="txtdtnascimento" class="form-control" readonly/>
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
        $("#txtpaciente").autocomplete({
            source: "<?= base_url() ?>autocomplete/pacientetransferircredito?term="+$("#txtpaciente").val()+"&paciente_atual=<?=@$paciente['0']->paciente_id?>",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtpaciente").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtpaciente").val(ui.item.value);
                $("#txtnome_mae").val(ui.item.mae);
                $("#txtdtnascimento").val(ui.item.valor);
                $("#pacienteid").val(ui.item.id);
                return false;
            }
        });
    });
</script>