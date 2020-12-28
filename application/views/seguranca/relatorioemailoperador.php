<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar Relatório Operador</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>seguranca/operador/gerarelatorioemailoperador">
                <fieldset>
                    <div class="row">
                        <div class="col-lg-4">
                            <div>
                                <label>Perfil</label>
                                <select name="perfil" id="perfil" class="form-control" >
                                    <option value='0' >TODOS</option>
                                    <?foreach($perfil as $item){?>
                                        <option value='<?=$item->perfil_id?>' ><?=$item->nome?></option>
                                    <?}?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <label>&nbsp;</label>
                                <button class="btn btn-outline-success btn-sm" type="submit" >Pesquisar</button>
                            </div>

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