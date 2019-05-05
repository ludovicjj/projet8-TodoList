@list-user

Feature: after authentication with admin credentials, i need to be able to got list user.

  Background:
    Given I am on "/login"
    And I load fixtures with the following command "doctrine:fixtures:load"

  Scenario: [fail] as a non-admin user, i can't have access to list user
    When I fill in "Nom d'utilisateur :" with "user1"
    And I fill in "Mot de passe :" with "user1"
    And I press "Se connecter"
    Then I am on "/users"
    And the response status code should be 403