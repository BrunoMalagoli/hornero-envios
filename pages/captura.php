<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAPTURA</title>
    <link rel="stylesheet" href="../css/captura.css">
    <link rel="stylesheet" href="../css/global.css">
</head>
<body class="main-content">
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="logo.png" alt="Logo de la empresa">
            </div>
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
    </header>
    <div class="window">
        <div class="top-bar">
            <h1>CAPTURA</h1>
            <div class="top-bar-right">
                
            </div>
        </div>
        <div class="content">
            <div class="section-header">
                <h2>Captura de lecturas</h2>
            </div>
            <form>
                <div class="form-group">
                    <label for="tipo-lectura">Tipo de lectura:</label>
                    <select id="tipo-lectura" name="tipo-lectura">
                        <option>RECEPCIÓN EN PUNTO DE VENTA</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="codigo-barras">Código de envio:</label>
                    <input type="text" id="codigo-envio" name="codigo-barras">
                </div>
            </form>
            <div class="ultima-lectura">
                <h3>Última lectura</h3>
                <div class="lectura-content">
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>