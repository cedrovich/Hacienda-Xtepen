<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="PaginaPrincipal/stylereservas.css">
    <title>Reservas</title>
</head>
<body>
    <?php include "menu_principal.php"; ?>
    <hr>
    <div class="contenedor">
        <div class="contenedor_frm">
            <h2>Reservar Evento</h2>
            <br>
            <form action="agregar_reserva_evento.php?token=123456" method="post">
                <input type="hidden" name="auth_code" value="codigo_secreto">
                <div>
                    <input type="text" name="nombre" id="nombre" placeholder="Ingresa tu nombre completo" required>
                    <input type="email" name="email" id="email" placeholder="Ingresa tu correo electronico" required>
                </div>

                <div>
                    <input type="tel" name="telefono" id="telefono" placeholder="Ingresa un número celular" maxlength="10" required pattern="[0-9]{10}" inputmode="numeric" title="Ingresa un número de 10 dígitos">
                    <select id="evento" name="evento" required>
                        <option value="" disabled selected>Selecciona un tipo de evento</option>
                        <option value="boda">Boda</option>
                        <option value="quinceanera">Quinceañera</option>
                        <option value="corporativo">Evento Corporativo</option>
                        <option value="comunion">Primera Comunión o Bautizo</option>
                        <option value="cumpleanos">Cumpleaños</option>
                        <option value="pedida">Pedida de Mano</option>
                    </select>
                </div>

                <div>
                    <span>Seleccione fecha de reserva: </span><input class="dte" type="date" name="fecha" id="fecha" required>
                    <input class="inv" type="number" name="invitados" id="invitados" required min="1" max="9999" maxlength="4" placeholder="Cantidad de invitados">
                </div>

                <!-- Select con los menús de banquete -->
                <div>
                    <select name="menu_banquete" id="menu_banquete" required>
                        <option value="" disabled selected>Seleccione su Menú</option>
                        <?php
                        // Conexión a la base de datos
                        $conexion = new mysqli("localhost", "root", "", "haciendaxtepen");

                        // Verificar si hubo error en la conexión
                        if ($conexion->connect_error) {
                            die("Error de conexión: " . $conexion->connect_error);
                        }

                        // Consulta para obtener los menús de banquete
                        $consulta = "SELECT id, nombre_menu FROM banquete_menu";
                        $resultado = $conexion->query($consulta);

                        // Agregar cada menú de banquete como opción en el select
                        if ($resultado->num_rows > 0) {
                            while ($fila = $resultado->fetch_assoc()) {
                                echo '<option value="'.$fila['id'].'">'.$fila['nombre_menu'].'</option>';
                            }
                        } else {
                            echo '<option value="" disabled>No hay menús disponibles</option>';
                        }

                        // Cerrar la conexión
                        $conexion->close();
                        ?>
                    </select>
                    <a class="vm" href="reserva_ver_menu.php" onclick="window.open('reserva_ver_menu.php', 'newwindow', 'width=800,height=600'); return false;">Ver Menús</a>

                </div>

                <div>
                    <textarea class="inputext" id="mensaje" name="mensaje" rows="4" cols="50" placeholder="Describe los detalles adicionales del evento" required></textarea>
                </div>

                <input type="submit" value="Reservar">
            </form>
        </div>
    </div>

    <script>
        const fechaEventoInput = document.getElementById('fecha');

        function obtenerFechaActual() {
            const hoy = new Date();
            const dia = ('0' + hoy.getDate()).slice(-2);
            const mes = ('0' + (hoy.getMonth() + 1)).slice(-2);
            const anio = hoy.getFullYear();
            return `${anio}-${mes}-${dia}`;
        }

        const fechaActual = obtenerFechaActual();
        fechaEventoInput.min = fechaActual;
    </script>

    <?php include "pie_pagina.php"; ?>
</body>
</html>
