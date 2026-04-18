<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

    <h1>Nueva Reserva de Hotel</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="alert-success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

    <form method="POST" action="?route=reservas.store">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
                <h3> Datos de la Reserva</h3>

                <div class="form-group">
                    <label for="fecha">Fecha de Reserva *</label>
                    <input type="date" id="fecha" name="fecha"
                           value="<?= htmlspecialchars($old['fecha'] ?? date('Y-m-d'), ENT_QUOTES, 'UTF-8') ?>" required>
                    <?php if (!empty($errors['fecha'])): ?>
                        <div class="field-error"><?= htmlspecialchars($errors['fecha'], ENT_QUOTES, 'UTF-8') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="hotel">Hotel *</label>
                    <input type="text" id="hotel" name="hotel"
                           value="<?= htmlspecialchars($old['hotel'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                    <?php if (!empty($errors['hotel'])): ?>
                        <div class="field-error"><?= htmlspecialchars($errors['hotel'], ENT_QUOTES, 'UTF-8') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="huesped">Huésped *</label>
                    <input type="text" id="huesped" name="huesped"
                           value="<?= htmlspecialchars($old['huesped'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                    <?php if (!empty($errors['huesped'])): ?>
                        <div class="field-error"><?= htmlspecialchars($errors['huesped'], ENT_QUOTES, 'UTF-8') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="fecha_inicio">Fecha Check-in *</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio"
                           value="<?= htmlspecialchars($old['fecha_inicio'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                    <?php if (!empty($errors['fecha_inicio'])): ?>
                        <div class="field-error"><?= htmlspecialchars($errors['fecha_inicio'], ENT_QUOTES, 'UTF-8') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="fecha_fin">Fecha Check-out *</label>
                    <input type="date" id="fecha_fin" name="fecha_fin"
                           value="<?= htmlspecialchars($old['fecha_fin'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                    <?php if (!empty($errors['fecha_fin'])): ?>
                        <div class="field-error"><?= htmlspecialchars($errors['fecha_fin'], ENT_QUOTES, 'UTF-8') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="valor">Valor ($) *</label>
                    <input type="number" step="0.01" min="0.01" id="valor" name="valor"
                           value="<?= htmlspecialchars($old['valor'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                    <?php if (!empty($errors['valor'])): ?>
                        <div class="field-error"><?= htmlspecialchars($errors['valor'], ENT_QUOTES, 'UTF-8') ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div>
                <h3> Detalles Adicionales</h3>

                <div class="form-group">
                    <label for="habitacion">N° Habitación</label>
                    <input type="text" id="habitacion" name="habitacion"
                           value="<?= htmlspecialchars($old['habitacion'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="form-group">
                    <label for="num_acompanantes">N° Acompañantes</label>
                    <input type="number" min="0" id="num_acompanantes" name="num_acompanantes"
                           value="<?= htmlspecialchars($old['num_acompanantes'] ?? '0', ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="form-group">
                    <label for="pais">País</label>
                    <input type="text" id="pais" name="pais"
                           value="<?= htmlspecialchars($old['pais'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="form-group">
                    <label for="departamento">Departamento/Estado</label>
                    <input type="text" id="departamento" name="departamento"
                           value="<?= htmlspecialchars($old['departamento'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="form-group">
                    <label for="ciudad">Ciudad</label>
                    <input type="text" id="ciudad" name="ciudad"
                           value="<?= htmlspecialchars($old['ciudad'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="form-group">
                    <label for="hora_checkin">Hora Check-in *</label>
                    <input type="time" id="hora_checkin" name="hora_checkin"
                           value="<?= htmlspecialchars($old['hora_checkin'] ?? '15:00', ENT_QUOTES, 'UTF-8') ?>" required>
                    <?php if (!empty($errors['hora_checkin'])): ?>
                        <div class="field-error"><?= htmlspecialchars($errors['hora_checkin'], ENT_QUOTES, 'UTF-8') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="hora_checkout">Hora Check-out *</label>
                    <input type="time" id="hora_checkout" name="hora_checkout"
                           value="<?= htmlspecialchars($old['hora_checkout'] ?? '12:00', ENT_QUOTES, 'UTF-8') ?>" required>
                    <?php if (!empty($errors['hora_checkout'])): ?>
                        <div class="field-error"><?= htmlspecialchars($errors['hora_checkout'], ENT_QUOTES, 'UTF-8') ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <h3> Empleados</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="empleado_atiende">Empleado que Atiende *</label>
                    <input type="text" id="empleado_atiende" name="empleado_atiende"
                           value="<?= htmlspecialchars($old['empleado_atiende'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                    <?php if (!empty($errors['empleado_atiende'])): ?>
                        <div class="field-error"><?= htmlspecialchars($errors['empleado_atiende'], ENT_QUOTES, 'UTF-8') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="empleado_despide">Empleado que Despide *</label>
                    <input type="text" id="empleado_despide" name="empleado_despide"
                           value="<?= htmlspecialchars($old['empleado_despide'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                    <?php if (!empty($errors['empleado_despide'])): ?>
                        <div class="field-error"><?= htmlspecialchars($errors['empleado_despide'], ENT_QUOTES, 'UTF-8') ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción / Observaciones</label>
            <textarea id="descripcion" name="descripcion" rows="3"><?= htmlspecialchars($old['descripcion'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary"> Crear Reserva</button>
        <a href="?route=reservas.index" class="btn"> Cancelar</a>
    </form>

<?php require __DIR__ . '/../layouts/footer.php'; ?>