package de.systemgrid.sas.unveiledapp.test;

import android.test.ActivityInstrumentationTestCase2;

import cucumber.api.CucumberOptions;
import cucumber.api.java.en.Given;
import cucumber.api.java.en.Then;
import cucumber.api.java.en.When;
import de.systemgrid.sas.unveiledapp.R;
import de.systemgrid.sas.unveiledapp.SettingsActivity;

import static android.support.test.espresso.Espresso.onView;
import static android.support.test.espresso.action.ViewActions.click;
import static android.support.test.espresso.assertion.ViewAssertions.matches;
import static android.support.test.espresso.matcher.ViewMatchers.withId;
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
    public void I_have_a_CalculatorActivity() {
        assertNotNull(getActivity());
    }

    @When("^I press ([\\w -]+)$")
    public void I_press_w(final String w) {
        onView(withText(R.string.pref_default_server_fqdn)).perform(click());
    }

    @When("^()$")
    public void I_press_op(final char op) {
       fail("wrong method...schould not match");
//       switch (op) {
//           default:
//               break;
//        }
    }

    @Then("^I should see (\\S+) on the display$")
    public void I_should_see_s_on_the_display(final String s) {
        onView(withText()).check(matches(withText(s)));
    }
}