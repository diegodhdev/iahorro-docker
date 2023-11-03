Feature: View a creation lead form
  In order to view a creation for a lead on the platform

  Scenario: A creation form view
    Given I send a GET request to "lead/create":
    Then I should see selector id with a value of email
    And the response status code should be 200
