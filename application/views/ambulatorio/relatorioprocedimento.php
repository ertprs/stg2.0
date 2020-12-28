<link href="<?= base_url() ?>css/ambulatorio/relatorioprocedimento.css" rel="stylesheet" type="text/css"/>
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar Relatório Procedimentos</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>ambulatorio/procedimento/gerarelatorioprocedimento">
                <fieldset>
                    <div class="row">
                        <div class="col-lg-2">
                            <label>Grupo</label>
                            <select name="grupo" id="grupo" class="form-control" >
                                <option value='0' >TODOS</option>
                                <option value='1' >SEM RM</option>
                                <? foreach ($grupos as $grupo) { ?>
                                    <option value='<?= $grupo->nome ?>' <?
                                    if (@$obj->_grupo == $grupo->nome):echo 'selected';
                                    endif;
                                    ?>><?= $grupo->nome ?></option>
                                <? } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label>Subgrupo</label>
                            <select name="subgrupo" id="subgrupo" class="form-control" >
                                <option value='0' >TODOS</option>
                                <? foreach ($subgrupos as $grupo) { ?>
                                    <option value='<?= $grupo->ambulatorio_subgrupo_id ?>'><?= $grupo->nome ?></option>
                                <? } ?>
                            </select>
                        </div>
                        <div class="col-lg-2 btnsend">
                            <button class="btn-outline-success btn-sm" type="submit" >Pesquisar</button>
                        </div>
                    </div>
                </fieldset>
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