package com.tuffgeekers.traafik;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.view.View;
import android.webkit.WebView;
import android.widget.ImageView;
import android.widget.TextView;

import com.daimajia.androidanimations.library.Techniques;
import com.daimajia.androidanimations.library.YoYo;
import com.tuffgeekers.traafik.GeneralUser.Home;
import com.tuffgeekers.traafik.TrafficManger.HomeManager;
import com.tuffgeekers.utils.SharedPref;

import tyrantgit.explosionfield.ExplosionField;

public class Splash extends Activity {


    private final int SPLASH_DISPLAY_LENGTH =5000;
    private ExplosionField mExplosionField;
    ImageView iv_logo;
    TextView tv_title;
    //WebView web;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_splash);

        mExplosionField = ExplosionField.attach2Window(this);
        iv_logo = (ImageView)findViewById(R.id.iv_logo);
        tv_title = (TextView)findViewById(R.id.tv_title);

        iv_logo.setVisibility(View.INVISIBLE);
        tv_title.setVisibility(View.INVISIBLE);

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
                tv_title.setVisibility(View.VISIBLE);
                YoYo.with(Techniques.Landing).duration(1000).playOn(tv_title);

            }
        }, 2000);




        //web = (WebView)findViewById(R.id.web);
       // web.loadUrl("http://www.traafik.com/");
       // web.getSettings().setMediaPlaybackRequiresUserGesture(false);



        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {

                if (SharedPref.get_Logged(Splash.this).equalsIgnoreCase("loggedOn")){


                    if (SharedPref.get_LoggedAccess(Splash.this).equalsIgnoreCase("user")){

                        Intent mainIntent = new Intent(Splash.this,Home.class);
                        startActivity(mainIntent);
                        overridePendingTransition(android.R.anim.fade_in, android.R.anim.fade_out);
                        finish();
                    }

                    else {

                        Intent mainIntent = new Intent(Splash.this,HomeManager.class);
                        startActivity(mainIntent);
                        overridePendingTransition(android.R.anim.fade_in, android.R.anim.fade_out);
                        finish();

                    }


                }

                else {

                    Intent mainIntent = new Intent(Splash.this,Login.class);
                    startActivity(mainIntent);
                    overridePendingTransition(android.R.anim.fade_in, android.R.anim.fade_out);
                    finish();

                }

            }
        }, SPLASH_DISPLAY_LENGTH);

    }


}
