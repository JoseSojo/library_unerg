Feature: Recuperación de contraseña
  In order to test ResettingController

    Background:
        Given a global client with "test@example.com" and "abc.12345"

    Scenario: Prueba registro de usuarios
        # Consulta el formulario
        When I request "GET /api/resetting.json"
        Then the response status code is 200
        And the response has a "1.widget" property
        And the response has a "1.data.properties.username" property
        # Campos requeridos
        And I add the request data:
            """
            {
                "form_security_resetting": {
                }
            }   
            """
        When I request "POST /api/resetting.json"
        Then the response status code is 400
        And the response has a errors in property "username" and contains 'validators.user.email.not_blank::{}'
        # Prueba de exitosa con correo erroneo
        And I add the request data:
            """
            {
                "form_security_resetting": {
                    "username": "te@example.com"
                }
            }   
            """
        When I request "POST /api/resetting.json"
        Then the response status code is 200
        # Prueba de exitosa con correo valido
        And I add the request data:
            """
            {
                "form_security_resetting": {
                    "username": "test@example.com"
                }
            }   
            """
        When I request "POST /api/resetting.json"
        Then the response status code is 200
        # Prueba de error por solicitud procesada
        And I add the request data:
            """
            {
                "form_security_resetting": {
                    "username": "test@example.com"
                }
            }   
            """
        When I request "POST /api/resetting.json"
        Then the response status code is 400
        And the response has a errors property and contains 'validators.user.resetting.initialize.error'
        