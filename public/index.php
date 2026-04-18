<?php

declare(strict_types=1);

// ── Guardia de seguridad ──────────────────────────────────────────────────────
(function (): void {
    $requestPath = rtrim(
        (string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH),
        '/'
    );
    $publicBase = rtrim(dirname((string) ($_SERVER['SCRIPT_NAME'] ?? '/index.php')), '/');
    if ($requestPath !== $publicBase && !str_starts_with($requestPath, $publicBase . '/')) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $dest = isset($_SESSION['auth']['id']) ? 'home' : 'auth.login';
        header('Location: ' . $publicBase . '/index.php?route=' . $dest);
        exit;
    }
})();

// ── Bootstrap ─────────────────────────────────────────────────────────────────
require_once __DIR__ . '/../Common/ClassLoader.php';
require_once __DIR__ . '/../Common/DependencyInjection.php';
require_once __DIR__ . '/../src/Infrastructure/Entrypoints/Web/Presentation/View.php';
require_once __DIR__ . '/../src/Infrastructure/Entrypoints/Web/Presentation/Flash.php';

DependencyInjection::boot();
Flash::start();

// ── Auth helpers ──────────────────────────────────────────────────────────────
function isLoggedIn(): bool
{
    return isset($_SESSION['auth']['id']);
}

function requireAuth(): void
{
    if (!isLoggedIn()) {
        Flash::setMessage('Debes iniciar sesion para acceder a esta seccion.');
        View::redirect('auth.login');
    }
}

function getLoggedUser(): array
{
    return is_array($_SESSION['auth'] ?? null) ? $_SESSION['auth'] : array();
}

// ── Routing ───────────────────────────────────────────────────────────────────

// ==================== FUNCIONES HELPER PARA RESERVAS ====================

/**
 * @return array<string, string>
 */
function getCreateReservaFormData(): array
{
    return [
        'fecha' => isset($_POST['fecha']) ? trim((string) $_POST['fecha']) : date('Y-m-d'),
        'hotel' => isset($_POST['hotel']) ? trim((string) $_POST['hotel']) : '',
        'huesped' => isset($_POST['huesped']) ? trim((string) $_POST['huesped']) : '',
        'fecha_inicio' => isset($_POST['fecha_inicio']) ? trim((string) $_POST['fecha_inicio']) : '',
        'fecha_fin' => isset($_POST['fecha_fin']) ? trim((string) $_POST['fecha_fin']) : '',
        'valor' => isset($_POST['valor']) ? trim((string) $_POST['valor']) : '',
        'habitacion' => isset($_POST['habitacion']) ? trim((string) $_POST['habitacion']) : '',
        'num_acompanantes' => isset($_POST['num_acompanantes']) ? trim((string) $_POST['num_acompanantes']) : '0',
        'pais' => isset($_POST['pais']) ? trim((string) $_POST['pais']) : '',
        'departamento' => isset($_POST['departamento']) ? trim((string) $_POST['departamento']) : '',
        'ciudad' => isset($_POST['ciudad']) ? trim((string) $_POST['ciudad']) : '',
        'hora_checkin' => isset($_POST['hora_checkin']) ? trim((string) $_POST['hora_checkin']) : '15:00',
        'hora_checkout' => isset($_POST['hora_checkout']) ? trim((string) $_POST['hora_checkout']) : '12:00',
        'empleado_atiende' => isset($_POST['empleado_atiende']) ? trim((string) $_POST['empleado_atiende']) : '',
        'empleado_despide' => isset($_POST['empleado_despide']) ? trim((string) $_POST['empleado_despide']) : '',
        'descripcion' => isset($_POST['descripcion']) ? trim((string) $_POST['descripcion']) : '',
    ];
}

/**
 * @return array<string, string>
 */
