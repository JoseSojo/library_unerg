Feature: Perfil de usuario
  In order to test ProfileController

    Background:
        Given a global client with "test@example.com"
        Given I am logged in api as oauth2 "test@example.com"
        Given a mobile device default

    Scenario: Prueba perfil de usuario
        # Consulta el index
        When I request "GET /api/user/profile/.json"
        Then the response status code is 200
        And the response has a "2.widget" property
        And the response has a "2.title" property
        And the response has a "2.sub_title" property
        And the response has a "2.uri_action" property
        And the response has a "2.uri_icon" property
        # Consulta el formulario
        When I request "GET /api/user/profile/update.json"
        Then the response status code is 200
        And the response has a "2.widget" property
        And the response has a "2.data.properties.firstname" property
        And the response has a "2.data.properties.lastname" property
        # And the response has a "2.data.properties.birthday" property
        # Prueba de exitosa
        And I add the request data:
            """
            {
                "form_user_profile": {
                    "firstname": "Usuario",
                    "lastname": "Apellido"
                }
            }   
            """
        When I request "POST /api/user/profile/update.json"
        Then the response status code is 200