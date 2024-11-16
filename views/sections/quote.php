<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizaciones - LU Decoraciones</title>
    <link rel="icon" href="/assets/images/logo.png" type="image/png">
    <link rel="stylesheet" href="../../assets/css/styles.css"> 
</head>
<script>
function abrirW() {
    const telefono = '9932901320';
    
    // Obtener los valores de los campos del formulario
    const nombre = document.getElementById('nombre').value;
    const direccion = document.getElementById('direccion').value;
    const fechaHora = document.getElementById('fecha_hora').value;
    const tipoEvento = document.getElementById('tipo_evento').value;
    const detalles = document.getElementById('detalles').value || "No especificado";

    // Construir el mensaje
    const mensaje = `Hola, me gustaría solicitar una cotización. Aquí están los detalles:
    \nNombre: ${nombre}
    \nDirección del evento: ${direccion}
    \nDía y hora del evento: ${fechaHora}
    \nTipo de evento: ${tipoEvento}
    \nDetalles de la decoración: ${detalles}`;

    // Crear la URL de WhatsApp
    const url = `https://api.whatsapp.com/send?phone=${telefono}&text=${encodeURIComponent(mensaje)}`;

    // Abrir WhatsApp en una nueva pestaña
    window.open(url, "_blank");
}
</script>
<body>

    <?php include($_SERVER['DOCUMENT_ROOT'] . '/views/header.php'); ?>

    <div class="header-container">
    <h1 class="title">Cotizar</h1>
    </div>

    <div class="form-section">
        <form onsubmit="abrirW(); return false;">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="direccion">Dirección del evento:</label>
            <input type="text" id="direccion" name="direccion" required>

            <label for="fecha_hora">Día y hora del evento:</label>
            <input type="datetime-local" id="fecha_hora" name="fecha_hora" required>

            <label for="tipo_evento">Tipo de evento:</label>
                <select id="tipo_evento" name="tipo_evento" required>
                    <option value="Cumpleaños">Cumpleaños</option>
                    <option value="Boda">Boda</option>
                    <option value="Fiesta Infantil">Fiesta Infantil</option>
                    <option value="Quinceañera">Quinceañera</option>
                    <option value="Evento Corporativo">Evento Corporativo</option>
                    <option value="Otro">Otro</option>
                </select>

            <label for="detalles">Detalles de la decoración que deseas (opcional):</label>
            <textarea id="detalles" name="detalles" rows="3"></textarea>

            <input type="submit" value="Enviar por WhatsApp" class="cta-button">
        </form>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . '/views/footer.php'); ?>
</body>
</html>
