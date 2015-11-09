@wip
Feature: Settings
  AS a user and a logged-in user
  I want to change the settings on my Android Smartphone
  So that I can connect to another server
  and stream with another resolution
  and instantly upload captured pictures

  @wip
  Scenario Outline: change settings entry
	Given I see settings screen
	And all entries are empty
	When I choose <entry>
	And I type <value>
	Then I should see <value> on the display

	Examples:
	  | entry   | value |
	  | "IP"    | "192.168.2.1" |
	  | "port"  | "50000"       |
	  | "resolution" | "1080x1920" |

  @wip
  Scenario: change picture upload to instant upload
	Given I see "setting screen"
	When I check "instant upload"
	Then I should see a checked check box on the display

  @wip
  Scenario: change picture upload to not instant upload
	Given I see "setting screen"
	When I uncheck "instant upload"
	Then I should see an unchecked check box on the display