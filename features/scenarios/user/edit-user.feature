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

  Scenario: [fail] submit form with an already existing username
    When I fill in "Nom d'utilisateur :" with "admin"
    And I fill in "Mot de passe :" with "admin"
    And I press "Se connecter"
    And I am on "/users/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/edit"
    And the "Nom d'utilisateur" field should contain "user1"
    And the "Adresse email" field should contain "user1@gmail.com"
    And the "select[id='edit_user_roles'] option[selected='selected']" element should contain "Utilisateur"
    And I fill in "Nom d'utilisateur" with "admin"
    And I press "Modifier"
    Then I should see "Ce nom d'utilisateur est déjà utilisé."

  Scenario: [fail] submit form with and already existing email
    When I fill in "Nom d'utilisateur :" with "admin"
    And I fill in "Mot de passe :" with "admin"
    And I press "Se connecter"
    And I am on "/users/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/edit"
    And the "Nom d'utilisateur" field should contain "user1"
    And the "Adresse email" field should contain "user1@gmail.com"
    And the "select[id='edit_user_roles'] option[selected='selected']" element should contain "Utilisateur"
    And I fill in "Adresse email" with "admin@gmail.com"
    And I press "Modifier"
    Then I should see "Cette email est déjà utilisée."

  Scenario: [fail] submit form without fill field password
    When I fill in "Nom d'utilisateur :" with "admin"
    And I fill in "Mot de passe :" with "admin"
    And I press "Se connecter"
    And I am on "/users/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/edit"
    And the "Nom d'utilisateur" field should contain "user1"
    And the "Adresse email" field should contain "user1@gmail.com"
    And the "select[id='edit_user_roles'] option[selected='selected']" element should contain "Utilisateur"
    And I press "Modifier"
    Then I should see "Vous devez saisir un mot de passe."

  Scenario: [success] submit form with valid data
    When I fill in "Nom d'utilisateur :" with "admin"
    And I fill in "Mot de passe :" with "admin"
    And I press "Se connecter"
    And I am on "/users/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/edit"
    And I fill in "Nom d'utilisateur" with "johndoe"
    And I fill in "Mot de passe" with "pass"
    And I fill in "Tapez le mot de passe à nouveau" with "pass"
    And I fill in "Adresse email" with "user1@gmail.com"
    And I select "Administrateur" from "Rôle"
    And I press "Modifier"
    Then I should be on "/users"
    And I should see "Superbe ! L'utilisateur a bien été modifié"
    And I should see "johndoe"
    And I should see "user1@gmail.com"
    And user with username "johndoe" should exist in database and have the following role "ROLE_ADMIN"