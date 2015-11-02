@wip
Feature: capture and stream video
  As a logged-in user
  I want to capture a video with my Android smartphone
  So that I can see a preview
  and the video is streamed to the server

  # straight forward scenario:
  @wip
  Scenario: start video preview
	Given all settings are set
	And I see homescreen
	When I press the button "capture video/photo"
	Then I should see a video preview on the display

  @wip
  Scenario: start recording
	Given I see a video preview
	When I press the button "start recording"
	Then I should still see a video preview on the display
	And I should see a sending indicator on the display

  @wip
  Scenario: stop recording
	Given I see a video preview
	And I see a sending indicator
	When I press the button "stop recording"
	Then I should see "video successfully streamed" on the display
	And I should be redirected to "homescreen"

  # can't connect to the server
  @wip
  Scenario: failed to login
	Given all settings are set
	And I see homescreen
	And The server is not available
	When I press the button "capture video/photo"
	Then I should see "Failed to connect to server!" on the display

  @wip
  Scenario Outline: go back after failed login
	Given I see "Failed to connect to server!"
	When I press the button <bt>
	Then I should see <screen> on the display

	Examples:
	  | bt 				| screen 			|
	  | "back" 			| "homescreen"		|
	  | "open settings"	| "settingsscreen"	|