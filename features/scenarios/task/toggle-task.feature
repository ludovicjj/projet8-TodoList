@toggle-task

Feature: after authentication, i need to be able to toggle task.

  Background:
    Given I am on "/login"
    And I load fixtures with the following command "doctrine:fixtures:load"
    And task with title "tâche 3" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"

  Scenario: [fail] only owner can toggle task
    And I fill in "Nom d'utilisateur :" with "user1"
    And I fill in "Mot de passe :" with "user1"
    And I press "Se connecter"
    And I am on "/tasks/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/toggle"
    Then the response status code should be 403

  Scenario: [fail] trying to toggle no exist task
    And I fill in "Nom d'utilisateur :" with "user1"
    And I fill in "Mot de passe :" with "user1"
    And I press "Se connecter"
    And I am on "/tasks/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaab/toggle"
    Then the response status code should be 404