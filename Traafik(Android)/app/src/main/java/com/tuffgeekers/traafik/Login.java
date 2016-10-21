package com.tuffgeekers.traafik;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.Typeface;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Handler;
import android.os.StrictMode;
import android.text.Html;
import android.text.InputType;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;

import com.daimajia.androidanimations.library.Techniques;
import com.daimajia.androidanimations.library.YoYo;
import com.dd.processbutton.iml.ActionProcessButton;
import com.google.android.gms.gcm.GoogleCloudMessaging;
import com.rengwuxian.materialedittext.MaterialEditText;
import com.tuffgeekers.traafik.GeneralUser.Home;
import com.tuffgeekers.traafik.TrafficManger.HomeManager;
import com.tuffgeekers.utils.AlertMessage;
import com.tuffgeekers.utils.AndroidMultiPartEntity;
import com.tuffgeekers.utils.AutoResizeTextView;
import com.tuffgeekers.utils.Global;
import com.tuffgeekers.utils.SharedPref;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.mime.content.FileBody;
import org.apache.http.entity.mime.content.StringBody;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;
import org.json.JSONArray;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.File;
import java.io.IOException;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.List;

import cn.pedant.SweetAlert.SweetAlertDialog;

/**
 * Created by hitesh on 2/17/16.
 */
public class Login extends Activity implements View.OnClickListener {
    private MaterialEditText et_email_signin, et_password_signin;
    AlertMessage alert = new AlertMessage();
    private Typeface tf;
    private AutoResizeTextView tv_header_signIn, tv_bottomText, txt_signIn;
    ActionProcessButton txt_signIn_action;
    String auth_code;

