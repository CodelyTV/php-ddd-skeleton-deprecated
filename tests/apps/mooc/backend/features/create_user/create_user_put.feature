Feature: Api status
  In order to know the server is up and running
  As a health check
  I want to check the api status

  Scenario: Check the api status
    Given I send a PUT request to "/users/22222222-1111-2222-1111-222222222222" with body:
    """
    {
      "name": "Pepito",
      "email": "pepito@mail.com"
    }
    """
    Then the response status code should be 201
    And the response should be empty