<html>
<head>
    <title>Permiso PDF</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
    <header>
    </header>
    {{--<img src="/public/assets/img/encabezado.jpg" alt="">--}}
    <div class="container">
        <p class="tittle">PERMISO PARA REALIZAR MANIOBRAS DE CARGA Y DESCARGA</p>
        <div class="container">
            @foreach ($permisos as $permiso)
            <div class="folio texto border border-3 border-dark"><b>Permiso:</b> {{ $permiso->no_solicitud_api }}</div>
            @endforeach
            <div class="container">
                <p class="texto">A QUIEN CORRESPONDA:</p>
                <p class="texto">Por medio de la precente la Dirección de Tráncito, concede permiso al vehículo de las siguientes características:</p>
                
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
                            <td><b>Resibo de pago estatal:</b> <br></td>
                            <td><b>Toneladas:</b> <br> {{ $permiso->tonelada_maniobra }}</td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Nombre del Chofer:</b> <br> {{ $permiso->nombre_chofer }}</td>
                            <td><b>Numero de licencia:</b> <br> {{ $permiso->licencia }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"><b>Persona física o razón social:</b> <br> {{ $permiso->persona_razon_social }}</td>
                        </tr>
                    </tbody>
                </table>

                <p class="texto">Para que pueda realizar manobras de carga y descarga en el primer cuadro de la ciudad.</p>

                <table class="table texto table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="3"><b>Comercio denominado:</b> <br> {{ $permiso->comercio_denominado }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"><b>Ubicado en:</b> <br> {{ $permiso->direccion }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"><b>Con horario según su peso bruto:</b> <br> de {{ $permiso->horarios }}</td>
                        </tr>
                    </tbody>
                </table>

                <p class="texto font-weight-bold"><u>QUEDA ESTRICTAMENTE PROHIBIDO ESTACIONARSE SOBRE LAS AVENIDAS:</u></p>
                <ol class="texto mt-0 font-weight-bold">
                    <li><u>ÁLVARO OBREGÓN</u></li>
                    <li><u>HÉROES</u></li></u>
                </ol>

                <p class="texto text-justify">Así mismo se le exhorta para que cumpla con lo establecido en el reglamento de Tránsito del Estado de Quintana
                    Roo. Especialmente con lo dispuesto en los artículos 75, 90, 94, 222 y 228, siendo que de no cumplir con estas
                    disposiciones será acreedor a la sanción correspondiente y cancelación del permiso.</p>
                <p class="texto text-justify">Por lo anterior tendrá la obligación de utilizar las medidas de seguridad necesarias (conos) para brindar protección
                    a su personal y a los usuarios de la vía pública. </p>
                <p class="texto text-justify"><b>NOTA: </b>Este permiso no exime de responsabilidad al conductor, en caso de verse involucrado en un hecho de
                    tránsito. </p>
            </div>
        </div>
    </div>
    <footer>
        <p>Logos pie de pagina</p>
    </footer>

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
            font-size: 14px;
        }

        .texto{
            font-size: 13px;
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
            height: 2.5cm;
            background-color: lightblue;
            color: white;
            text-align: center;
            line-height: 30px;
        }

        footer{
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: lightblue;
            color: white;
            text-align: center;
            line-height: 35px;
        }
    </style>

</body>
</html>