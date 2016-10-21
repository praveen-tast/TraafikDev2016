package com.tuffgeekers.traafik;

import android.app.Activity;
import android.graphics.Typeface;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageView;

import com.tuffgeekers.circularImageView.CircularImageView;
import com.tuffgeekers.utils.AutoResizeTextView;

/**
 * Created by hitesh on 2/19/16.
 */
public class EditProfile extends Activity implements View.OnClickListener {

    private EditText et_firstname,et_lastname,et_username,et_password;
    private CircularImageView edit_profile_pic;
    private AutoResizeTextView profile_name,profile_post;
    private ImageView btn_save;
    private Typeface tf;
    private AutoResizeTextView tv_header_edit_profile;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_edit_profile);
        initializeViews();
    //    setTypeface();
        btn_save.setOnClickListener(this);
    }

  /*  private void setTypeface() {
        tf = Typeface.createFromAsset(this.getAssets(), "Roboto-Light.ttf");
        et_firstname.setTypeface(tf);
        et_lastname.setTypeface(tf);
        et_username.setTypeface(tf);
        et_password.setTypeface(tf);
        tv_header_edit_profile.setTypeface(tf);
        profile_name.setTypeface(tf);
        profile_post.setTypeface(tf);
    }*/

    @Override
    public void onBackPressed() {
        /*Intent in = new Intent(EditProfile.this, Home.class);
        startActivity(in);*/
        finish();
    }
    private void initializeViews() {
        edit_profile_pic=(CircularImageView)findViewById(R.id.edit_profile_pic);
        profile_name=(AutoResizeTextView)findViewById(R.id.profile_name);
        profile_post=(AutoResizeTextView)findViewById(R.id.profile_post);
        tv_header_edit_profile=(AutoResizeTextView)findViewById(R.id.tv_header_edit_profile);
        et_firstname=(EditText)findViewById(R.id.et_firstname);
        et_lastname=(EditText)findViewById(R.id.et_lastname);
        et_username=(EditText)findViewById(R.id.et_username);
        et_password=(EditText)findViewById(R.id.et_password);
        btn_save=(ImageView)findViewById(R.id.btn_save);
       
    }

    @Override
    public void onClick(View v) {
        onSaveClick();
    }

    private void onSaveClick() {

    }
}
