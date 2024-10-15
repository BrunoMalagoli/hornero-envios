<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Sucursales</title>
    <link rel="stylesheet" href="../css/gestion-sucursales.css">
    <link rel="stylesheet" href="../css/global.css">
</head>
<body>
    <div class="container">
        <div class="form">
            <h2>REGISTRAR SUCURSAL</h2>
            <label for="localidad">LOCALIDAD</label>
            <input type="text" id="localidad" name="localidad">
            <label for="calle">CALLE</label>
            <input type="text" id="calle" name="calle">
            <label for="nombre">NOMBRE</label>
            <input type="text" id="nombre" name="nombre">
            <div class="row">
                <div>
                    <label for="codigo-postal">CÓDIGO POSTAL</label>
                    <input type="text" id="codigo-postal" name="codigo-postal">
                </div>
                <div>
                    <label for="telefono">TELÉFONO</label>
                    <input type="text" id="telefono" name="telefono">
                </div>
            </div>
            <label>
                <input type="checkbox" id="centro-distribucion" name="centro-distribucion">
                CENTRO DE DISTRIBUCIÓN
            </label>
            <button>ACEPTAR</button>
        </div>
        <div class="form">
            <h2>ELIMINAR SUCURSAL</h2>
            <div class="radio-group">
                <label>
                    <input type="radio" name="tipo" value="sucursal" checked> SUCURSAL
                </label>
                <label>
                    <input type="radio" name="tipo" value="centro-distribucion"> CENTRO DE DISTRIBUCIÓN
                </label>
            </div>
            <label for="buscador">BUSCADOR</label>
            <input type="text" id="buscador" name="buscador">
            <div class="result-area" aria-live="polite"></div>
            <button>ACEPTAR</button>
        </div>
    </div>
</body>
</html>