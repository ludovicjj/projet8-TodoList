@add-user

Feature: Check constraints validations when add user.

  Background:
    Given I am on "/login"
    And I load the following user
      | username | password | email           | roles  |
      | admin    | pass     | admin@gmail.com | 1      |
    And I fill in "Nom d'utilisateur :" with "admin"
    And I fill in "Mot de passe :" with "pass"
    And I press "Se connecter"
    And I should be on "/"
    And I follow "Utilisateurs"
    And I follow "Ajouter un utilisateur"
    And I should be on "/users/create"

  Scenario: [fail] submit form with already exist username
    When I fill in "Nom d'utilisateur" with "admin"
    And I fill in "Mot de passe" with "pass"
    And I fill in "Tapez le mot de passe à nouveau" with "pass"
    And I fill in "Adresse email" with "user@gmail.com"
    And I select "Utilisateur" from "Rôle"
    And I press "Ajouter"
    Then I should see "Ce nom d'utilisateur est déjà utilisé."