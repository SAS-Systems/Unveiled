@wip
Feature: test MainActivity
  As a user
  I want to see MainActivity

  Scenario: main activity started
    Given I see MainActivity
    When I press nothing
    Then I see "Hello World!"

  Scenario: test button
    Given I see MainActivity
    When I press Button "btCamera"
    Then I see CameraActivity