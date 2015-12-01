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
    Then I should see "<value>" as setting "<entry>"

    Examples:
      | entry        | value       |
      | Server Host  | 192.168.2.1 |
      | Server Port  | 50000       |
      | Mail         | test@mail.de|
      | Password     | secretpw    |

#  @wip
#  Scenario Outline: change video quality
#    Given I have a SettingsActivity
#    When I press "Video Settings"
#    And I press "Video Resolution"
#    And I check "<resolution>"
#    Then I should see "<resolution>" on the display
#
#    Examples:
#      | resolution |
#      | 480p       |
#      | 720p       |
#      | 1080p      |

#  @wip
#  Scenario: change picture upload to not instant upload
#    Given I see "setting screen"
#    When I uncheck "instant upload"
#    Then I should see an unchecked check box on the display