<!--<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="pt-BR" >-->
<link href="<?= base_url() ?>css/calendario.css" rel="stylesheet"/>
<div id="page-wrapper">
    <script>
        var myjson;
//        $.getJSON("<?= base_url() ?>autocomplete/listarhorarioscalendario", json);
//            myjson = json;
//        function json(data) {
//
//            alert(data);
//        }
//        });
//        var myjson = '22';
//        console.log(myjson);
    </script>
    <?
    $medicos = $this->operador_m->listarmedicos();
    $especialidade = $this->exame->listarespecialidade();
//    $empresas = $this->exame->listarempresas();
//    $empresa_logada = $this->session->userdata('empresa_id');
    ?>

    <div class="panel panel-default">

        <!-- <div class="container"> -->
            <div class="col-lg-12">
                <!-- <div class="table-responsive" id="pesquisar"> -->
                    <form method="post" id="form" action="<?php echo base_url() ?>ambulatorio/exame/listarmultifuncaoconsultacalendario">
                        <div class="container">
                            <hr>
                            <div class="med">
                                <h6>Medico</h6>
                            </div>
                            <div class="actions">
                                <h6>Ações</h6>
                            </div>
                            <div class="calend">
                                <h6>Calendário</h6>
                            </div> 
                            <hr>
                            <div class="">
                                <!-- <td style="display:none;">
                                    <select name="especialidade" id="especialidade" class="form-control texto06">
                                        <option value=""></option>
                                        <? foreach ($especialidade as $value) : ?>
                                            <option value="<?= $value->cbo_ocupacao_id; ?>"<?
                                            if (@$_POST['especialidade'] == $value->cbo_ocupacao_id):echo 'selected';
                                            endif;
                                            ?>><?php echo $value->descricao; ?></option>
                                                <? endforeach; ?>
                                    </select>
                                </td> -->
                             </div>
                            <div class="medico">
                                <select name="medico" id="medico" class="form-control texto06">
                                    <option value="">TODOS</option>
                                    <? foreach ($medicos as $value) : ?>
                                        <option value="<?= $value->operador_id; ?>"<?
                                        if (@$_POST['medico'] == $value->operador_id):echo 'selected';
                                        endif;
                                        ?>>

                                            <?php echo $value->nome . ' - CRM: ' . $value->conselho; ?>


                                        </option>
                                    <? endforeach; ?>

                                </select>
                            </div>
                            <div class="action" style="text-align: center;"><button type="submit" class="btn btn-default btn-outline btn-danger btn-sm" name="enviar"><i class="fa fa-search fa-1x"></i></button></div>
                            <div class="calendar">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <div id="calendar">
                                                </div>
                                            </div>
                                            <!-- /.table-responsive -->
                                        </div>
                                        <!-- /.panel-body -->
                                    </div>
                                </div><!-- /.panel -->
                            </div>
                             
                        </div> 
                    </form>


                <!-- </div> -->
            </div>
        </div>
        <!-- <div class="panel-heading ">
            Calendário
        </div> -->
        <!-- <div class="row">
            <div class="col-lg-12">
                 <!-- /.panel-heading 
                <div class="panel-body">
                    <div class="table-responsive">
                        <div id='calendar'></div>
                    </div>
                    /.table-responsive 
                </div>
                /.panel-body 
            </div>
             /.panel 
        </div> -->
    </div>




</div >
<script>
//alert($('#medico').val());





    // $('#calendar').FullCalendar({
    //     header: {
    //         left: 'prev,next',
    //         center: 'title',
    //         right: 'today'
    //     },
    //     dayClick: function (date) {
    //         var data = date.format();

    //         window.open('<?= base_url() ?>ambulatorio/exame/listarmultifuncaoconsulta?empresa=&especialidade=&medico=&situacao=&data=' + moment(data).format('DD%2FMM%2FYYYY') + '&nome=', '_self');



    //     },
    //     //eventDragStop: function (date, jsEvent, view) {
    //         //alert(date.format());
    //     //},
    //     //navLinks: true,
    //     showNonCurrentDates: false,
    //         //weekends: false,

    //         //navLinks: true, // can click day/week names to navigate views
    //     defaultDate: '<?= date('Y-m-d') ?>',
    //     locale: 'pt-br',
    //     editable: false,
    //     eventLimit: true, // allow "more" link when too many events
    //     schedulerLicenseKey: 'CC-Attribution-Commercial-NoDerivatives',

    //             //events: '<?= base_url() ?>autocomplete/listarhorarioscalendario',

    //     eventSources: [

    //         // your event source

    //         {

    //             url: '<?= base_url() ?>autocomplete/listarhorarioscalendario',
    //             type: 'POST',
    //             data: {
    //                 medico: $('#medico').val(),
    //                 especialidade: $('#especialidade').val()
    //             },
    //             error: function () {
    //                 alert('there was an error while fetching events!');
    //             }
    //                 //color: 'yellow', // a non-ajax option
    //                 //textColor: 'black' // a non-ajax option
    //         }

    //             //any other sources...

    //     ]

    // });
