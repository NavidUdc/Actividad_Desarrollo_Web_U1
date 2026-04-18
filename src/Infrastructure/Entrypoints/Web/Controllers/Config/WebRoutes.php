<?php

declare(strict_types=1);

final class WebRoutes
{
    public static function routes(): array
    {
        return array(
            'home'              => array('method' => 'GET',  'action' => 'home'),
            'users.create'      => array('method' => 'GET',  'action' => 'create'),
            'users.store'       => array('method' => 'POST', 'action' => 'store'),
            'users.index'       => array('method' => 'GET',  'action' => 'index'),
            'users.show'        => array('method' => 'GET',  'action' => 'show'),
            'users.edit'        => array('method' => 'GET',  'action' => 'edit'),
            'users.update'      => array('method' => 'POST', 'action' => 'update'),
            //Auth
            'users.delete'      => array('method' => 'POST', 'action' => 'delete'),
            'auth.login'        => array('method' => 'GET',  'action' => 'login'),
            'auth.authenticate' => array('method' => 'POST', 'action' => 'authenticate'),
            'auth.logout'       => array('method' => 'GET',  'action' => 'logout'),
            'auth.forgot'       => array('method' => 'GET',  'action' => 'forgot'),
            'auth.forgot.send'  => array('method' => 'POST', 'action' => 'forgot.send'),

            //Reserva hOTEL

            // Reservas CRUDL
            'reservas.create' => ['method' => 'GET', 'action' => 'reserva_create'],
            'reservas.store' => ['method' => 'POST', 'action' => 'reserva_store'],
            'reservas.index' => ['method' => 'GET', 'action' => 'reserva_index'],
            'reservas.show' => ['method' => 'GET', 'action' => 'reserva_show'],
            'reservas.edit' => ['method' => 'GET', 'action' => 'reserva_edit'],
            'reservas.update' => ['method' => 'POST', 'action' => 'reserva_update'],
            'reservas.delete' => ['method' => 'POST', 'action' => 'reserva_delete'],
            'reservas.confirmar' => ['method' => 'POST', 'action' => 'reserva_confirmar'],
            'reservas.checkin' => ['method' => 'POST', 'action' => 'reserva_checkin'],
            'reservas.checkout' => ['method' => 'POST', 'action' => 'reserva_checkout'],
            'reservas.cancelar' => ['method' => 'POST', 'action' => 'reserva_cancelar'],
        );
    }
}