function getUpdateReservaFormData(): array
{
    return [
        'id' => isset($_POST['id']) ? trim((string) $_POST['id']) : '',
        'fecha' => isset($_POST['fecha']) ? trim((string) $_POST['fecha']) : '',
        'hotel' => isset($_POST['hotel']) ? trim((string) $_POST['hotel']) : '',
        'huesped' => isset($_POST['huesped']) ? trim((string) $_POST['huesped']) : '',
        'fecha_inicio' => isset($_POST['fecha_inicio']) ? trim((string) $_POST['fecha_inicio']) : '',
        'fecha_fin' => isset($_POST['fecha_fin']) ? trim((string) $_POST['fecha_fin']) : '',
        'valor' => isset($_POST['valor']) ? trim((string) $_POST['valor']) : '',
        'habitacion' => isset($_POST['habitacion']) ? trim((string) $_POST['habitacion']) : '',
        'num_acompanantes' => isset($_POST['num_acompanantes']) ? trim((string) $_POST['num_acompanantes']) : '0',
        'pais' => isset($_POST['pais']) ? trim((string) $_POST['pais']) : '',
        'departamento' => isset($_POST['departamento']) ? trim((string) $_POST['departamento']) : '',
        'ciudad' => isset($_POST['ciudad']) ? trim((string) $_POST['ciudad']) : '',
        'hora_checkin' => isset($_POST['hora_checkin']) ? trim((string) $_POST['hora_checkin']) : '',
        'hora_checkout' => isset($_POST['hora_checkout']) ? trim((string) $_POST['hora_checkout']) : '',
        'empleado_atiende' => isset($_POST['empleado_atiende']) ? trim((string) $_POST['empleado_atiende']) : '',
        'empleado_despide' => isset($_POST['empleado_despide']) ? trim((string) $_POST['empleado_despide']) : '',
        'descripcion' => isset($_POST['descripcion']) ? trim((string) $_POST['descripcion']) : '',
        'estado' => isset($_POST['estado']) ? trim((string) $_POST['estado']) : '',
    ];
}

/**
 * @param array<string, string> $form
 * @return array<string, string>
 */
function validateCreateReservaForm(array $form): array
{
    $errors = [];

    if ($form['fecha'] === '') {
        $errors['fecha'] = 'La fecha de reserva es obligatoria.';
    }
    if ($form['hotel'] === '') {
        $errors['hotel'] = 'El nombre del hotel es obligatorio.';
    } elseif (strlen($form['hotel']) < 3) {
        $errors['hotel'] = 'El nombre del hotel debe tener al menos 3 caracteres.';
    }
    if ($form['huesped'] === '') {
        $errors['huesped'] = 'El nombre del huésped es obligatorio.';
    }
    if ($form['fecha_inicio'] === '') {
        $errors['fecha_inicio'] = 'La fecha de check-in es obligatoria.';
    }
    if ($form['fecha_fin'] === '') {
        $errors['fecha_fin'] = 'La fecha de check-out es obligatoria.';
    }
    if ($form['fecha_inicio'] !== '' && $form['fecha_fin'] !== '') {
        if ($form['fecha_inicio'] > $form['fecha_fin']) {
            $errors['fecha_fin'] = 'La fecha de check-out debe ser posterior al check-in.';
        }
    }
    if ($form['valor'] === '') {
        $errors['valor'] = 'El valor de la reserva es obligatorio.';
    } elseif (!is_numeric($form['valor']) || (float) $form['valor'] <= 0) {
        $errors['valor'] = 'El valor debe ser un número mayor a 0.';
    }
    if ($form['hora_checkin'] === '') {
        $errors['hora_checkin'] = 'La hora de check-in es obligatoria.';
    }
    if ($form['hora_checkout'] === '') {
        $errors['hora_checkout'] = 'La hora de check-out es obligatoria.';
    }
    if ($form['empleado_atiende'] === '') {
        $errors['empleado_atiende'] = 'El empleado que atiende es obligatorio.';
    }
    if ($form['empleado_despide'] === '') {
        $errors['empleado_despide'] = 'El empleado que despide es obligatorio.';
    }
    if ($form['num_acompanantes'] !== '' && (!is_numeric($form['num_acompanantes']) || (int) $form['num_acompanantes'] < 0)) {
        $errors['num_acompanantes'] = 'El número de acompañantes debe ser 0 o mayor.';
    }

    return $errors;
}

/**
 * @param array<string, string> $form
 * @return array<string, string>
 */
