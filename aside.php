<aside class="event-sidebar">
    <h2>Próximos eventos</h2>
    <div class="event-buttons">
        <?php
        if (session_status() === PHP_SESSION_NONE) session_start();

        include_once("modelo/AccesoDatos.php");

        $oAD = new AccesoDatos();
        if ($oAD->conectar()) {
            $sql = "SELECT idEvento, nombreEvento, fechaEvento 
                    FROM eventos 
                    WHERE fechaEvento >= CURDATE()
                    ORDER BY fechaEvento ASC 
                    LIMIT 5";

            $eventos = $oAD->ejecutarConsulta($sql);
            $oAD->desconectar();

            if ($eventos && count($eventos) > 0):
                foreach ($eventos as $e):
                    $idEvento = $e[0];
                    $nombre = htmlspecialchars($e[1]);
                    $fecha = date("j M", strtotime($e[2]));
        ?>
                    <div class="event-item">
                        <span class="event-icon">
                            <?php if (isset($_SESSION["usuario"])): ?>
                                <a href="verEvento.php?idEvento=<?php echo $idEvento; ?>">
                                    <img src="media/evento.png" alt="icono evento" />
                                </a>
                            <?php else: ?>
                                <img src="media/evento.png" alt="icono evento" style="opacity: 0.5; cursor: default;" />
                            <?php endif; ?>
                        </span>
                        <p><storng><?php echo $nombre . "</strong><br>" . $fecha; ?></p>
                    </div>
        <?php
                endforeach;
            else:
                echo "<p>No hay eventos próximos.</p>";
            endif;
        } else {
            echo "<p>Error al conectar con la base de datos.</p>";
        }
        ?>
    </div>
</aside>
</div>
