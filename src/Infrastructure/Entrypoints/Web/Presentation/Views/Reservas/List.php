<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

    <h1>Lista de Reservas</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="alert-success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

    <p>
        <a href="?route=reservas.create" class="btn btn-success"> Nueva Reserva</a>
    </p>

<?php if (empty($reservas)): ?>
    <p>No hay reservas registradas todavía.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Hotel</th>
            <th>Huésped</th>
            <th>Check-in</th>
            <th>Check-out</th>
            <th>Valor</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($reservas as $reserva): ?>
            <tr>
                <td><?= htmlspecialchars(substr($reserva->getId(), 0, 8) . '...', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($reserva->getFecha(), ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($reserva->getHotel(), ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($reserva->getHuesped(), ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($reserva->getFechaInicio(), ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($reserva->getFechaFin(), ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($reserva->getValorFormateado(), ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                        <span class="badge <?= $reserva->getEstadoBadgeClass() ?>">
                            <?= htmlspecialchars($reserva->getEstado(), ENT_QUOTES, 'UTF-8') ?>
                        </span>
                </td>
                <td class="action-buttons">
                    <a href="?route=reservas.show&id=<?= urlencode($reserva->getId()) ?>" class="btn">Ver</a>
                    <a href="?route=reservas.edit&id=<?= urlencode($reserva->getId()) ?>" class="btn btn-warning"> Editar</a>

                    <?php if ($reserva->getEstado() === 'PENDIENTE'): ?>
                        <form method="POST" action="?route=reservas.confirmar" style="display: inline;">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($reserva->getId(), ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" class="btn btn-success">Confirmar</button>
                        </form>
                    <?php endif; ?>

                    <?php if ($reserva->getEstado() === 'CONFIRMADA'): ?>
                        <form method="POST" action="?route=reservas.checkin" style="display: inline;">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($reserva->getId(), ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" class="btn btn-primary"> Check-in</button>
                        </form>
                    <?php endif; ?>

                    <?php if ($reserva->getEstado() === 'CHECKIN'): ?>
                        <form method="POST" action="?route=reservas.checkout" style="display: inline;">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($reserva->getId(), ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" class="btn btn-info"> Check-out</button>
                        </form>
                    <?php endif; ?>

                    <?php if (!in_array($reserva->getEstado(), ['CHECKOUT', 'CANCELADA'])): ?>
                        <form method="POST" action="?route=reservas.cancelar" style="display: inline;" onsubmit="return confirm('¿Cancelar esta reserva?');">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($reserva->getId(), ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" class="btn btn-danger">Cancelar</button>
                        </form>
                    <?php endif; ?>

                    <form method="POST" action="?route=reservas.delete" style="display: inline;" onsubmit="return confirm('¿Eliminar permanentemente esta reserva?');">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($reserva->getId(), ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>