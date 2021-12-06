Feature: Api status
  In order to know the server is up and running
  As a lovely health check
  I want to check the api status

  Scenario: Check the api status
    Given I send a GET request to "/lovely-health-check?name=Pepe"
    Then the response content should be:
    """
    {
      "mooc-backend": "ok",
      "message": "Todo va fino Pepe",
      "datetime": "2020-01-01 00:00:00"
    }
    """