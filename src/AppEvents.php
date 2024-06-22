<?php

namespace App;

/**
 * Eventos del sistema
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
final class AppEvents
{    
    /**
     * Luego de solicitar recuperar contraseña
     * @author  Máximo Sojo <maxsojo13@gmail.com>
     */
    //Evento lanzado antes de persistir
    const APP_SECURITY_REGISTER_PRE_SUCCESS = 'app.security.register.pre_success';
    //Evento lanzado antes de persistir
    const APP_SECURITY_REGISTER_POST_SUCCESS = 'app.security.register.post_success';
    //Evento lanzado antes de persistir
    const APP_SECURITY_REGISTER_CONFIRM_PRE_SUCCESS = 'app.security.register_confirm.pre_success';
    //Evento lanzado antes de persistir
    const APP_SECURITY_REGISTER_CONFIRM_POST_SUCCESS = 'app.security.register_confirm.post_success';
    //Evento lanzado antes de persistir
    const APP_SECURITY_RESETTING_EMAIL_REQUEST_PRE_SUCCESS = 'app.security.resetting_email_request.pre_success';
    //Evento lanzado antes de persistir
    const APP_SECURITY_RESETTING_EMAIL_REQUEST_POST_SUCCESS = 'app.security.resetting_email_request.post_success';
    //Evento lanzado antes de persistir
    const APP_SECURITY_RESETTING_RESET_PRE_SUCCESS = 'app.security.resetting_reset.pre_success';
    //Evento lanzado antes de persistir
    const APP_SECURITY_RESETTING_RESET_POST_SUCCESS = 'app.security.resetting_reset.post_success';
    //Evento lanzado despues de persistir
    const APP_SECURITY_LOGIN_PRE_SUCCESS = 'app.security.login.pre_success';
    //Evento lanzado despues de persistir
    const APP_SECURITY_LOGIN_PRE_FAILED = 'app.security.login.pre_failed';
    
    /**
     * Dispara evento al registrar un usuario
     * @author  Máximo Sojo <maxsojo13@gmail.com>
     */
    //Evento lanzado antes de persistir
    const APP_USER_PROFILE_UPDATE_PRE_SUCCESS = "app.user.profile_update.pre_success";
    //Evento lanzado despues de persistir
    const APP_USER_PROFILE_UPDATE_POST_SUCCESS = "app.user.profile_update.post_success";
    //Evento lanzado antes de persistir
    const APP_USER_ADDRESS_UPDATE_PRE_SUCCESS = "app.user.address_update.pre_success";
    //Evento lanzado despues de persistir
    const APP_USER_ADDRESS_UPDATE_POST_SUCCESS = "app.user.address_update.post_success";
    //Evento lanzado antes de persistir
    const APP_USER_EMAIL_UPDATE_PRE_SUCCESS = "app.user.email_update.pre_success";
    //Evento lanzado despues de persistir
    const APP_USER_EMAIL_UPDATE_POST_SUCCESS = "app.user.email_update.post_success";
    //Evento lanzado antes de persistir
    const APP_USER_PHONE_UPDATE_PRE_SUCCESS = "app.user.phone_update.pre_success";
    //Evento lanzado despues de persistir
    const APP_USER_PHONE_UPDATE_POST_SUCCESS = "app.user.phone_update.post_success";
    //Evento lanzado antes de persistir
    const APP_USER_PASSWORD_UPDATE_PRE_SUCCESS = "app.user.password_update.pre_success";
    //Evento lanzado despues de persistir
    const APP_USER_PASSWORD_UPDATE_POST_SUCCESS = "app.user.password_update.post_success";
}