//calendar finish

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar : {
            left: 'prev,next',
            center: 'title',
            right: 'dayGridMonth'
            },
            
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            initialView: 'dayGridMonth',
            
                eventSources: [

            // your event source

            {

                url: '<?= base_url() ?>autocomplete/listarhorarioscalendario',
                type: 'POST',
                data: {
                    medico: $('#medico').val(),
                    especialidade: $('#especialidade').val()
                },
                error: function () {
                    alert('calendario não apresenta eventos agendados!');
                }
                    //color: 'yellow', // a non-ajax option
                    //textColor: 'black' // a non-ajax option
            }

                //any other sources...

        ],

        dateClick: function(info) {
            // alert('Clicked on: ' + info.dateStr);
            // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
            // alert('Current view: ' + info.view.type);
            // change the day's background color just for fun
            info.dayEl.style.backgroundColor = 'lightblue';

            var data = info.dateStr;

             window.open('<?= base_url() ?>ambulatorio/exame/listarmultifuncaoconsulta?empresa=&especialidade=&medico=&situacao=&data=' + moment(data).format('DD%2FMM%2FYYYY') + '&nome=', '_self');
        },
        showNonCurrentDates: false,
        defaultDate: '<?= date('Y-m-d') ?>',
        locale: 'pt-br',
        editable: false,
        eventLimit: true, // allow "more" link when too many events
        

            
        });
        calendar.render();


   





//    $(document).ready(function () {



//            $.getJSON("<?= base_url() ?>autocomplete/listarhorarioscalendario", json);
//            function json(data) {


//            }

//    });
    $('#medico').change(function () {
        document.getElementById('form').submit();
    });
    $('#especialidade').change(function () {
        document.getElementById('form').submit();
    });

    $(function () {
        $('#especialidade').change(function () {

            if ($(this).val()) {

//                                                  alert('teste_parada');
                $('.carregando').show();
//                                                        alert('teste_parada');
                $.getJSON('<?= base_url() ?>autocomplete/medicoespecialidade', {txtcbo: $(this).val(), ajax: true}, function (j) {
                    options = '<option value="">TODOS</option>';
                    console.log(j);

                    for (var c = 0; c < j.length; c++) {


                        if (j[0].operador_id != undefined) {
                            options += '<option value="' + j[c].operador_id + '">' + j[c].nome + '</option>';

                        }
                    }
                    $('#medico').html(options).show();
                    $('.carregando').hide();



                });
            } else {
                $('.carregando').show();
//                                                        alert('teste_parada');
                $.getJSON('<?= base_url() ?>autocomplete/medicoespecialidadetodos', {txtcbo: $(this).val(), ajax: true}, function (j) {
                    options = '<option value="">TODOS</option>';
                    console.log(j);

                    for (var c = 0; c < j.length; c++) {


                        if (j[0].operador_id != undefined) {
                            options += '<option value="' + j[c].operador_id + '">' + j[c].nome + '</option>';

                        }
                    }
                    $('#medico').html(options).show();
                    $('.carregando').hide();



                });

            }
        });
    });
    
    
    if ($('#especialidade').val()) {

//                                                  alert('teste_parada');
                $('.carregando').show();
//                                                        alert('teste_parada');
                $.getJSON('<?= base_url() ?>autocomplete/medicoespecialidade', {txtcbo: $('#especialidade').val(), ajax: true}, function (j) {
                    options = '<option value="">TODOS</option>';
                    console.log(j);

                    for (var c = 0; c < j.length; c++) {


                        if (j[0].operador_id != undefined) {
                            options += '<option value="' + j[c].operador_id + '">' + j[c].nome + '</option>';

                        }
                    }
                    $('#medico').html(options).show();
                    $('.carregando').hide();



                });
            } else {
                

            }
</script>


