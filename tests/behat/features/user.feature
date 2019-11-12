Feature: Users
  Scenario: List Users
    When I make a GET request to "users/"
    Then the response code should be 200

  Scenario: End point not exist
    When I make a GET request to "ThisDoesNotExists"
    Then the response code should be 404

  Scenario: Create User
    When I make a POST request to the route "users/" with the Payload
    """
      {
        "username": "BehatUsername",
        "name": "Behat test Name"
      }
    """
    Then the response code should be 200
    And the response should have attribute "username" equal with "BehatUsername"