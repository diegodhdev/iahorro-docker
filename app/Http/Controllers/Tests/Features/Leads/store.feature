Feature: View a creation lead form
  In order to view a creation for a lead on the platform

  Scenario: Storing a valid lead
    Given I send a PUT request to "lead/store" with body:
    """
    {
      "name": "John Doe",
      "email": "test@tes.com",
      "phone": "627629577"
    }
    """
    Then the response status code should be 201
