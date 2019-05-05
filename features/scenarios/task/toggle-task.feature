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

  Scenario: [success] with user1 creadential, i should be able to toggle the task create by this user
    And I fill in "Nom d'utilisateur :" with "user1"
    And I fill in "Mot de passe :" with "user1"
    And I press "Se connecter"
    And I follow "Tâches"
    And I follow "Liste des tâche en attente"
    And I should be on "/tasks?search=waiting"
    When I follow "Marquer comme faite"
    Then I should be on "/tasks?search=waiting"
    And I should see "Superbe ! La tâche tâche 2 a bien été marquée comme faite."
    And I should see 3 "div.thumbnail" element
    When I follow "Tâches"
    And I follow "Liste des tâche terminés"
    Then I should be on "/tasks?search=done"
    And I should see "tâche 2"
    And I should see "Marquer non terminée"

  Scenario: [success] with admin creadential, i should be able to toggle any task without must be owner
    And I fill in "Nom d'utilisateur :" with "admin"
    And I fill in "Mot de passe :" with "admin"
    And I press "Se connecter"
    And I am on "/tasks/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/toggle"
    Then I should be on "/tasks?search=waiting"
    And I should see "Superbe ! La tâche tâche 3 a bien été marquée comme faite."
    And I should see 3 "div.thumbnail" element
    When I follow "Tâches"
    And I follow "Liste des tâche terminés"
    Then I should be on "/tasks?search=done"
    And I should see "tâche 3"
    And I should see "Marquer non terminée"