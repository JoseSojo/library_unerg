Feature: Registro de usuario
  In order to test RegistrationController

    Background:
        Given a clear entity "App\Entity\M\User" table

    Scenario: Prueba registro de usuarios
        # Campos requeridos
        And I add the request data:
            """
            {
                "form_security_registration": {
                }
            }   
            """
        When I request "POST /api/register.json"
        Then the response status code is 400
        And the response has a errors in property "firstname" and contains 'validators.firstname.not_blank::{}'
        And the response has a errors in property "lastname" and contains 'validators.lastname.not_blank::{}'
        And the response has a errors in property "email" and contains 'validators.email.not_blank::{}'
        And the response has a errors in property "plainPassword" and contains 'validators.password.not_blank::{}'
        And the response has a errors in property "country" and contains 'validators.country.not_blank::{}'
        And the response has a errors in property "phone" and contains 'validators.phone.not_blank::{}'
        # Prueba de email mal formado (Corto)
        And I add the request data:
            """
            {
                "form_security_registration": {
                    "firstname": "Usuario",
                    "lastname": "Apellido",
                    "email":"te",
                    "phone":"4243376377",
                    "plainPassword": "abc.12345",
                    "country": "%countryId%"
                }
            }   
            """
        When I request "POST /api/register.json"
        Then the response status code is 400
        And the response has a errors in property "email" and contains 'fos_user.email.short::{}'
        # Prueba de email mal formado (Sin dominio)
        And I add the request data:
            """
            {
                "form_security_registration": {
                    "firstname": "Usuario",
                    "lastname": "Apellido",
                    "email":"test@com",
                    "phone":"4243376377",
                    "plainPassword": "abc.12345",
                    "country": "%countryId%"
                }
            }   
            """
        When I request "POST /api/register.json"
        Then the response status code is 400
        And the response has a errors in property "email" and contains 'fos_user.email.invalid::{}'
        # Prueba contraseña con formato invalido (Corta)
        And I add the request data:
            """
            {
                "form_security_registration": {
                    "firstname": "Usuario",
                    "lastname": "Apellido",
                    "email":"test@example.com",
                    "phone":"4243376377",
                    "plainPassword": "abc.",
                    "country": "%countryId%"
                }
            }   
            """
        When I request "POST /api/register.json"
        Then the response status code is 400
        And the response has a errors in property "plainPassword" and contains 'validators.password.too_short_message::{}'
        # Prueba contraseña con formato invalido (Requiere letras)
        And I add the request data:
            """
            {
                "form_security_registration": {
                    "firstname": "Usuario",
                    "lastname": "Apellido",
                    "email":"test@example.com",
                    "phone":"4243376377",
                    "plainPassword": "21312345",
                    "country": "%countryId%"
                }
            }   
            """
        When I request "POST /api/register.json"
        Then the response status code is 400
        And the response has a errors in property "plainPassword" and contains 'validators.password.missing_letters_message::{}'
        # Prueba contraseña con formato invalido (Requiere numeros)
        And I add the request data:
            """
            {
                "form_security_registration": {
                    "firstname": "Usuario",
                    "lastname": "Apellido",
                    "email":"test@example.com",
                    "phone":"4243376377",
                    "plainPassword": "abcsfsdfsd",
                    "country": "%countryId%"
                }
            }   
            """
        When I request "POST /api/register.json"
        Then the response status code is 400
        And the response has a errors in property "plainPassword" and contains 'validators.password.missing_numbers_message::{}'
        # Prueba contraseña con formato invalido (Requiere caracteres)
        And I add the request data:
            """
            {
                "form_security_registration": {
                    "firstname": "Usuario",
                    "lastname": "Apellido",
                    "email":"test@example.com",
                    "phone":"4243376377",
                    "plainPassword": "abc212345",
                    "country": "%countryId%"
                }
            }   
            """
        When I request "POST /api/register.json"
        Then the response status code is 400
        And the response has a errors in property "plainPassword" and contains 'validators.password.strength::{}'
        # Registro de usuario exitoso
        And I add the request data:
            """
            {
                "form_security_registration": {
                    "firstname": "Usuario",
                    "lastname": "Apellido",
                    "email":"demo1@example.com",
                    "phone":"4243376377",
                    "plainPassword": "abc.12345",
                    "country": "%countryId%"
                }
            }   
            """
        When I request "POST /api/register.json"
        Then the response status code is 200