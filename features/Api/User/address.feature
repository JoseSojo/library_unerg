Feature: Dirección de usuario
  In order to test ProfileController

    Background:
        Given a global client with "test@example.com"
        Given I am logged in api as oauth2 "test@example.com"

    Scenario: Prueba dirección de usuario
        # Consulta el formulario
        When I request "GET /api/user/address/update.json"
        Then the response status code is 200
        And the response has a "2.widget" property
        And the response has a "2.data.properties.country" property
        And the response has a "2.data.properties.city" property
        And the response has a "2.data.properties.postalCode" property
        And the response has a "2.data.properties.address" property
        # Prueba de exitosa
        And I add the request data:
            """
            {
                "form_user_address": {
                    "country": "%countryId%",
                    "city": "El mundo",
                    "postalCode": "2005",
                    "address": "Calle codigo"
                }
            }   
            """
        When I request "POST /api/user/address/update.json"
        Then the response status code is 200