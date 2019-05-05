@edit-task

Feature: after authentication, i need to be able to edit task.

  Background:
    Given I am on "/login"
    And I load fixtures with the following command "doctrine:fixtures:load"
    And task with title "tâche 3" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"

  Scenario: [error] only owner can edit task
    And I fill in "Nom d'utilisateur :" with "user1"
    And I fill in "Mot de passe :" with "user1"
    And I press "Se connecter"
    And I am on "/tasks/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/edit"
    Then the response status code should be 403

  Scenario: [error] trying to edit no exist task
    And I fill in "Nom d'utilisateur :" with "user1"
    And I fill in "Mot de passe :" with "user1"
    And I press "Se connecter"
    And I am on "/tasks/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaab/edit"
    Then the response status code should be 404