function validateUpdateReservaForm(array $form): array
{
    $errors = [];

    if ($form['fecha'] === '') {
        $errors['fecha'] = 'La fecha de reserva es obligatoria.';
    }
    if ($form['hotel'] === '') {
        $errors['hotel'] = 'El nombre del hotel es obligatorio.';
    }
    if ($form['huesped'] === '') {
        $errors['huesped'] = 'El nombre del huésped es obligatorio.';
    }
    if ($form['fecha_inicio'] === '') {
        $errors['fecha_inicio'] = 'La fecha de check-in es obligatoria.';
    }
    if ($form['fecha_fin'] === '') {
        $errors['fecha_fin'] = 'La fecha de check-out es obligatoria.';
    }
    if ($form['fecha_inicio'] !== '' && $form['fecha_fin'] !== '') {
        if ($form['fecha_inicio'] > $form['fecha_fin']) {
            $errors['fecha_fin'] = 'La fecha de check-out debe ser posterior al check-in.';
        }
    }
    if ($form['valor'] === '') {
        $errors['valor'] = 'El valor de la reserva es obligatorio.';
    } elseif (!is_numeric($form['valor']) || (float) $form['valor'] <= 0) {
        $errors['valor'] = 'El valor debe ser un número mayor a 0.';
    }
    if ($form['hora_checkin'] === '') {
        $errors['hora_checkin'] = 'La hora de check-in es obligatoria.';
    }
    if ($form['hora_checkout'] === '') {
        $errors['hora_checkout'] = 'La hora de check-out es obligatoria.';
    }
    if ($form['empleado_atiende'] === '') {
        $errors['empleado_atiende'] = 'El empleado que atiende es obligatorio.';
    }
    if ($form['empleado_despide'] === '') {
        $errors['empleado_despide'] = 'El empleado que despide es obligatorio.';
    }
    if ($form['estado'] === '') {
        $errors['estado'] = 'El estado es obligatorio.';
    }

    return $errors;
}

/**
 * @return array<string, mixed>
 */
function buildCreateReservaViewData(): array
{
    return [
        'pageTitle' => 'Nueva Reserva',
        'message' => Flash::message(),
        'success' => Flash::success(),
        'errors' => Flash::errors(),
        'old' => Flash::old(),
    ];
}

/**
 * @param ReservaResponse $reserva
 * @return array<string, mixed>
 */
function buildEditReservaViewData(ReservaResponse $reserva): array
{
    return [
        'pageTitle' => 'Editar Reserva',
        'reserva' => $reserva,
        'estadoOptions' => EstadoReservaEnum::values(),
        'message' => Flash::message(),
        'errors' => Flash::errors(),
        'old' => Flash::old(),
    ];
}

/**
 * @param ReservaResponse[] $reservas
 * @return array<string, mixed>
 */
function buildListReservasViewData(array $reservas): array
{
    return [
        'pageTitle' => 'Lista de Reservas',
        'reservas' => $reservas,
        'message' => Flash::message(),
        'success' => Flash::success(),
    ];
}

/**
 * @param ReservaResponse $reserva
 * @return array<string, mixed>
 */
function buildShowReservaViewData(ReservaResponse $reserva): array
{
    return [
        'pageTitle' => 'Detalle de Reserva',
        'reserva' => $reserva,
        'message' => Flash::message(),
    ];
}
$route  = isset($_GET['route']) ? trim((string) $_GET['route']) : 'home';
$routes = WebRoutes::routes();

if (!isset($routes[$route])) {
    http_response_code(404);
    View::render('home', buildHomeViewData('Ruta no encontrada.'));
    exit;
}

$definition = $routes[$route];
$httpMethod = strtoupper((string) $_SERVER['REQUEST_METHOD']);

if ($httpMethod !== $definition['method']) {
    http_response_code(405);
    View::render('home', buildHomeViewData('Metodo HTTP no permitido.'));
    exit;
}

$publicActions = array('home', 'login', 'authenticate', 'logout', 'forgot', 'forgot.send', 'create', 'store');
if (!in_array($definition['action'], $publicActions, true) && !isLoggedIn()) {
    Flash::setMessage('Debes iniciar sesion para acceder a esta seccion.');
    View::redirect('auth.login');
}

