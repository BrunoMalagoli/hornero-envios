<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONSULTA HISTORICO</title>
    <link rel="stylesheet" href="../css/consulta-historico.css">
    <link rel="stylesheet" href="../css/global.css">
</head>

<body>
    <div class="header">
        <div class="logo-space"></div>
            <nav class="navbar">
                <ul class="nav-links">
                    <li><a href="admision-envios.php">Admision</a></li>
                    <li><a href="Captura.php">Captura</a></li>
                    <li><a href="consulta-historico.php">Historico</a></li>
                    <li><a href="entrega.php">Entrega</a></li>
                    <li><a href="inicio-u-suc.php">Inicio</a></li>
                </ul>
                <div class="burger">
                    <div class="line1"></div>
                    <div class="line2"></div>
                    <div class="line3"></div>
                    <div class="line4"></div>
                    <div class="line5"></div>
                </div>
            </nav>
        <button class="btn btn-primary">DESCONECTAR</button>
    </div>
    <div class="nav-space"></div>
    <div class="container">
        <h1>HISTÓRICO DE MOVIMIENTOS</h1>
        <div class="search-section">
            <div class="guia-container">
                <label for="codigo">CODIGO DE SEGUIMIENTO:</label>
                <input type="text" id="codigo" name="guia">
            </div>
            <div class="button-group">
                <button class="btn btn-primary">BUSCAR</button>
                <button class="btn btn-secondary">LIMPIAR</button>
            </div>
        </div>
    </div>
</body>
</html>