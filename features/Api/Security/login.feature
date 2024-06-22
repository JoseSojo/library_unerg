Feature: Profile user in API

    Background:
        Given a global client with "test@example.com" and "abc.12345"

    Scenario: Get profile of user logged
        # Usuario con error en email
        And I add the request parameters:
            | client_id | %client_id% |
            | client_secret | %client_secret% |
            | grant_type | password |
            | username | _test@example.com |
            | password | abc.12345 |
        When I request "POST /token"
        Then the response status code is 400
        And the response has a "error" property and it is equals "invalid_grant"
        And the response has a "error_description" property and it is equals "The user credentials were incorrect."
        # Usuario con error en contraseña
        And I add the request parameters:
            | client_id | %client_id% |
            | client_secret | %client_secret% |
            | grant_type | password |
            | username | test@example.com |
            | password | abc.123456 |
        When I request "POST /token"
        Then the response status code is 400
        And the response has a "error" property and it is equals "invalid_grant"
        And the response has a "error_description" property and it is equals "The user credentials were incorrect."
        # Usuario exitoso
        And I add the request parameters:
            | client_id | %client_id% |
            | client_secret | %client_secret% |
            | grant_type | password |
            | username | test@example.com |
            | password | abc.12345 |
        When I request "POST /token"
        Then the response status code is 200
        And the response has a "access_token" property
        And the response has a "expires_in" property
        And the response has a "token_type" property
        And the response has a "refresh_token" property

