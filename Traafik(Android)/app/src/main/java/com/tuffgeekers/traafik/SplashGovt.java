package com.tuffgeekers.traafik;

import android.app.Activity;
import android.content.Intent;
import android.os.Handler;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;

import com.daimajia.androidanimations.library.Techniques;
import com.daimajia.androidanimations.library.YoYo;
import com.tuffgeekers.traafik.GeneralUser.Home;

public class SplashGovt extends Activity {

    ImageView iv_logo;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_splash_govt);

        iv_logo = (ImageView)findViewById(R.id.iv_logo);


        iv_logo.setVisibility(View.INVISIBLE);


        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                iv_logo.setVisibility(View.VISIBLE);
                YoYo.with(Techniques.Landing).duration(1000).playOn(iv_logo);

            }
        }, 1000);


        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {

                Intent mainIntent = new Intent(SplashGovt.this,Splash.class);
                startActivity(mainIntent);
                overridePendingTransition(android.R.anim.fade_in, android.R.anim.fade_out);
                finish();

            }
        }, 3000);







    }
}