// ── Dispatch ──────────────────────────────────────────────────────────────────
try {
    switch ($definition['action']) {

        case 'home':
            View::render('home', buildHomeViewData());
            break;

        case 'create':
            View::render('users/create', buildCreateUserViewData());
            break;

        case 'store':
            $controller = DependencyInjection::getUserController();
            $form       = getCreateUserFormData();
            $form['id'] = generateUuid4();
            $errors     = validateCreateUserForm($form);
            if (!empty($errors)) {
                Flash::setOld($form);
                Flash::setErrors($errors);
                Flash::setMessage('Corrige los errores del formulario.');
                View::redirect('users.create');
            }
            $request = new CreateUserWebRequest(
                $form['id'],
                $form['name'],
                $form['email'],
                $form['password'],
                $form['role']
            );
            $controller->store($request);
            Flash::setSuccess('Usuario registrado correctamente.');
            View::redirect('users.index');
            break;

        case 'index':
            $controller = DependencyInjection::getUserController();
            $users      = $controller->index();
            View::render('users/list', buildListUsersViewData($users));
            break;

        case 'show':
            $controller = DependencyInjection::getUserController();
            $id         = isset($_GET['id']) ? trim((string) $_GET['id']) : '';
            $user       = $controller->show($id);
            View::render('users/show', array(
                'pageTitle' => 'Detalle de usuario',
                'user'      => $user,
                'message'   => Flash::message(),
            ));
            break;

        case 'edit':
            $controller = DependencyInjection::getUserController();
            $id         = isset($_GET['id']) ? trim((string) $_GET['id']) : '';
            $user       = $controller->show($id);
            View::render('users/edit', buildEditUserViewData($user));
            break;

        case 'update':
            $controller = DependencyInjection::getUserController();
            $form       = getUpdateUserFormData();
            $errors     = validateUpdateUserForm($form);
            if (!empty($errors)) {
                Flash::setOld($form);
                Flash::setErrors($errors);
                Flash::setMessage('Corrige los errores del formulario.');
                header('Location: ?route=users.edit&id=' . urlencode($form['id']));
                exit;
            }
            $request = new UpdateUserWebRequest(
                $form['id'],
                $form['name'],
                $form['email'],
                $form['password'],
                $form['role'],
                $form['status']
            );
            $controller->update($request);
            Flash::setSuccess('Usuario actualizado correctamente.');
            View::redirect('users.index');
            break;

        case 'delete':
            $controller = DependencyInjection::getUserController();
            $id         = isset($_POST['id']) ? trim((string) $_POST['id']) : '';
            $controller->delete($id);
            Flash::setSuccess('Usuario eliminado correctamente.');
            View::redirect('users.index');
            break;

        case 'login':
            if (isLoggedIn()) {
                View::redirect('home');
            }
            View::render('auth/login', array(
                'pageTitle' => 'Iniciar sesion',
                'message'   => Flash::message(),
                'errors'    => Flash::errors(),
                'old'       => Flash::old(),
            ));
            break;

        case 'authenticate':
            $email    = trim(strtolower((string) ($_POST['email']    ?? '')));
            $password = (string) ($_POST['password'] ?? '');
            $authErrors = array();
            if ($email === '') {
                $authErrors['email']    = 'El correo es obligatorio.';
            }
            if ($password === '') {
                $authErrors['password'] = 'La contraseña es obligatoria.';
            }
            if (!empty($authErrors)) {
                Flash::setErrors($authErrors);
                Flash::setOld(array('email' => $email));
                View::redirect('auth.login');
            }
            $loginUseCase = DependencyInjection::getLoginUseCase();
            $command      = new LoginCommand($email, $password);
            $user         = $loginUseCase->execute($command);
            $_SESSION['auth'] = array(
                'id'    => $user->id()->value(),
                'name'  => $user->name()->value(),
                'email' => $user->email()->value(),
                'role'  => $user->role(),
            );
            Flash::setSuccess('Bienvenido/a, ' . $user->name()->value() . '.');
            View::redirect('home');
            break;

        case 'logout':
            session_destroy();
            header('Location: ?route=auth.login');
            exit;

        case 'forgot':
            View::render('auth/forgot-password', array(
                'pageTitle' => 'Recuperar contraseña',
                'message'   => Flash::message(),
                'success'   => Flash::success(),
                'errors'    => Flash::errors(),
                'old'       => Flash::old(),
            ));
            break;

        case 'forgot.send':
            $forgotEmail = trim(strtolower((string) ($_POST['email'] ?? '')));
            if ($forgotEmail === '' || !filter_var($forgotEmail, FILTER_VALIDATE_EMAIL)) {
                Flash::setErrors(array('email' => 'Introduce un correo electronico valido.'));
                Flash::setOld(array('email' => $forgotEmail));
                View::redirect('auth.forgot');
            }
            $repository = DependencyInjection::getUserRepository();
            $foundUser  = $repository->getByEmail(new UserEmail($forgotEmail));
            if ($foundUser !== null && $foundUser->status() === UserStatusEnum::ACTIVE) {
                $tempPassword = bin2hex(random_bytes(5));
                $newPassword  = UserPassword::fromPlainText($tempPassword);
                $updatedUser  = $foundUser->changePassword($newPassword);
                $repository->update($updatedUser);
                sendPasswordRecoveryEmail(
                    $foundUser->email()->value(),
                    $foundUser->name()->value(),
                    $tempPassword
                );
            }
            Flash::setSuccess(
                'Si el correo esta registrado y la cuenta esta activa, ' .
                    'recibiras un mensaje con tu contraseña temporal.'
            );
            View::redirect('auth.forgot');
            break;

        // ==================== RESERVAS CRUDL ====================

// ---------- RESERVAS: CREATE (FORM) ----------
        case 'reserva_create':
            View::render('reservas/create', buildCreateReservaViewData());
            break;

// ---------- RESERVAS: STORE ----------
        case 'reserva_store':
            $controller = DependencyInjection::getReservaController();
            $form = getCreateReservaFormData();
            $form['id'] = generateUuid4();
            $errors = validateCreateReservaForm($form);

            if (!empty($errors)) {
                Flash::setOld($form);
                Flash::setErrors($errors);
                Flash::setMessage('Corrige los errores del formulario.');
                View::redirect('reservas.create');
            }

            $request = new CreateReservaWebRequest(
                $form['id'],
                $form['fecha'],
                $form['hotel'],
                $form['huesped'],
                $form['fecha_inicio'],
                $form['fecha_fin'],
                $form['valor'],
                $form['habitacion'],
                $form['num_acompanantes'],
                $form['pais'],
                $form['departamento'],
                $form['ciudad'],
                $form['hora_checkin'],
                $form['hora_checkout'],
                $form['empleado_atiende'],
                $form['empleado_despide'],
                $form['descripcion'] !== '' ? $form['descripcion'] : null
            );

            $controller->store($request);
            Flash::setSuccess('Reserva creada correctamente.');
            View::redirect('reservas.index');
            break;

// ---------- RESERVAS: INDEX ----------
        case 'reserva_index':
            $controller = DependencyInjection::getReservaController();
            $reservas = $controller->index();
            View::render('reservas/list', buildListReservasViewData($reservas));
            break;

// ---------- RESERVAS: SHOW ----------
        case 'reserva_show':
            $controller = DependencyInjection::getReservaController();
            $id = isset($_GET['id']) ? trim((string) $_GET['id']) : '';

            if ($id === '') {
                Flash::setMessage('ID de reserva no proporcionado.');
                View::redirect('reservas.index');
            }

            $reserva = $controller->show($id);
            View::render('reservas/show', buildShowReservaViewData($reserva));
            break;

// ---------- RESERVAS: EDIT ----------
        case 'reserva_edit':
            $controller = DependencyInjection::getReservaController();
            $id = isset($_GET['id']) ? trim((string) $_GET['id']) : '';

            if ($id === '') {
                Flash::setMessage('ID de reserva no proporcionado.');
                View::redirect('reservas.index');
            }

            $reserva = $controller->show($id);
            View::render('reservas/edit', buildEditReservaViewData($reserva));
            break;

// ---------- RESERVAS: UPDATE ----------
        case 'reserva_update':
            $controller = DependencyInjection::getReservaController();
            $form = getUpdateReservaFormData();
            $errors = validateUpdateReservaForm($form);

            if (!empty($errors)) {
                Flash::setOld($form);
                Flash::setErrors($errors);
                Flash::setMessage('Corrige los errores del formulario.');
                header('Location: ?route=reservas.edit&id=' . urlencode($form['id']));
                exit;
            }

            $request = new UpdateReservaWebRequest(
                $form['id'],
                $form['fecha'],
                $form['hotel'],
                $form['huesped'],
                $form['fecha_inicio'],
                $form['fecha_fin'],
                $form['valor'],
                $form['habitacion'],
                $form['num_acompanantes'],
                $form['pais'],
                $form['departamento'],
                $form['ciudad'],
                $form['hora_checkin'],
                $form['hora_checkout'],
                $form['empleado_atiende'],
                $form['empleado_despide'],
                $form['descripcion'] !== '' ? $form['descripcion'] : null,
                $form['estado']
            );

            $controller->update($request);
            Flash::setSuccess('Reserva actualizada correctamente.');
            View::redirect('reservas.index');
            break;

// ---------- RESERVAS: DELETE ----------
        case 'reserva_delete':
            $controller = DependencyInjection::getReservaController();
            $id = isset($_POST['id']) ? trim((string) $_POST['id']) : '';

            if ($id === '') {
                Flash::setMessage('ID de reserva no proporcionado.');
            } else {
                $controller->delete($id);
                Flash::setSuccess('Reserva eliminada correctamente.');
            }

            View::redirect('reservas.index');
            break;

// ---------- RESERVAS: CONFIRMAR ----------
        case 'reserva_confirmar':
            $controller = DependencyInjection::getReservaController();
            $id = isset($_POST['id']) ? trim((string) $_POST['id']) : '';

            if ($id === '') {
                Flash::setMessage('ID de reserva no proporcionado.');
            } else {
                $controller->changeEstado($id, 'CONFIRMADA');
                Flash::setSuccess('Reserva confirmada correctamente.');
            }

            View::redirect('reservas.index');
            break;

// ---------- RESERVAS: CHECKIN ----------
        case 'reserva_checkin':
            $controller = DependencyInjection::getReservaController();
            $id = isset($_POST['id']) ? trim((string) $_POST['id']) : '';

            if ($id === '') {
                Flash::setMessage('ID de reserva no proporcionado.');
            } else {
                $controller->changeEstado($id, 'CHECKIN');
                Flash::setSuccess('Check-in realizado correctamente.');
            }

            View::redirect('reservas.index');
            break;

// ---------- RESERVAS: CHECKOUT ----------
        case 'reserva_checkout':
            $controller = DependencyInjection::getReservaController();
            $id = isset($_POST['id']) ? trim((string) $_POST['id']) : '';

            if ($id === '') {
                Flash::setMessage('ID de reserva no proporcionado.');
            } else {
                $controller->changeEstado($id, 'CHECKOUT');
                Flash::setSuccess('Check-out realizado correctamente.');
            }

            View::redirect('reservas.index');
            break;

// ---------- RESERVAS: CANCELAR ----------
        case 'reserva_cancelar':
            $controller = DependencyInjection::getReservaController();
            $id = isset($_POST['id']) ? trim((string) $_POST['id']) : '';

            if ($id === '') {
                Flash::setMessage('ID de reserva no proporcionado.');
            } else {
                $controller->changeEstado($id, 'CANCELADA');
                Flash::setSuccess('Reserva cancelada correctamente.');
            }

            View::redirect('reservas.index');
            break;
        default:
            throw new \RuntimeException('Accion no soportada.');
    }
} catch (\Throwable $exception) {
    $msg = $exception->getMessage();
    Flash::setMessage($msg);
    switch ($route) {
        case 'users.store':
            Flash::setOld(getCreateUserFormData());
            View::redirect('users.create');
            break;
        case 'users.update':
            $updateId = trim((string) ($_POST['id'] ?? ''));
            Flash::setOld(getUpdateUserFormData());
            header('Location: ?route=users.edit&id=' . urlencode($updateId));
            exit;
        case 'auth.authenticate':
            Flash::setOld(array('email' => trim(strtolower((string) ($_POST['email'] ?? '')))));
            View::redirect('auth.login');
            break;
        case 'auth.forgot.send':
            Flash::setOld(array('email' => trim((string) ($_POST['email'] ?? ''))));
            View::redirect('auth.forgot');
            break;
        case 'users.show':
        case 'users.edit':
            View::redirect('users.index');
            break;
        case 'users.delete':
            View::redirect('users.index');
            break;

        case 'reservas.store':
            Flash::setOld(getCreateReservaFormData());
            View::redirect('reservas.create');
            break;

        case 'reservas.update':
            $updateId = trim((string) ($_POST['id'] ?? ''));
            Flash::setOld(getUpdateReservaFormData());
            header('Location: ?route=reservas.edit&id=' . urlencode($updateId));
            exit;

        case 'reservas.confirmar':
        case 'reservas.checkin':
        case 'reservas.checkout':
        case 'reservas.cancelar':
            Flash::setMessage($msg);
            View::redirect('reservas.index');
            break;

        case 'reservas.show':
        case 'reservas.edit':
            View::redirect('reservas.index');
            break;
        default:
            View::render('home', buildHomeViewData($msg));
            break;
    }
}

