@add-task

Feature: after authentication, i need to be able to add task.

  Background:
    Given I am on "/login"
    And I load the following user
      | username | password | email           | roles  |
      | admin    | admin    | admin@gmail.com | 1      |

  Scenario: [fail] submit form with no data
    And I fill in "Nom d'utilisateur :" with "admin"
    And I fill in "Mot de passe :" with "admin"
    And I press "Se connecter"
    And I should be on "/"
    And I follow "Tâches"
    And I follow "Ajouter un tâche"
    And I should be on "/tasks/create"
    When I press "Ajouter"
    Then I should see "Vous devez saisir un titre."
    Then I should see "Vous devez saisir du contenu."