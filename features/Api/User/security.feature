Feature: Seguridad de usuario
  In order to test SecurityController

    Background:
        Given a global client with "test@example.com"
        Given I am logged in api as oauth2 "test@example.com"

    Scenario: Prueba de seguridad de usuario
        # Consulta el index
        When I request "GET /api/user/security/.json"
        Then the response status code is 200
        And the response has a "1.widget" property
        And the response has a "1.title" property
        And the response has a "1.sub_title" property
        And the response has a "1.uri_action" property
        And the response has a "1.uri_icon" property
        # Consulta formulario de contraseña
        When I request "GET /api/user/security/password/update.json"
        Then the response status code is 200
        And the response has a "1.widget" property
        And the response has a "1.data.properties.currentPassword" property
        And the response has a "1.data.properties.plainPasswordFirst" property
        And the response has a "1.data.properties.plainPasswordSecond" property
        # Procesa formulario de contraseña
        And I add the request data:
            """
            {
                "form_user_password_update": {
                    "currentPassword": "%password%",
                    "plainPasswordFirst": "%password%",
                    "plainPasswordSecond": "%password%"
                }
            }   
            """
        When I request "POST /api/user/security/password/update.json"
        Then the response status code is 200
        # Consulta formulario de telefono
        When I request "GET /api/user/security/phone/update.json"
        Then the response status code is 200
        And the response has a "2.widget" property
        And the response has a "2.data.properties.phone" property
        # Procesa formulario de telefono
        And I add the request data:
            """
            {
                "form_user_phone_update": {
                    "phone": "%phone%"
                }
            }   
            """
        When I request "POST /api/user/security/phone/update.json"
        Then the response status code is 200
        # Consulta formulario de correo electronico
        When I request "GET /api/user/security/email/update.json"
        Then the response status code is 200
        And the response has a "2.widget" property
        And the response has a "2.data.properties.email" property
        # Procesa formulario de correo electronico
        And I add the request data:
            """
            {
                "form_user_email_update": {
                    "email": "%email%"
                }
            }   
            """
        When I request "POST /api/user/security/email/update.json"
        Then the response status code is 200