package com.tuffgeekers.traafik;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;

import com.tuffgeekers.traafik.GeneralUser.Home;
import com.tuffgeekers.utils.AutoResizeTextView;
import com.tuffgeekers.utils.Global;

/**
 * Created by hitesh on 2/20/16.
 */
public class TraafikFeed extends Activity implements View.OnClickListener {

    private ImageView iv_goback;
    AutoResizeTextView tv_total_display, tv_total_goSlow, tv_total_police, tv_total_accident, tv_total_hazard, tv_total_roadclosed, tv_total_checkIN;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_traffic_feed);
        initializeViews();
        iv_goback.setOnClickListener(this);
        setCount();

    }

    private void setCount() {

        tv_total_display.setText("0");
        tv_total_goSlow.setText(Global.total_goslow);
        tv_total_police.setText(Global.total_police);
        tv_total_accident.setText(Global.total_accident);
        tv_total_hazard.setText(Global.total_hazards);
        tv_total_roadclosed.setText(Global.total_roadclosed);

    }

    @Override
    public void onBackPressed() {

        finish();
    }

    private void initializeViews() {


        iv_goback = (ImageView) findViewById(R.id.iv_goback);
        tv_total_display = (AutoResizeTextView) findViewById(R.id.tv_total_display);
        tv_total_goSlow = (AutoResizeTextView) findViewById(R.id.tv_total_goSlow);
        tv_total_police = (AutoResizeTextView) findViewById(R.id.tv_total_police);
        tv_total_accident = (AutoResizeTextView) findViewById(R.id.tv_total_accident);
        tv_total_hazard = (AutoResizeTextView) findViewById(R.id.tv_total_hazard);
        tv_total_roadclosed = (AutoResizeTextView) findViewById(R.id.tv_total_roadclosed);
        tv_total_checkIN = (AutoResizeTextView)findViewById(R.id.tv_total_checkIN);
    }

    @Override
    public void onClick(View v) {
        Intent back = new Intent(TraafikFeed.this, Home.class);
        startActivity(back);
        finish();

    }
}
