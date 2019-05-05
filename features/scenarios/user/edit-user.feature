@edit-user

Feature: after authentication, i need to be able to edit user.

  Background:
    Given I am on "/login"
    And I load fixtures with the following command "doctrine:fixtures:load"
    And user with username "user1" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"

  Scenario: [fail] As non-admin, i trying to edit user
    When I fill in "Nom d'utilisateur :" with "user2"
    And I fill in "Mot de passe :" with "user2"
    And I press "Se connecter"
    And I am on "/users/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/edit"
    Then the response status code should be 403

  Scenario: [fail] Trying to edit not exist user
    When I fill in "Nom d'utilisateur" with "admin"
    And I fill in "Mot de passe" with "admin"
    And I press "Se connecter"
    And I am on "/users/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaab/edit"
    Then the response status code should be 404