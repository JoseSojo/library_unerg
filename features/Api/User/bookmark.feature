Feature: Marcadores
  In order to test BookmarkController

    Background:
        Given a global client with "test@example.com"
        Given I am logged in api as oauth2 "test@example.com"

    Scenario: Prueba de metodos
        # Prueba de regsistro exitosa
        And I add the request data:
            """
            {
                "form_user_bookmark": {
                    "business": "%lastBusinessId%"
                }
            }   
            """
        When I request "POST /api/user/bookmark/create.json"
        Then the response status code is 200
        # Prueba de remover exitosa
        When I request to path 'app_route_api_user_bookmark_delete' with parameters '{"id":"%lastBookmarkId%"}'
        Then the response status code is 200