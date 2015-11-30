Feature: Settings
  As a user and a logged-in user
  I want to change the settings on my Android Smartphone
  So that I can connect to another server
  and stream with another resolution
  and instantly upload captured pictures

  @wip
  Scenario Outline: change connection settings
    Given I have a SettingsActivity
    When I press Connection Settings
    And I press "<entry>"
    And I type "<value>"
    And I press OK
    Then I should see "<value>" on the display

    Examples:
      | entry        | value |
      | Server Host  | 192.168.2.1 |
      | Server Port  | 50000       |
      | Mail         | test@mail.de|
      | Password     | secretpw    |

#  @wip
#  Scenario: change picture upload to instant upload
#    Given I see "setting screen"
#    When I check "instant upload"
#    Then I should see a checked check box on the display
#
#  @wip
#  Scenario: change picture upload to not instant upload
#    Given I see "setting screen"
#    When I uncheck "instant upload"
#    Then I should see an unchecked check box on the display