<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admisión de Envíos</title>
    <link rel="stylesheet" href="../css/admision.css">
    <link rel="stylesheet" href="../css/global.css">
</head>
<body>
    <div class="top-bar">

    </div>
    <div class="main-container">
        <h1>ADMISIÓN DE ENVÍOS</h1>
        <form>
            <div class="form-row">
                <div class="form-group">
                    <label>Pago</label>
                    <div class="radio-group">
                        <input type="radio" id="origen" name="pago">
                        <label for="origen">Origen</label>
                        <input type="radio" id="destino" name="pago" checked>
                        <label for="destino">Destino</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Entrega</label>
                    <div class="radio-group">
                        <input type="radio" id="agencia" name="entrega" checked>
                        <label for="agencia">Agencia</label>
                        <input type="radio" id="domicilio" name="entrega">
                        <label for="domicilio">Domicilio</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Fecha Envío</label>
                    <div class="date-input">
                        <input type="text" value="05/09/2024">
                        <span class="icon"></span>
                    </div>
                </div>
                <div class="form-group">
                    <span class="icon" style="float: right;"></span>
                </div>
            </div>
            <div class="bordered-section">
                <div class="form-row">
                    <div class="form-group">
                        <label>Origen</label>
                        <select>
                            <option>1722 MERLO ARGENTINA-054 PNG</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Destino</label>
                        <select>
                            <option>ARGENTINA-054</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>C.P./Pob</label>
                        <input type="text" value="7600 MAR DEL PLATA">
                    </div>
                    <div class="form-group">
                        <label>Descuento</label>
                        <input type="text">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Piezas</label>
                        <input type="number" value="1">
                    </div>
                    <div class="form-group">
                        <label>Peso (Kg)</label>
                        <input type="number" value="2,00">
                    </div>
                    <div class="form-group">
                        <label>Largo (cm)</label>
                        <input type="number" value="2">
                    </div>
                    <div class="form-group">
                        <label>Ancho (cm)</label>
                        <input type="number" value="2">
                    </div>
                    <div class="form-group">
                        <label>Alto (cm)</label>
                        <input type="number" value="2">
                    </div>
                    <div class="form-group">
                        <label>Volumen (m3)</label>
                        <input type="number" value="0,00">
                    </div>
                    <div class="form-group">
                        <label>Valor Mercancía</label>
                        <input type="number" value="40000">
                    </div>
                </div>
            </div>
            <div class="bottom-section">
                <div class="bottom-fields">
                    <div class="form-group">
                        <label>Descripción General</label>
                        <input type="text">
                    </div>
                    <div class="form-group">
                        <label>Referencia</label>
                        <input type="text">
                    </div>
                    <div class="form-group">
                        <label>Observaciones</label>
                        <input type="text">
                    </div>
                </div>
                <div class="view-price-btn">
                    <button type="button" class="btn btn-save">VER PRECIO</button>
                </div>
            </div>
            <div class="price-box">
                VÍA CARGO ESTÁNDAR<br>
                08/09/2024 09:00<br>
                11.650,00
            </div>
            <div class="sender-receiver-section">
                <div class="rol-form-section">
                    <!-- REMITENTE -->
                     <h2>REMITENTE</h2>
                    
                        <div class="form-group">
                            <label>Remitente</label>
                            <input type="text">
                        </div>
                    
                    
                        <div class="form-group">
                            <label>DNI</label>
                            <input type="text">
                        </div>
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text">
                        </div>
                    
                    
                        <div class="form-group">
                            <label>Dirección</label>
                            <input type="text">
                        </div>
                   
                    
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text">
                        </div>
                    
                </div>
                <div class="rol-form-section">
                    <!-- DESTINATARIO -->
                        <h2>DESTINATARIO</h2>
                        <div class="form-group">
                            <label>Destinatario</label>
                            <input type="text">
                        </div>
                    
                    
                        <div class="form-group">
                            <label>DNI</label>
                            <input type="text">
                        </div>
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text">
                        </div>
                    
                    
                        <div class="form-group">
                            <label>Dirección</label>
                            <input type="text">
                        </div>
                  
                    
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text">
                        </div>
                </div>
                
                
            </div>
            <div class="buttons">
                <button type="button" class="btn btn-cancel">CANCELAR</button>
                <button type="submit" class="btn btn-save">GUARDAR</button>
            </div>
        </form>
    </div>
</body>
</html>