Feature: Fino endpoint
  In order to see todo va fino endpoind called by with name as param
  I want to check the Fino endpoint

  Scenario: Check the api status
    Given I send a GET request to "/fino/Carlitos"
    Then the response content should be:
    """
    {
      "desc": "Todo va fino Carlitos",
      "date": "2020-01-01 00:00:00"
    }
    """
