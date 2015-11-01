package sas_systems.unveiled.test;

import android.media.MediaActionSound;
import android.test.ActivityInstrumentationTestCase2;
import android.widget.Toast;

import org.junit.experimental.theories.Theory;

import cucumber.api.CucumberOptions;
import cucumber.api.java.en.Given;
import cucumber.api.java.en.Then;
import cucumber.api.java.en.When;
import sas_systems.unveiled.MainActivity;
import sas_systems.unveiled.R;

import static android.support.test.espresso.Espresso.onView;
import static android.support.test.espresso.assertion.ViewAssertions.matches;
import static android.support.test.espresso.matcher.ViewMatchers.withContentDescription;
import static android.support.test.espresso.matcher.ViewMatchers.withId;
import static android.support.test.espresso.matcher.ViewMatchers.withText;

/**
 * Created by D062321 on 01.11.2015.
 */
@CucumberOptions(features = "features")
public class MainActivitySteps extends ActivityInstrumentationTestCase2<MainActivity> {

    public MainActivitySteps() {
        super(MainActivity.class);
    }

    @Given("^I see MainActivity$")
    public void I_see_MainActivity() {
        assertNotNull(getActivity());
    }

    @When("^I press nothing$")
    public void I_see_MainActivity1() {
    }

    @Then("^I see \"([ \\w]*)\"$")
    public void I_see_MainActivity2(final String w) {
        onView(withId(R.id.lbHello)).check(matches(withText(w)));
    }
}