// ── Email helper ──────────────────────────────────────────────────────────────
function sendPasswordRecoveryEmail(string $email, string $name, string $tempPassword): void
{
    $templateFile = __DIR__ . '/../src/Infrastructure/Entrypoints/Web/Presentation/Views/emails/forgot-password.php';
    ob_start();
    extract(array('email' => $email, 'name' => $name, 'tempPassword' => $tempPassword), EXTR_SKIP);
    require $templateFile;
    $htmlBody = (string) ob_get_clean();
    $subject  = '=?UTF-8?B?' . base64_encode('Recuperacion de contraseña') . '?=';
    $headers  = implode("\r\n", array(
        'MIME-Version: 1.0',
        'Content-Type: text/html; charset=UTF-8',
        'From: CRUD Usuarios <no-reply@crud-usuarios.local>',
        'X-Mailer: PHP/' . PHP_VERSION,
    ));
    mail($email, $subject, $htmlBody, $headers);
}

// ── View-data builders ────────────────────────────────────────────────────────
function buildListUsersViewData(array $users): array
{
    return array(
        'pageTitle' => 'Lista de usuarios',
        'users'     => $users,
        'message'   => Flash::message(),
        'success'   => Flash::success(),
    );
}

function buildHomeViewData(string $message = ''): array
{
    return array(
        'pageTitle' => 'Menu principal',
        'message'   => $message,
        'success'   => Flash::success(),
    );
}

