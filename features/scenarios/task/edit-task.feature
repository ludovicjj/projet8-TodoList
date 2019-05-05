@edit-task

Feature: after authentication, i need to be able to edit task.

  Background:
    Given I am on "/login"
    And I load fixtures with the following command "doctrine:fixtures:load"
    And task with title "tâche 3" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"

  Scenario: [fail] only owner can edit task
    And I fill in "Nom d'utilisateur :" with "user1"
    And I fill in "Mot de passe :" with "user1"
    And I press "Se connecter"
    And I am on "/tasks/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/edit"
    Then the response status code should be 403

  Scenario: [fail] trying to edit no exist task
    And I fill in "Nom d'utilisateur :" with "user1"
    And I fill in "Mot de passe :" with "user1"
    And I press "Se connecter"
    And I am on "/tasks/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaab/edit"
    Then the response status code should be 404

  Scenario: [fail] submit form with invalid data
    And I fill in "Nom d'utilisateur :" with "user1"
    And I fill in "Mot de passe :" with "user1"
    And I press "Se connecter"
    And I follow "Tâches"
    And I follow "Liste des tâche en attente"
    And I should be on "/tasks?search=waiting"
    When I follow "tâche 2"
    Then I should see "Modifier tâche 2"
    And the "titre" field should contain "tâche 2"
    And the "Contenu" field should contain "Description de la tâche 2"
    When I fill in "titre" with ""
    And I fill in "Contenu" with ""
    And I press "Modifier"
    Then I should see "Vous devez saisir un titre."
    Then I should see "Vous devez saisir du contenu."

  Scenario: [success] submit form with valid data
    And I fill in "Nom d'utilisateur :" with "user1"
    And I fill in "Mot de passe :" with "user1"
    And I press "Se connecter"
    And I follow "Tâches"
    And I follow "Liste des tâche en attente"
    And I should be on "/tasks?search=waiting"
    When I follow "tâche 2"
    Then I should see "Modifier tâche 2"
    And the "titre" field should contain "tâche 2"
    And the "Contenu" field should contain "Description de la tâche 2"
    When I fill in "titre" with "ma super tâche"
    And I fill in "Contenu" with "La description de la tâche 2 mise à jour"
    And I press "Modifier"
    Then I should be on "/tasks"
    And I should see "Superbe ! La tâche a bien été modifiée."
    And I should see "ma super tâche"
    And I should see "La description de la tâche 2 mise à jour"