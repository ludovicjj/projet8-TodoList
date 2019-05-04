@login

Feature: Only register user can login and only admin can see Utilisateurs

  Background:
    Given I am on "/login"
    And I load the following user
      | username | password   | email           | roles |
      | admin    | pass       | admin@gmail.com | 1     |
      | user     | pass       | user@gmail.com  | 0     |

  Scenario: [fail] submit form without data
    When I press "Se connecter"
    Then I should see "Mauvais identifiant."
