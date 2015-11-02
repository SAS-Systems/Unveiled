package sas_systems.unveiled;

import android.app.Activity;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;

public class MainActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        setOnClickListener();
    }

    public void setOnClickListener() {
        Button bt = (Button) findViewById(R.id.btCamera);

        bt.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startCaptureVideo();
            }
        });
    }

    public void startCaptureVideo() {
        Intent cameraActivity = new Intent(MainActivity.this, CameraActivity.class);
        startActivity(cameraActivity);
    }
}