function buildCreateUserViewData(): array
{
    return array(
        'pageTitle'   => 'Registrar usuario',
        'roleOptions' => UserRoleEnum::values(),
        'message'     => Flash::message(),
        'success'     => Flash::success(),
        'errors'      => Flash::errors(),
        'old'         => Flash::old(),
    );
}

function buildEditUserViewData(UserResponse $user): array
{
    return array(
        'pageTitle'     => 'Editar usuario',
        'user'          => $user,
        'roleOptions'   => UserRoleEnum::values(),
        'statusOptions' => UserStatusEnum::values(),
        'message'       => Flash::message(),
        'errors'        => Flash::errors(),
        'old'           => Flash::old(),
    );
}

function generateUuid4(): string
{
    $data    = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function getCreateUserFormData(): array
{
    return array(
        'name'     => isset($_POST['name'])     ? trim((string) $_POST['name'])     : '',
        'email'    => isset($_POST['email'])    ? trim((string) $_POST['email'])    : '',
        'password' => isset($_POST['password']) ? trim((string) $_POST['password']) : '',
        'role'     => isset($_POST['role'])     ? trim((string) $_POST['role'])     : '',
    );
}

function getUpdateUserFormData(): array
{
    return array(
        'id'       => isset($_POST['id'])       ? trim((string) $_POST['id'])       : '',
        'name'     => isset($_POST['name'])     ? trim((string) $_POST['name'])     : '',
        'email'    => isset($_POST['email'])    ? trim((string) $_POST['email'])    : '',
        'password' => isset($_POST['password']) ? (string) $_POST['password']       : '',
        'role'     => isset($_POST['role'])     ? trim((string) $_POST['role'])     : '',
        'status'   => isset($_POST['status'])   ? trim((string) $_POST['status'])   : '',
    );
}

function validateCreateUserForm(array $form): array
{
    $errors = array();
    if ($form['name'] === '') {
        $errors['name'] = 'El nombre es obligatorio.';
    }
    if ($form['email'] === '') {
        $errors['email'] = 'El correo es obligatorio.';
    } elseif (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'El correo no tiene un formato valido.';
    }
    if ($form['password'] === '') {
        $errors['password'] = 'La contraseña es obligatoria.';
    } elseif (strlen($form['password']) < 8) {
        $errors['password'] = 'La contraseña debe tener al menos 8 caracteres.';
    }
    if ($form['role'] === '') {
        $errors['role'] = 'El rol es obligatorio.';
    }
    return $errors;
}

function validateUpdateUserForm(array $form): array
{
    $errors = array();
    if ($form['name'] === '') {
        $errors['name'] = 'El nombre es obligatorio.';
    }
    if ($form['email'] === '') {
        $errors['email'] = 'El correo es obligatorio.';
    } elseif (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'El correo no tiene un formato valido.';
    }
    if ($form['password'] !== '' && strlen($form['password']) < 8) {
        $errors['password'] = 'La contraseña debe tener al menos 8 caracteres si deseas cambiarla.';
    }
    if ($form['role'] === '') {
        $errors['role'] = 'El rol es obligatorio.';
    }
    if ($form['status'] === '') {
        $errors['status'] = 'El estado es obligatorio.';
    }
    return $errors;
}