@list-task

Feature: after authentication, i need to be able to get list task.

  Background:
    Given I am on "/login"
    And I load fixtures with the following command "doctrine:fixtures:load"

  Scenario: [success] list task done is empty
    And I fill in "Nom d'utilisateur :" with "admin"
    And I fill in "Mot de passe :" with "admin"
    And I press "Se connecter"
    And I follow "Tâches"
    And I follow "Liste des tâches terminées"
    Then I should be on "/tasks?search=done"
    And I should see "Il n'y a pas encore de tâche enregistrée."
    And I should see "Créer une tâche"

  Scenario: [success] with admin credentials, i should see button to delete and toggle for all tasks. And i can update all tasks by their title link.
    And I fill in "Nom d'utilisateur :" with "admin"
    And I fill in "Mot de passe :" with "admin"
    And I press "Se connecter"
    And I follow "Tâches"
    And I follow "Liste des tâches à faire"
    Then I should be on "/tasks?search=waiting"
    And I should see link "tâche 1"
    And I should see link "tâche 2"
    And I should see link "tâche 3"
    And I should see link "tâche 4"
    And I should see "Créer une tâche"
    And I should see 4 "div.thumbnail" element
    And I should see 4 "div.thumbnail-action .btn-success" element
    And I should see 4 "div.thumbnail-action .btn-danger" element

  Scenario: [success] with user credentials, i should only see button to delete and toggle for my tasks. And i can only update my tasks by title link.
    And I fill in "Nom d'utilisateur :" with "user1"
    And I fill in "Mot de passe :" with "user1"
    And I press "Se connecter"
    And I follow "Tâches"
    And I follow "Liste des tâches à faire"
    Then I should be on "/tasks?search=waiting"
    And I not should see link "tâche 1"
    And I should see link "tâche 2"
    And I not should see link "tâche 3"
    And I not should see link "tâche 4"
    And I should see "Créer une tâche"
    And I should see 4 "div.thumbnail" element
    And I should see 1 "div.thumbnail-action .btn-success" element
    And I should see 1 "div.thumbnail-action .btn-danger" element