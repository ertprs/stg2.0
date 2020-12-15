<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3>Faturar</h3>
        <div>

            <?
            $empresa = $this->guia->listarempresas();
            $medicos = $this->operador_m->listarmedicos();
            $salas = $this->exame->listartodassalas();
            $convenios = $this->convenio->listarconvenionaodinheiro();
            $guia = "";
            ?>

            <form method="post" action="<?= base_url() ?>ambulatorio/exame/faturamentoexamelista">
                <fieldset>
                    <div class="row">
                        <div class="col-lg-2">
                            <div>
                                <label>Convenio</label>
                                <select name="convenio" id="convenio" class="form-control">
                                    <option value="" >TODOS</option>
                                    <? foreach ($convenios as $value) : ?>
                                        <option value="<?= $value->convenio_id; ?>" ><?php echo $value->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Médico</label>
                                <select name="medico" id="medico" class="form-control">
                                    <option value="0">TODOS</option>
                                    <? foreach ($medicos as $value) : ?>
                                        <option value="<?= $value->operador_id; ?>" ><?php echo $value->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Data Inicio</label>
                                <input class="form-control" type="date" name="txtdata_inicio" alt="date"/>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Data Fim</label>
                                <input class="form-control" type="date" name="txtdata_fim" alt="date"/>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Data De Pesquisa</label>
                                <select name="data_atendimento" id="data_atendimento" class="form-control" >
                                    <option value='1' >DATA DE ATENDIMENTO</option>
                                    <option value='0' >DATA DE FATURAMENTO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Especialidade</label>
                                <?
                                $grupo = $this->guia->listargrupo();
                                ?>
                                <select name="grupo" id="grupo" class="form-control" >
                                    <option value='0' >TODOS</option>

                                    <? foreach ($grupo as $value) : ?>
                                        <option value="<?= $value->nome; ?>" ><?php echo $value->nome; ?></option>
                                    <? endforeach; ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Faturamento</label>
                                <select name="faturamento" id="faturamento" class="form-control" >
                                    <option value='0' >TODOS</option>
                                    <option value='t' >Faturado</option>
                                    <option value='f' >Nao Faturado</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Situação</label>
                                <select name="situacao" id="situacao" class="form-control" >
                                    <option value=''>TODOS</option>
                                    <option value='GLOSADO' >Glosado</option>
                                    <option value='PAGO' >Pago</option>
                                    <option value='NAO PAGO' >Não Pago</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div>
                                <label>Nome</label>
                                <input type="text" name="nome" class="form-control"/>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Tipo</label>
                                <select name="tipo" id="tipo" class="form-control" required="">
                                    <option value="">SELECIONE</option>
                                    <option value="AMBULATORIAL">AMBULATORIAL</option>
                                    <option value="CIRURGICO">INTERNAÇÃO</option>
                                    <option value="CENTRO_CIRURGICO">CENTRO CIRURGICO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>Empresa</label>
                                <select name="empresa" id="empresa" class="form-control">
                                    <? foreach ($empresa as $value) : ?>
                                        <option value="<?= $value->empresa_id; ?>" ><?php echo $value->nome; ?></option>
                                    <? endforeach; ?>
                                    <option value="0">TODOS</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <br>
                <button class="btn btn-outline-success btn-sm" type="submit" >Pesquisar</button>
            </form>
           
            

        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">
    $(function () {
        $("#txtdata_inicio").datepicker({
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
        $("#txtdata_fim").datepicker({
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

</script>