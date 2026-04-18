<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

    <h1>Editar Reserva</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

    <form method="POST" action="?route=reservas.update">
        <input type="hidden" name="id" value="<?= htmlspecialchars($old['id'] ?? $reserva->getId(), ENT_QUOTES, 'UTF-8') ?>">

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
                <h3> Datos de la Reserva</h3>

                <div class="form-group">
                    <label for="fecha">Fecha de Reserva *</label>
                    <input type="date" id="fecha" name="fecha"
                           value="<?= htmlspecialchars($old['fecha'] ?? $reserva->getFecha(), ENT_QUOTES, 'UTF-8') ?>" required>
                </div>

                <div class="form-group">
                    <label for="hotel">Hotel *</label>
                    <input type="text" id="hotel" name="hotel"
                           value="<?= htmlspecialchars($old['hotel'] ?? $reserva->getHotel(), ENT_QUOTES, 'UTF-8') ?>" required>
                </div>

                <div class="form-group">
                    <label for="huesped">Huésped *</label>
                    <input type="text" id="huesped" name="huesped"
                           value="<?= htmlspecialchars($old['huesped'] ?? $reserva->getHuesped(), ENT_QUOTES, 'UTF-8') ?>" required>
                </div>

                <div class="form-group">
                    <label for="fecha_inicio">Fecha Check-in *</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio"
                           value="<?= htmlspecialchars($old['fecha_inicio'] ?? $reserva->getFechaInicio(), ENT_QUOTES, 'UTF-8') ?>" required>
                </div>

                <div class="form-group">
                    <label for="fecha_fin">Fecha Check-out *</label>
                    <input type="date" id="fecha_fin" name="fecha_fin"
                           value="<?= htmlspecialchars($old['fecha_fin'] ?? $reserva->getFechaFin(), ENT_QUOTES, 'UTF-8') ?>" required>
                </div>

                <div class="form-group">
                    <label for="valor">Valor ($) *</label>
                    <input type="number" step="0.01" min="0.01" id="valor" name="valor"
                           value="<?= htmlspecialchars($old['valor'] ?? $reserva->getValor(), ENT_QUOTES, 'UTF-8') ?>" required>
                </div>

                <div class="form-group">
                    <label for="estado">Estado *</label>
                    <select id="estado" name="estado" required>
                        <?php foreach ($estadoOptions as $opt): ?>
                            <option value="<?= htmlspecialchars($opt, ENT_QUOTES, 'UTF-8') ?>"
                                <?= (($old['estado'] ?? $reserva->getEstado()) === $opt) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($opt, ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div>
                <h3> Detalles Adicionales</h3>

                <div class="form-group">
                    <label for="habitacion">N° Habitación</label>
                    <input type="text" id="habitacion" name="habitacion"
                           value="<?= htmlspecialchars($old['habitacion'] ?? $reserva->getHabitacion(), ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="form-group">
                    <label for="num_acompanantes">N° Acompañantes</label>
                    <input type="number" min="0" id="num_acompanantes" name="num_acompanantes"
                           value="<?= htmlspecialchars($old['num_acompanantes'] ?? $reserva->getNumAcompanantes(), ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="form-group">
                    <label for="pais">País</label>
                    <input type="text" id="pais" name="pais"
                           value="<?= htmlspecialchars($old['pais'] ?? $reserva->getPais(), ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="form-group">
                    <label for="departamento">Departamento/Estado</label>
                    <input type="text" id="departamento" name="departamento"
                           value="<?= htmlspecialchars($old['departamento'] ?? $reserva->getDepartamento(), ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="form-group">
                    <label for="ciudad">Ciudad</label>
                    <input type="text" id="ciudad" name="ciudad"
                           value="<?= htmlspecialchars($old['ciudad'] ?? $reserva->getCiudad(), ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="form-group">
                    <label for="hora_checkin">Hora Check-in *</label>
                    <input type="time" id="hora_checkin" name="hora_checkin"
                           value="<?= htmlspecialchars($old['hora_checkin'] ?? $reserva->getHoraCheckin(), ENT_QUOTES, 'UTF-8') ?>" required>
                </div>

                <div class="form-group">
                    <label for="hora_checkout">Hora Check-out *</label>
                    <input type="time" id="hora_checkout" name="hora_checkout"
                           value="<?= htmlspecialchars($old['hora_checkout'] ?? $reserva->getHoraCheckout(), ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <h3> Empleados</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="empleado_atiende">Empleado que Atiende *</label>
                    <input type="text" id="empleado_atiende" name="empleado_atiende"
                           value="<?= htmlspecialchars($old['empleado_atiende'] ?? $reserva->getEmpleadoAtiende(), ENT_QUOTES, 'UTF-8') ?>" required>
                </div>

                <div class="form-group">
                    <label for="empleado_despide">Empleado que Despide *</label>
                    <input type="text" id="empleado_despide" name="empleado_despide"
                           value="<?= htmlspecialchars($old['empleado_despide'] ?? $reserva->getEmpleadoDespide(), ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción / Observaciones</label>
            <textarea id="descripcion" name="descripcion" rows="3"><?= htmlspecialchars($old['descripcion'] ?? $reserva->getDescripcion() ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="?route=reservas.index" class="btn">Cancelar</a>
    </form>

<?php require __DIR__ . '/../layouts/footer.php'; ?>