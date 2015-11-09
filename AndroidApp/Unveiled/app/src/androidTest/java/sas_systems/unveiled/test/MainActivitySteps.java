package sas_systems.unveiled.test;

import android.test.ActivityInstrumentationTestCase2;

import cucumber.api.CucumberOptions;
import cucumber.api.java.en.Given;
import cucumber.api.java.en.Then;
import cucumber.api.java.en.When;
import sas_systems.unveiled.MainActivity;
import sas_systems.unveiled.R;

import static android.support.test.espresso.Espresso.onView;
import static android.support.test.espresso.action.ViewActions.click;
import static android.support.test.espresso.assertion.ViewAssertions.matches;
import static android.support.test.espresso.matcher.ViewMatchers.isClickable;
import static android.support.test.espresso.matcher.ViewMatchers.isCompletelyDisplayed;
import static android.support.test.espresso.matcher.ViewMatchers.isDisplayed;
import static android.support.test.espresso.matcher.ViewMatchers.withId;
import static android.support.test.espresso.matcher.ViewMatchers.withText;

/**
 * Created by CodeLionX on 01.11.2015.
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
    public void I_press_nothing() {
    }

    @When("^I press Button \"(.*)\"$")
    public void I_press_button(final String w) {
        if(w == "btCamera") {
            onView(withId(R.id.btCamera)).perform(click());
        }
    }

    @Then("^I see \"(.*)\"$")
    public void I_see_something(final String w) {
        onView(withId(R.id.lbHello)).check(matches(withText(w)));
    }

    @Then("^I see CameraActivity$")
    public void I_see_CameraActivity() {
        try {
            Thread.sleep(2000);
        } catch (InterruptedException e) {
            fail(e.getMessage());
            e.printStackTrace();
        }
        onView(withId(R.id.surface_layout)).check(matches(isDisplayed()));
    }
}
