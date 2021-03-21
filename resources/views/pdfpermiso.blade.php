<?php 
    use Jenssegers\Date\Date;
?>

<html>
<head>
    <title>Permiso PDF</title>
    <style>
        /*@page { size: 500pt 500pt; }*/
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
    <header>
        <img class="float-left mt-3 ml-5 pl-5" src="assets/img/logo1.png" width="80" alt="">
        <img class="float-right mt-3 mr-5 pr-5" src="assets/img/logo_2.png" height="60" alt="">
    </header>
    <div class="container mt-0 pt-0">
        <p class="tittle mt-0 pt-0 mb-2 pb-0">PERMISO PARA REALIZAR MANIOBRAS DE CARGA Y DESCARGA</p>
        <div class="container">
            @foreach ($permisos as $permiso)
            <div class="folio texto border border-3 border-dark"><b>Permiso:</b> {{ $permiso->folio }}</div>
            @endforeach
            <div class="container">
                <p class="texto mb-1 pb-0">A QUIEN CORRESPONDA:</p>
                <p class="texto mb-1 mt-2 pb-0">Por medio de la precente la Dirección de Tráncito, concede permiso al vehículo de las siguientes características:</p>
                
                <table class="table table-bordered texto">
                    <tbody>
                        @foreach ($permisos as $permiso)    
                        <tr>
                            <td class="margen"><b>Marca:</b> <br> {{ $permiso->marca }}</td>
                            <td class="margen"><b>Tipo:</b> <br> {{ $permiso->tipo }}</td>
                            <td class="margen"><b>Color:</b> <br> {{ $permiso->color_vehiculo }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td><b>Placas:</b> <br> {{ $permiso->placas }}</td>
                            <td><b>Recibo de pago estatal:</b> <br> {{ $permiso->referencia_pago }}</td>
                            <td><b>Toneladas:</b> <br> {{ $permiso->tonelada_maniobra }}</td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Nombre del Chofer:</b> <br> {{ $permiso->nombre_chofer }} {{ $permiso->primer_apellido }} {{ $permiso->segundo_apellido }}</td>
                            <td><b>Numero de licencia:</b> <br> {{ $permiso->licencia }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"><b>Persona física o razón social:</b> {{ $permiso->persona_razon_social }}</td>
                        </tr>
                    </tbody>
                </table>

                <p class="texto mt-0 mb-1 pt-0 pb-0">Para que pueda realizar manobras de carga y descarga en el primer cuadro de la ciudad.</p>

                <table class="table texto table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="4"><b class=" mr-5">Comercio denominado:</b> {{ $permiso->comercio_denominado }}</td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>Ubicado en:</b> {{ $permiso->direccion }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <b>Con horario según su peso bruto:</b>{{-- de {{ $permiso->horarios }} --}}
                                <table class="mb-0 texto">
                                    <tbody class="m-0 p-1">
                                        <tr class="m-0 p-1">
                                            <td class="m-0 p-1 text-center text-bold"><b>PESO</b></td>
                                            <td class="m-0 p-1 text-center text-bold"><b>HORARIO</b></td>
                                        </tr>
                                        <tr class="m-0 p-1">
                                            <td class="m-0 p-1 <?php if ($permiso->tonelada_maniobra <= 8) { ?> table-active <?php } ?>">750 KG. A 8 TONELADAS</td>
                                            <td class="m-0 p-1 <?php if ($permiso->tonelada_maniobra <= 8) { ?> table-active <?php } ?>">06:00 A 22:00 HORAS</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td colspan="2">
                                <table class="mb-0 mt-3 texto">
                                    <tbody class="m-0 p-1">
                                        <tr class="m-0 p-1">
                                            <td class="m-0 p-1 text-center text-bold"><b>PESO</b></td>
                                            <td class="m-0 p-1 text-center text-bold"><b>HORARIO</b></td>
                                        </tr>
                                        <tr class="m-0 p-1">
                                            <td class="m-0 p-1 <?php if ($permiso->tonelada_maniobra > 8) { ?> table-active <?php } ?>">MAYOR A 8 TONELADAS</td>
                                            <td class="m-0 p-1 <?php if ($permiso->tonelada_maniobra > 8) { ?> table-active <?php } ?>">22:00 A 06:00 HORAS</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <p class="texto font-weight-bold mb-1"><u>QUEDA ESTRICTAMENTE PROHIBIDO ESTACIONARSE SOBRE LAS AVENIDAS:</u></p>
                <ol class="texto mt-0 mb-1 font-weight-bold">
                    <li><u>ÁLVARO OBREGÓN</u></li>
                    <li><u>HÉROES</u></li></u>
                </ol>

                <p class="texto text-justify">Así mismo se le exhorta para que cumpla con lo establecido en el reglamento de Tránsito del Estado de Quintana
                    Roo. Especialmente con lo dispuesto en los artículos 75, 90, 94, 222 y 228, siendo que de no cumplir con estas
                    disposiciones será acreedor a la sanción correspondiente y cancelación del permiso.</p>
                <p class="texto text-justify mt-0">Por lo anterior tendrá la obligación de utilizar las medidas de seguridad necesarias (conos) para brindar protección
                    a su personal y a los usuarios de la vía pública. </p>
                <p class="texto text-justify"><b>NOTA: </b>Este permiso no exime de responsabilidad al conductor, en caso de verse involucrado en un hecho de
                    tránsito. </p>

                <?php
                    Date::setLocale('ES');
                    $fechadia = strftime("%d",strtotime($permisos[0]->fecha_generacion_pdf));
                    $dia = Date::createFromFormat('d', $fechadia)->format('j');
                    $fechames = strftime("%B",strtotime($permisos[0]->fecha_generacion_pdf));
                    $mes = Date::createFromFormat('F', $fechames)->format('F');
                    $fechaanio = strftime("%Y",strtotime($permisos[0]->fecha_generacion_pdf));
                    $anio = Date::createFromFormat('Y', $fechaanio)->format('Y');
                ?>

                <p class="texto float-right mb-0 pb-0">Chetumal Q. Roo, a <b><?php echo $dia; ?></b> de <b class="text-uppercase"><?php echo $mes; ?></b> del <b><?php echo $anio; ?></b></p><br>
                <p class="texto text-center mt-0"><b>Atentamente</b></p>
                <div class="contenedor">
                    <img class="float-left ml-5" src="qrcodes/qrcode.svg" height="90">
                    <img class="center ml-5" src="images/firma_director_transito.jpg" height="75" width="90">
                    <img class="float-right mr-10 mt-0 pt-0" src="images/sello_direccion_transito.jpg" height="130" width="170">
                </div>
                <p class="texto text-center"><b>CMTE. JORGE CESAR SANTANA POOT</b></p>
                
            </div>
        </div>
    </div>

    <style>
       
        @page{
            margin: 0px 0px;
            
        }

        body{
            margin: 3cm 0.5cm 0.5cm;
            font-family: 'Open Sans', sans-serif;
        }

        .margen{
            margin-top: 0cm !important;
            padding-top: 0cm !important;
        }

        .tittle{
            text-align: center;
            font-size: 13px;
            margin-top: -2cm;
        }

        .texto{
            font-size: 11px;
        }

        .folio{
            float: right;
            text-align: center;
            width: 150px;
            margin: 0cm;
            padding: 3px 0px;
        }

        header{
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            margin-bottom: -1cm;
        }

        .contenedor{
	        text-align: center;
           
        }
    </style>

</body>
</html>