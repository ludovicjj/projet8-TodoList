@delete-task

Feature: after authentication, i need to be able to delete task.

  Background:
    Given I am on "/login"
    And I load fixtures with the following command "doctrine:fixtures:load"
    And task with title "tâche 3" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"

  Scenario: [fail] only owner can delete task
    And I fill in "Nom d'utilisateur :" with "user1"
    And I fill in "Mot de passe :" with "user1"
    And I press "Se connecter"
    And I am on "/tasks/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/delete"
    Then the response status code should be 403

  Scenario: [fail] trying to delete no exist task
    And I fill in "Nom d'utilisateur :" with "user1"
    And I fill in "Mot de passe :" with "user1"
    And I press "Se connecter"
    And I am on "/tasks/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaab/delete"
    Then the response status code should be 404

  Scenario: [success] with user1 creadential, i should be able to delete the task create by this user
    And I fill in "Nom d'utilisateur :" with "user1"
    And I fill in "Mot de passe :" with "user1"
    And I press "Se connecter"
    And I follow "Tâches"
    And I follow "Liste des tâche en attente"
    And I should be on "/tasks?search=waiting"
    When I follow "Supprimer"
    Then I should be on "/tasks?search=waiting"
    And I should see "Superbe ! La tâche a bien été supprimée."
    And I should see 3 "div.thumbnail" element
    And task with title "tâche 2" should not exist in database

  Scenario: [success] with admin creadential, i should be able to delete any task without must be owner
    And I fill in "Nom d'utilisateur :" with "admin"
    And I fill in "Mot de passe :" with "admin"
    And I press "Se connecter"
    And I am on "/tasks/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/delete"
    Then I should be on "/tasks?search=waiting"
    And I should see "Superbe ! La tâche a bien été supprimée."
    And I should see 3 "div.thumbnail" element
    And task with title "tâche 3" should not exist in database