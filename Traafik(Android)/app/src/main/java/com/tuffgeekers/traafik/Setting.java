package com.tuffgeekers.traafik;

import android.app.Activity;
import android.app.Dialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.Typeface;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;
import android.text.Html;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.widget.AdapterView;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.CameraPosition;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;
import com.tuffgeekers.GoogleClasses.DownloadTask;
import com.tuffgeekers.GoogleClasses.GooglePlacesAutocompleteAdapter;
import com.tuffgeekers.utils.AutoResizeTextView;
import com.tuffgeekers.utils.Global;
import com.tuffgeekers.utils.SharedPref;

import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;

/**
 * Created by hitesh on 2/19/16.
 */
public class Setting extends Activity implements View.OnClickListener{


    private AutoResizeTextView tv_header_setting,tv_general_head,tv_setting_general,tv_setting_use,tv_setting_help,tv_setting_about,tv_setting_spread,tv_setting_navigation,tv_setting_sound,tv_setting_network;
    private Typeface tf;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_setting);
        initializeViews();
        //  setTypeface();

        tv_setting_general.setOnClickListener(this);
        tv_setting_navigation.setOnClickListener(this);
        tv_setting_spread.setOnClickListener(this);

    }
    private void initializeViews() {

        tv_header_setting=(AutoResizeTextView)findViewById(R.id.tv_header_setting);
        tv_general_head=(AutoResizeTextView)findViewById(R.id.tv_general_head);
        tv_setting_general=(AutoResizeTextView)findViewById(R.id.tv_setting_general);
        tv_setting_network=(AutoResizeTextView)findViewById(R.id.tv_setting_network);
        tv_setting_sound=(AutoResizeTextView)findViewById(R.id.tv_setting_sound);
        tv_setting_navigation=(AutoResizeTextView)findViewById(R.id.tv_setting_navigation);
        tv_setting_spread=(AutoResizeTextView)findViewById(R.id.tv_setting_spread);
        tv_setting_about=(AutoResizeTextView)findViewById(R.id.tv_setting_about);
        tv_setting_help=(AutoResizeTextView)findViewById(R.id.tv_setting_help);
        tv_setting_use=(AutoResizeTextView)findViewById(R.id.tv_setting_use);
    }
   /* private void setTypeface() {
        tf = Typeface.createFromAsset(this.getAssets(), "Roboto-Light.ttf");
        tv_header_setting.setTypeface(tf);
        tv_general_head.setTypeface(tf);
        tv_setting_general.setTypeface(tf);
        tv_setting_network.setTypeface(tf);
        tv_setting_sound.setTypeface(tf);
        tv_setting_navigation.setTypeface(tf);
        tv_setting_spread.setTypeface(tf);
        tv_setting_about.setTypeface(tf);
        tv_setting_help.setTypeface(tf);
        tv_setting_use.setTypeface(tf);
    }*/

    @Override
    public void onBackPressed() {
       /* Intent in = new Intent(Setting.this, Home.class);
        startActivity(in);*/
        finish();
    }

    @Override
    public void onClick(View v) {
        if (v==tv_setting_general){

            setRadiusPopUp();

        }

        else if(v==tv_setting_navigation){

          /*  Intent in = new Intent(Setting.this, ViewShaing.class);
            startActivity(in);*/

        }
        else if (v==tv_setting_spread){

            Intent sharingIntent = new Intent(Intent.ACTION_SEND);
            sharingIntent.setType("text/html");
            sharingIntent.putExtra(android.content.Intent.EXTRA_TEXT, Html.fromHtml("<p>www.traafik.com</p>"));
            startActivity(Intent.createChooser(sharingIntent,"Share using"));

        }

    }

    public void setRadiusPopUp(){


        final Dialog dialog = new Dialog(Setting.this);
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog.getWindow().setBackgroundDrawable(new ColorDrawable(Color.TRANSPARENT));
        dialog.setCancelable(true);
        dialog.setContentView(R.layout.chat_radius_pop_up);

        final Button btn_cancel = (Button) dialog.findViewById(R.id.btn_cancel);
        final Button btn_continue = (Button) dialog.findViewById(R.id.btn_continue);
        final EditText et_radius = (EditText) dialog.findViewById(R.id.et_radius);

        btn_cancel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                dialog.dismiss();
            }
        });

        btn_continue.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                SharedPref.set_Radius(Setting.this, ""+et_radius.getText().toString().trim());
                dialog.dismiss();
            }
        });

        dialog.show();


    }
}


