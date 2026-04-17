<?php

declare(strict_types=1); ?>
<?php $authUser = $_SESSION['auth'] ?? null; ?>
<?php $currentRoute = $_GET['route'] ?? 'home'; ?>
<style>
    nav {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
        padding: 10px 0;
    }

    .nav-brand {
        font-weight: bold;
        font-size: 1.1rem;
        margin-right: 12px;
        color: #333;
        text-decoration: none;
    }

    .nav-group {
        display: flex;
        align-items: center;
        gap: 4px;
        background: #f0f0f0;
        border-radius: 6px;
        padding: 4px 8px;
    }

    .nav-group-label {
        font-size: 0.75rem;
        color: #888;
        margin-right: 4px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .nav-link {
        padding: 4px 10px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 0.9rem;
        color: #0066cc;
        transition: background 0.15s;
    }

    .nav-link:hover {
        background: #dce8f8;
    }

    .nav-link.active {
        background: #0066cc;
        color: #fff;
    }

    .nav-divider {
        width: 1px;
        height: 20px;
        background: #ccc;
        margin: 0 6px;
    }

    .nav-user {
        margin-left: auto;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        color: #444;
    }

    .nav-logout {
        padding: 4px 10px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 0.9rem;
        color: #cc2200;
    }

    .nav-logout:hover {
        background: #fdeaea;
    }
</style>
<nav>
    <a class="nav-brand" href="?route=home"> CRUDL</a>

    <?php if ($authUser): ?>
        <div class="nav-group">
            <span class="nav-group-label">Usuarios</span>
            <a class="nav-link <?= str_starts_with($currentRoute, 'users') ? 'active' : '' ?>"
                href="?route=users.index">Listar</a>
            <a class="nav-link <?= $currentRoute === 'users.create' ? 'active' : '' ?>"
                href="?route=users.create">Registrar</a>
        </div>

        <div class="nav-user">
            <span> <?= htmlspecialchars($authUser['name'], ENT_QUOTES, 'UTF-8') ?></span>
            <span style="color:#ccc">|</span>
            <a class="nav-logout" href="?route=auth.logout"> Salir</a>
        </div>
    <?php else: ?>
        <a class="nav-link" href="?route=auth.login">Iniciar sesion</a>
        <a class="nav-link" href="?route=auth.forgot">Recuperar contraseña</a>
    <?php endif; ?>
</nav>
<hr style="margin: 0 0 16px 0;">