    String email, password;
    private StringBuilder sb;
    String role_id;
    GoogleCloudMessaging gcm;
    String regidd="";
    public static String regid;
    ImageView showPwd, logo_traffic;
    boolean isPasswordShown = false;
    LinearLayout ll_signUp;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);


        StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder()
                .permitAll().build();
        StrictMode.setThreadPolicy(policy);
        //
        initializeViews();

        loadViews();


        tv_bottomText.setOnClickListener(this);
        txt_signIn.setOnClickListener(this);
        showPwd.setOnClickListener(this);

        String text = "<font color=#000000>Don't have an account?</font> <font color=#fd5722>  <u> SignUp </u></font>";
        tv_bottomText.setText(Html.fromHtml(text));
        txt_signIn_action.setBackgroundColor(Color.parseColor("#fd5722"));

        et_email_signin.setText(Global.loginSampEmail);
        et_password_signin.setText(Global.loginSampPwd);

        et_password_signin.setInputType(InputType.TYPE_CLASS_TEXT |InputType.TYPE_TEXT_VARIATION_PASSWORD);
        showPwd.setImageResource(R.drawable.icon_pwd_gone);



    }

    private void loadViews() {
        logo_traffic.setVisibility(View.INVISIBLE);
        et_email_signin.setVisibility(View.INVISIBLE);
        et_password_signin.setVisibility(View.INVISIBLE);
        ll_signUp.setVisibility(View.INVISIBLE);
        tv_bottomText.setVisibility(View.INVISIBLE);


        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                logo_traffic.setVisibility(View.VISIBLE);
                YoYo.with(Techniques.DropOut).duration(1000).playOn(logo_traffic);

            }
        }, 1000);

        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                et_email_signin.setVisibility(View.VISIBLE);
                YoYo.with(Techniques.SlideInLeft).duration(1000).playOn(et_email_signin);

            }
        }, 1500);

        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                et_password_signin.setVisibility(View.VISIBLE);
                YoYo.with(Techniques.SlideInLeft).duration(1000).playOn(et_password_signin);

            }
        }, 2000);

        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                ll_signUp.setVisibility(View.VISIBLE);
                YoYo.with(Techniques.SlideInLeft).duration(1000).playOn(txt_signIn_action);

            }
        }, 2500);

        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                tv_bottomText.setVisibility(View.VISIBLE);
                YoYo.with(Techniques.SlideInUp).duration(1000).playOn(tv_bottomText);

            }
        }, 3000);

    }

    public void initializeViews() {

        tv_header_signIn = (AutoResizeTextView) findViewById(R.id.tv_header_signIn);
        tv_bottomText = (AutoResizeTextView) findViewById(R.id.tv_bottomText);
        et_email_signin = (MaterialEditText) findViewById(R.id.et_email_signin);
        et_password_signin = (MaterialEditText) findViewById(R.id.et_password_signin);
        txt_signIn = (AutoResizeTextView) findViewById(R.id.txt_signIn);
        txt_signIn_action = (ActionProcessButton) findViewById(R.id.txt_signIn_action);
        showPwd = (ImageView)findViewById(R.id.showPwd);
        logo_traffic = (ImageView)findViewById(R.id.logo_traffic);

        ll_signUp = (LinearLayout)findViewById(R.id.ll_signUp);

    }

    @Override
    public void onClick(View v) {

        switch (v.getId()) {
            case R.id.txt_signIn:
                onExecuteLogin();
                break;
            case R.id.tv_bottomText:
                Intent in = new Intent(Login.this, SignUp.class);
                startActivity(in);
                Global.loginSampEmail = et_email_signin.getText().toString();
                Global.loginSampPwd = et_password_signin.getText().toString();
                overridePendingTransition(android.R.anim.fade_in, android.R.anim.fade_out);
                finish();
                break;
            case  R.id.showPwd:

                if (isPasswordShown){

                    isPasswordShown= false;
                    et_password_signin.setInputType(InputType.TYPE_CLASS_TEXT |InputType.TYPE_TEXT_VARIATION_PASSWORD);
                    showPwd.setImageResource(R.drawable.icon_pwd_gone);
                    et_password_signin.setSelection(et_password_signin.getText().length());
                }
                else {
                    isPasswordShown= true;
                    et_password_signin.setInputType(InputType.TYPE_CLASS_TEXT |InputType.TYPE_NULL);
                    showPwd.setImageResource(R.drawable.icon_pwd_visible);
                    et_password_signin.setSelection(et_password_signin.getText().length());

                }


                break;
        }
    }

    private void onExecuteLogin() {

        email = et_email_signin.getText().toString().trim();
        password = et_password_signin.getText().toString().trim();


        if (email.equalsIgnoreCase("")) {

            YoYo.with(Techniques.Tada).duration(700).playOn(et_email_signin);
            et_email_signin.setError("Email required");
           // alert.showErrorPopup(Login.this, "Error", "Please enter email");
        } else if (password.equalsIgnoreCase("")) {

            YoYo.with(Techniques.Tada).duration(700).playOn(et_password_signin);
            et_password_signin.setError("Password required");
           // alert.showErrorPopup(Login.this, "Error", "Please enter password");
        } else {

            txt_signIn_action.setProgress(50);
            txt_signIn.setText("Signing In...");
            disableButtons();

           // new AsynData().execute();

            if (regidd.equalsIgnoreCase("")){
                registerDevice();
            }
            else {
                new AsynData().execute();

            }



        }

    }

    public class AsynData extends AsyncTask<String, String, String> {
        protected void onPreExecute() {
            super.onPreExecute();


        }

        protected String doInBackground(String... params) {
            try {
                HttpClient client = new DefaultHttpClient();
                HttpPost post = new HttpPost(Global.BaseUrl + "user/login");
                List<NameValuePair> arg = new ArrayList<NameValuePair>();
                arg.add(new BasicNameValuePair("do", "login"));
                arg.add(new BasicNameValuePair("LoginForm[username]", email));
                arg.add(new BasicNameValuePair("LoginForm[password]", password));
                arg.add(new BasicNameValuePair("LoginForm[device_token]", ""+regid));
                arg.add(new BasicNameValuePair("LoginForm[device_type]", "1"));

                post.setEntity(new UrlEncodedFormEntity(arg));
                HttpResponse response = client.execute(post);
                sb = new StringBuilder();
                BufferedReader br = new BufferedReader(new InputStreamReader(response.getEntity().getContent()));
                String code = "";
                while ((code = br.readLine()) != null) {
                    Log.e("mytag", code);
                    System.out.println("--------------" + email);
                    System.out.println("--------------" + password);
                    sb.append(code);
                }


            } catch (Exception e) {
                e.printStackTrace();
            }
            return null;

        }

        @Override
        protected void onPostExecute(String s) {
            // super.onPostExecute(s);

            try {

                Log.e("<>s<>", "" + s);

                JSONObject json = new JSONObject(sb.toString());
                Log.e("My Complete Data ", " " + json);

                String status = json.getString("status");

                if (status.equals("OK")) {
                    auth_code = json.getString("auth_code");
                    final String user_id = json.getString("id");

                    Log.e("- Login-------", "" + status);
                    Log.e("- auth_code-------", "" + auth_code);
                    Log.e("- user_id-------", "" + user_id);

                    enableButtons();

                    // String userData = json.getString("user");


                    JSONArray ja = json.getJSONArray("user");
                    for (int arr = 0; arr < ja.length(); arr++) {
                        JSONObject json1 = ja.getJSONObject(arr);

                        Log.e("length", "" + ja.length());
                        // Getting JSON Array node

                        role_id = json1.getString("role_id");
                        String full_name = json1.getString("full_name");
                        String email = json1.getString("email");
                        String image_file = json1.getString("image_file");

                        Log.e("- role_id-------", "" + role_id);


                    }


                    if (role_id.equalsIgnoreCase("1")) {


                        setSuccess();

                        SweetAlertDialog pDialog = new SweetAlertDialog(Login.this, SweetAlertDialog.SUCCESS_TYPE);
                        pDialog.setCancelable(false);
                        pDialog.setTitleText("Success");
                        pDialog.setContentText("You Have Logged In Successfully As Traffic Manager");
                        pDialog.setConfirmText("ok");
                        pDialog.setConfirmClickListener(new SweetAlertDialog.OnSweetClickListener() {
                            @Override
                            public void onClick(SweetAlertDialog sweetAlertDialog) {


                                Global.userId = user_id;
                                SharedPref.set_UserId(Login.this, user_id);
                                SharedPref.set_LoggedAccess(Login.this, "manager");
                                SharedPref.set_LogAuth(Login.this, auth_code);

                                SharedPref.set_Logged(Login.this, "loggedOn");
                                Intent in = new Intent(Login.this, HomeManager.class);
                                startActivity(in);
                                finish();


                            }
                        });


                        pDialog.show();

                    } else if (role_id.equalsIgnoreCase("2")) {

                        enableButtons();
                        setSuccess();

                        SweetAlertDialog pDialog = new SweetAlertDialog(Login.this, SweetAlertDialog.SUCCESS_TYPE);
                        pDialog.setCancelable(false);
                        pDialog.setTitleText("Success");
                        pDialog.setContentText("You Have Logged In Successfully As User");
                        pDialog.setConfirmText("ok");
                        pDialog.setConfirmClickListener(new SweetAlertDialog.OnSweetClickListener() {
                            @Override
                            public void onClick(SweetAlertDialog sweetAlertDialog) {

                                Global.userId = user_id;
                                SharedPref.set_UserId(Login.this, user_id);
                                SharedPref.set_LoggedAccess(Login.this, "user");

                                SharedPref.set_Logged(Login.this, "loggedOn");
                                Intent in = new Intent(Login.this, Home.class);
                                startActivity(in);
                                finish();


                            }
                        });


                        pDialog.show();

                    }


                } else if (status.equals("NOK")) {

                    String error = json.getString("error");
                    txt_signIn_action.setProgress(-1);
                    txt_signIn.setText("Sign In");
                 //   alert.showErrorPopup(Login.this, "Error", "" + error);

                    final SweetAlertDialog pDialog = new SweetAlertDialog(Login.this, SweetAlertDialog.WARNING_TYPE);
                    pDialog.setCancelable(false);
                    pDialog.setTitleText("Error");
                    pDialog.setContentText(error);
                    pDialog.setConfirmText("Try again");
                    pDialog.setConfirmClickListener(new SweetAlertDialog.OnSweetClickListener() {
                        @Override
                        public void onClick(SweetAlertDialog sweetAlertDialog) {

                        pDialog.dismiss();

                        }
                    });

                    pDialog.setCancelText("Create account");
                    pDialog.setCancelClickListener(new SweetAlertDialog.OnSweetClickListener() {
                        @Override
                        public void onClick(SweetAlertDialog sweetAlertDialog) {

                            pDialog.cancel();
                            Intent in = new Intent(Login.this, SignUp.class);
                            startActivity(in);
                            Global.loginSampEmail = et_email_signin.getText().toString();
                            Global.loginSampPwd = et_password_signin.getText().toString();
                            overridePendingTransition(android.R.anim.fade_in, android.R.anim.fade_out);
                            finish();
                        }
                    });


                    pDialog.show();




                    enableButtons();
                }


            } catch (Exception e) {

                e.printStackTrace();
                txt_signIn_action.setProgress(-1);
                txt_signIn.setText("Sign In");
            }


        }
    }

    public void setSuccess() {

        txt_signIn_action.setProgress(100);
        txt_signIn.setText("Success");
    }


    public void disableButtons() {

        et_email_signin.setEnabled(false);
        et_password_signin.setEnabled(false);
        txt_signIn.setEnabled(false);
        tv_bottomText.setEnabled(false);

    }

    public void enableButtons() {

        et_email_signin.setEnabled(true);
        et_password_signin.setEnabled(true);
        txt_signIn.setEnabled(true);
        tv_bottomText.setEnabled(true);

    }

    public void registerDevice() {

        gcm = GoogleCloudMessaging.getInstance(Login.this);
        String regid=regidd;

        Log.e("SAVE IDDDD", "<><><<><><>><" + regid);
        if (regid.isEmpty()) {

            Log.e("regid.isEmpty()", "**************");

            registerBackground();
        }
    }

    @SuppressWarnings("unchecked")
    private void registerBackground() {
        new AsyncTask() {
            @Override
            protected Object doInBackground(Object... params) {

                try {
                    if (gcm == null) {
                        gcm = GoogleCloudMessaging.getInstance(Login.this);
//						388473811970
                    }
                    regid = gcm.register("409868865759");
                    Log.e("REGIDSDDDDDDDDD", "<><><><><>><><<><>" + regid);

                    new Thread(new Runnable() {
                        public void run() {

                            new AsynData().execute();

                        }
                    }).start();



                    regidd=regid;
                }

                catch (IOException ex) {
                    ex.printStackTrace();
                }

                return null;
            }

        }.execute(null, null, null);
    }


}

