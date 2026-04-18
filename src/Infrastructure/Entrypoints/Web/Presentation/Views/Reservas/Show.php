<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

    <h1> Detalle de Reserva</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div>
            <h3>Datos de la Reserva</h3>
            <table class="detail-table">
                <tr><th>ID</th><td><?= htmlspecialchars($reserva->getId(), ENT_QUOTES, 'UTF-8') ?></td></tr>
                <tr><th>Fecha de Reserva</th><td><?= htmlspecialchars($reserva->getFecha(), ENT_QUOTES, 'UTF-8') ?></td></tr>
                <tr><th>Hotel</th><td><?= htmlspecialchars($reserva->getHotel(), ENT_QUOTES, 'UTF-8') ?></td></tr>
                <tr><th>Huésped</th><td><?= htmlspecialchars($reserva->getHuesped(), ENT_QUOTES, 'UTF-8') ?></td></tr>
                <tr><th>Check-in</th><td><?= htmlspecialchars($reserva->getFechaInicio(), ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars($reserva->getHoraCheckin(), ENT_QUOTES, 'UTF-8') ?></td></tr>
                <tr><th>Check-out</th><td><?= htmlspecialchars($reserva->getFechaFin(), ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars($reserva->getHoraCheckout(), ENT_QUOTES, 'UTF-8') ?></td></tr>
                <tr><th>Valor</th><td><?= htmlspecialchars($reserva->getValorFormateado(), ENT_QUOTES, 'UTF-8') ?></td></tr>
                <tr><th>Estado</th><td><span class="badge <?= $reserva->getEstadoBadgeClass() ?>"><?= htmlspecialchars($reserva->getEstado(), ENT_QUOTES, 'UTF-8') ?></span></td></tr>
            </table>
        </div>

        <div>
            <h3> Detalles Adicionales</h3>
            <table class="detail-table">
                <tr><th>Habitación</th><td><?= htmlspecialchars($reserva->getHabitacion(), ENT_QUOTES, 'UTF-8') ?></td></tr>
                <tr><th>Acompañantes</th><td><?= $reserva->getNumAcompanantes() ?></td></tr>
                <tr><th>País</th><td><?= htmlspecialchars($reserva->getPais(), ENT_QUOTES, 'UTF-8') ?></td></tr>
                <tr><th>Departamento</th><td><?= htmlspecialchars($reserva->getDepartamento(), ENT_QUOTES, 'UTF-8') ?></td></tr>
                <tr><th>Ciudad</th><td><?= htmlspecialchars($reserva->getCiudad(), ENT_QUOTES, 'UTF-8') ?></td></tr>
                <tr><th>Empleado Atiende</th><td><?= htmlspecialchars($reserva->getEmpleadoAtiende(), ENT_QUOTES, 'UTF-8') ?></td></tr>
                <tr><th>Empleado Despide</th><td><?= htmlspecialchars($reserva->getEmpleadoDespide(), ENT_QUOTES, 'UTF-8') ?></td></tr>
            </table>
        </div>
    </div>

<?php if ($reserva->getDescripcion()): ?>
    <h3>Descripción</h3>
    <p><?= nl2br(htmlspecialchars($reserva->getDescripcion(), ENT_QUOTES, 'UTF-8')) ?></p>
<?php endif; ?>

    <p style="margin-top: 20px;">
        <a href="?route=reservas.edit&id=<?= urlencode($reserva->getId()) ?>" class="btn btn-warning">Editar</a>
        <a href="?route=reservas.index" class="btn">Volver al listado</a>
    </p>

<?php require __DIR__ . '/../layouts/footer.php'; ?>