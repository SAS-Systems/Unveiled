package de.systemgrid.sas.unveiledapp.test;

import android.support.test.espresso.matcher.PreferenceMatchers;
import android.test.ActivityInstrumentationTestCase2;

import cucumber.api.CucumberOptions;
import cucumber.api.java.en.Given;
import cucumber.api.java.en.Then;
import cucumber.api.java.en.When;
import de.systemgrid.sas.unveiledapp.R;
import de.systemgrid.sas.unveiledapp.SettingsActivity;

import static android.support.test.espresso.Espresso.onData;
import static android.support.test.espresso.Espresso.onView;
import static android.support.test.espresso.Espresso.pressBack;
import static android.support.test.espresso.action.ViewActions.click;
import static android.support.test.espresso.action.ViewActions.replaceText;
import static android.support.test.espresso.action.ViewActions.typeText;
import static android.support.test.espresso.assertion.ViewAssertions.matches;
import static android.support.test.espresso.matcher.RootMatchers.isDialog;
import static android.support.test.espresso.matcher.ViewMatchers.withId;
import static android.support.test.espresso.matcher.ViewMatchers.withTagKey;
import static android.support.test.espresso.matcher.ViewMatchers.withText;

/**
 * Created by D062321 on 23.11.2015.
 */
@CucumberOptions(features = "features/settings")
public class SettingsActivitySteps extends ActivityInstrumentationTestCase2<SettingsActivity> {

    public SettingsActivitySteps() {
        super(SettingsActivity.class);

    }

    @Given("^I have a SettingsActivity$")
    public void I_have_a_SettingsActivity() {
        assertNotNull(getActivity());
    }

    @When("^I press OK$")
    public void I_press_ok() {
        onView(withText("OK")).perform(click());
    }

    @When("^I press Connection Settings$")
    public void I_press_Connection_Settings() {
        onView(withText(R.string.pref_header_data_sync)).perform(click());
    }

    @When("^I press \"(.+)\"$")
    public void I_press_w(final String w) {
        int text = 0;
        switch (w) {
            case "Server Host":
                text = R.string.pref_title_server_fqdn;
                break;
            case "Server Port":
                text = R.string.pref_title_server_port;
                break;
            case "Mail":
                text = R.string.pref_title_acc_email;
                break;
            case "Password":
                text = R.string.pref_title_acc_password;
                break;
            case "Video Settings":
                text = R.string.pref_header_video;
                break;
            case "Video Resolution":
                text = R.string.pref_title_video_resolution;
                break;
        }

        onView(withText(text)).perform(click());
    }

    @When("^I check \"(.+)\"")
    public void I_check_v(final String val) {
        String[] res = super.getActivity().getResources().getStringArray(R.array.pref_video_resolution);
        int iText = 0;

        switch (val) {
            case "480p":
                iText = 2;
                break;
            case "720p":
                iText = 1;
                break;
            case "1080p":
                iText = 0;
                break;
        }
        onView(withText(res[iText])).perform(click());
    }

    @When("^I type \"(.+)\"$")
    public void I_type_v(final String val) {
        onView(withText("Server Port")).inRoot(isDialog()).perform(replaceText(val));
//        typeText(val);
    }

    @Then("^I should see \"(.+)\" as setting \"(.+)\"$")
    public void I_should_see_s_on_the_display(final String value, final String pref) {
        int prefId = 0;
        switch (pref) {
            case "Server Host":
                prefId = R.string.pref_title_server_fqdn;
                break;
            case "Server Port":
                prefId = R.string.pref_title_server_port;
                break;
            case "Mail":
                prefId = R.string.pref_title_acc_email;
                break;
            case "Password":
                prefId = R.string.pref_title_acc_password;
                break;
        }
        PreferenceMatchers.withTitle(prefId).matches(onView(withText(value)));
//        assertNotNull(onView(withText(s)));
        pressBack();
    }
}