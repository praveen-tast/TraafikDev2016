package com.tuffgeekers.traafik;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Color;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Environment;
import android.os.Handler;
import android.provider.MediaStore;
import android.text.Html;
import android.text.InputType;
import android.util.Base64;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Toast;

import com.daimajia.androidanimations.library.Techniques;
import com.daimajia.androidanimations.library.YoYo;
import com.dd.processbutton.iml.ActionProcessButton;
import com.rengwuxian.materialedittext.MaterialEditText;
import com.tuffgeekers.circularImageView.CircularImageView;
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
import org.apache.http.entity.mime.HttpMultipartMode;
import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.ByteArrayBody;
import org.apache.http.entity.mime.content.FileBody;
import org.apache.http.entity.mime.content.InputStreamBody;
import org.apache.http.entity.mime.content.StringBody;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.params.CoreProtocolPNames;
import org.apache.http.util.EntityUtils;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.ByteArrayInputStream;
import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.List;

import cn.pedant.SweetAlert.SweetAlertDialog;

/**
 * Created by hitesh on 2/17/16.
 */
public class SignUp extends Activity implements View.OnClickListener{
    private MaterialEditText et_username_signup, et_email_signup, et_password_signup, et_mobile_signup;
    AlertMessage alert = new AlertMessage();
    AutoResizeTextView txt_signUp;
    ActionProcessButton txt_signUp_action;
    AutoResizeTextView tv_bottomText;
    CircularImageView iv_profilePic;
    int REQUEST_CAMERA = 0, SELECT_FILE = 1;
    String email, password, username, mobile;
    Bitmap lastBitmap;
    boolean isImageSelected = false;
    File sourceFile;
    ImageView showPwd;
    boolean isPasswordShown = false;

   String url=Global.BaseUrl + "user/signup";// upload file with Server url


    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signup);
        initializeViews();
        loadViews();

        String text = "<font color=#000000>Already have an account?</font> <font color=#fd5722>  <u> SignIn </u></font>";
        tv_bottomText.setText(Html.fromHtml(text));

        txt_signUp.setOnClickListener(this);
        tv_bottomText.setOnClickListener(this);
        iv_profilePic.setOnClickListener(this);
        txt_signUp_action.setBackgroundColor(Color.parseColor("#fd5722"));

        et_email_signup.setText(Global.loginSampEmail);
        et_password_signup.setText(Global.loginSampPwd);

        showPwd.setOnClickListener(this);
        et_password_signup.setInputType(InputType.TYPE_CLASS_TEXT |InputType.TYPE_TEXT_VARIATION_PASSWORD);
        showPwd.setImageResource(R.drawable.icon_pwd_gone);

      //  setTypeface();
    }

    private void loadViews() {

        et_username_signup.setVisibility(View.INVISIBLE);
        et_email_signup.setVisibility(View.INVISIBLE);
        et_password_signup.setVisibility(View.INVISIBLE);
        et_mobile_signup.setVisibility(View.INVISIBLE);

        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                et_username_signup.setVisibility(View.VISIBLE);
                YoYo.with(Techniques.SlideInLeft).duration(700).playOn(et_username_signup);

            }
        }, 500);

        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                et_email_signup.setVisibility(View.VISIBLE);
                YoYo.with(Techniques.SlideInLeft).duration(700).playOn(et_email_signup);

            }
        }, 1000);

        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                et_password_signup.setVisibility(View.VISIBLE);
                YoYo.with(Techniques.SlideInLeft).duration(700).playOn(et_password_signup);

            }
        }, 1500);

        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                et_mobile_signup.setVisibility(View.VISIBLE);
                YoYo.with(Techniques.SlideInLeft).duration(700).playOn(et_mobile_signup);

            }
        }, 2000);

    }

  /*  private void setTypeface() {
        tf = Typeface.createFromAsset(this.getAssets(), "Roboto-Light.ttf");
        et_username_signup.setTypeface(tf);
        et_email_signup.setTypeface(tf);
        et_password_signup.setTypeface(tf);
        et_mobile_signup.setTypeface(tf);
        tv_header_signUp.setTypeface(tf);
    }*/

    @Override
    public void onBackPressed() {
        Intent in = new Intent(SignUp.this, Login.class);
        startActivity(in);
        overridePendingTransition(android.R.anim.fade_in, android.R.anim.fade_out);
        finish();
    }

    public void initializeViews() {

        et_username_signup = (MaterialEditText) findViewById(R.id.et_username_signup);
        et_email_signup = (MaterialEditText) findViewById(R.id.et_email_signup);
        et_password_signup = (MaterialEditText) findViewById(R.id.et_password_signup);
        et_mobile_signup = (MaterialEditText) findViewById(R.id.et_mobile_signup);
        tv_bottomText = (AutoResizeTextView)findViewById(R.id.tv_bottomText);
        txt_signUp = (AutoResizeTextView)findViewById(R.id.txt_signUp);
        txt_signUp_action = (ActionProcessButton)findViewById(R.id.txt_signUp_action);
        iv_profilePic = (CircularImageView)findViewById(R.id.iv_profilePic);
        showPwd = (ImageView)findViewById(R.id.showPwd);

    }

    @Override
    public void onClick(View v) {

        if (v==txt_signUp){
            onExecuteSignup();

        }

        else if (v==tv_bottomText){

            onBackPressed();
        }

        else if(v==iv_profilePic){

            selectImage();

        }

        else if (v==showPwd) {

            if (isPasswordShown) {

                isPasswordShown = false;
                et_password_signup.setInputType(InputType.TYPE_CLASS_TEXT | InputType.TYPE_TEXT_VARIATION_PASSWORD);
                showPwd.setImageResource(R.drawable.icon_pwd_gone);
                et_password_signup.setSelection(et_password_signup.getText().length());
            } else {
                isPasswordShown = true;
                et_password_signup.setInputType(InputType.TYPE_CLASS_TEXT | InputType.TYPE_NULL);
                showPwd.setImageResource(R.drawable.icon_pwd_visible);
                et_password_signup.setSelection(et_password_signup.getText().length());
                 }
            }

    }

    private void onExecuteSignup() {
        email = et_email_signup.getText().toString().replace(" ", "%20");
        password = et_password_signup.getText().toString().replace(" ", "%20");
        username = et_username_signup.getText().toString().replace(" ", "%20");
        mobile = et_mobile_signup.getText().toString().replace(" ", "%20");


        if (username.equalsIgnoreCase("")) {

            YoYo.with(Techniques.Tada).duration(700).playOn(et_username_signup);
            et_username_signup.setError("Username Required");
           // alert.showErrorPopup(SignUp.this, "Error", "Please enter email");
        } else if (email.equalsIgnoreCase("")) {
            YoYo.with(Techniques.Tada).duration(700).playOn(et_email_signup);
            et_email_signup.setError("Email Required");

           // alert.showErrorPopup(SignUp.this, "Error", "Please enter passowrd");
        } else if (password.equalsIgnoreCase("")) {
            YoYo.with(Techniques.Tada).duration(700).playOn(et_password_signup);
            et_password_signup.setError("Password Required");

            //alert.showErrorPopup(SignUp.this, "Error", "Please enter username");
        } else if (mobile.equalsIgnoreCase("")) {
            YoYo.with(Techniques.Tada).duration(700).playOn(et_mobile_signup);
            et_mobile_signup.setError("Mobile number Required");

           // alert.showErrorPopup(SignUp.this, "Error", "Please enter mobile");
        } else {

            txt_signUp_action.setProgress(50);
            txt_signUp.setText("Creating account");
            disableButtons();

            new UploadFileToServer().execute();

        }

    }

    public void disableButtons(){

        tv_bottomText.setEnabled(false);
        et_email_signup.setEnabled(false);
        et_mobile_signup.setEnabled(false);
        et_password_signup.setEnabled(false);
        et_username_signup.setEnabled(false);
        txt_signUp.setEnabled(false);

    }

    public void enableButtons(){

        tv_bottomText.setEnabled(true);
        et_email_signup.setEnabled(true);
        et_mobile_signup.setEnabled(true);
        et_password_signup.setEnabled(true);
        et_username_signup.setEnabled(true);
        txt_signUp.setEnabled(true);

    }

    private void selectImage() {
        final CharSequence[] items = { "Take Photo", "Choose from Library",
                "Cancel" };

        AlertDialog.Builder builder = new AlertDialog.Builder(SignUp.this);
        builder.setTitle("Add Photo!");
        builder.setItems(items, new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int item) {
                if (items[item].equals("Take Photo")) {
                    Intent intent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
                    startActivityForResult(intent, REQUEST_CAMERA);
                } else if (items[item].equals("Choose from Library")) {
                    Intent intent = new Intent(
                            Intent.ACTION_PICK,
                            android.provider.MediaStore.Images.Media.EXTERNAL_CONTENT_URI);
                    intent.setType("image/*");
                    startActivityForResult(
                            Intent.createChooser(intent, "Select File"),
                            SELECT_FILE);
                } else if (items[item].equals("Cancel")) {
                    dialog.dismiss();
                }
            }
        });
        builder.show();
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        if (resultCode == Activity.RESULT_OK) {
            if (requestCode == SELECT_FILE)
                onSelectFromGalleryResult(data);
            else if (requestCode == REQUEST_CAMERA)
                onCaptureImageResult(data);
        }
    }

    private void onCaptureImageResult(Intent data) {
        Bitmap thumbnail = (Bitmap) data.getExtras().get("data");
        ByteArrayOutputStream bytes = new ByteArrayOutputStream();
        thumbnail.compress(Bitmap.CompressFormat.JPEG, 90, bytes);

        File destination = new File(Environment.getExternalStorageDirectory(),
                System.currentTimeMillis() + ".jpg");

        FileOutputStream fo;
        try {
            destination.createNewFile();
            fo = new FileOutputStream(destination);
            fo.write(bytes.toByteArray());
            fo.close();
        } catch (FileNotFoundException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }

        iv_profilePic.setImageBitmap(thumbnail);
        lastBitmap = thumbnail;
        isImageSelected = true;
    }

    private void onSelectFromGalleryResult(Intent data) {
        Uri selectedImageUri = data.getData();
        String[] projection = { MediaStore.MediaColumns.DATA };
        Cursor cursor = managedQuery(selectedImageUri, projection, null, null,
                null);
        int column_index = cursor.getColumnIndexOrThrow(MediaStore.MediaColumns.DATA);
        cursor.moveToFirst();

        String selectedImagePath = cursor.getString(column_index);

        Bitmap bm;
        BitmapFactory.Options options = new BitmapFactory.Options();
        options.inJustDecodeBounds = true;
        BitmapFactory.decodeFile(selectedImagePath, options);
        final int REQUIRED_SIZE = 200;
        int scale = 1;
        while (options.outWidth / scale / 2 >= REQUIRED_SIZE
                && options.outHeight / scale / 2 >= REQUIRED_SIZE)
            scale *= 2;
        options.inSampleSize = scale;
        options.inJustDecodeBounds = false;
        bm = BitmapFactory.decodeFile(selectedImagePath, options);

        iv_profilePic.setImageBitmap(bm);
        lastBitmap = bm;
        isImageSelected = true;

    }

    private Uri getImageUri(Context inContext, Bitmap inImage) {
        ByteArrayOutputStream bytes = new ByteArrayOutputStream();
        inImage.compress(Bitmap.CompressFormat.JPEG, 100, bytes);
        String path = MediaStore.Images.Media.insertImage(inContext.getContentResolver(), inImage, "title", null);
        return Uri.parse(path);
    }

    public String getRealPathFromURI(Uri contentUri){
        try
        {
            String[] proj = {MediaStore.Images.Media.DATA};
            Cursor cursor = managedQuery(contentUri, proj, null, null, null);
            int column_index = cursor.getColumnIndexOrThrow(MediaStore.Images.Media.DATA);
            cursor.moveToFirst();
            return cursor.getString(column_index);
        }
        catch (Exception e)
        {
            return contentUri.getPath();
        }
    }

    private class UploadFileToServer extends AsyncTask<Void, Integer, String> {
        @Override
        protected void onPreExecute() {
            // setting progress bar to zero
          //  progressBar.setProgress(0);
            super.onPreExecute();
        }

        @Override
        protected void onProgressUpdate(Integer... progress) {
            // Making progress bar visible
          //  progressBar.setVisibility(View.VISIBLE);

            // updating progress bar value
           // progressBar.setProgress(progress[0]);

            // updating percentage value
           // txtPercentage.setText(String.valueOf(progress[0]) + "%");
        }

        @Override
        protected String doInBackground(Void... params) {
            return uploadFile();
        }

        @SuppressWarnings("deprecation")
        private String uploadFile() {
            String responseString = null;

            HttpClient httpclient = new DefaultHttpClient();
            HttpPost httppost = new HttpPost(url);

            try {
                AndroidMultiPartEntity entity = new AndroidMultiPartEntity(
                        new AndroidMultiPartEntity.ProgressListener() {

                            @Override
                            public void transferred(long num) {
                              //  publishProgress((int) ((num / (float) totalSize) * 100));
                            }
                        });



                if (isImageSelected){

                    sourceFile = new File(""+getRealPathFromURI(getImageUri(SignUp.this,lastBitmap)));

                    // arg.add(new BasicNameValuePair("do", "login"));
                    entity.addPart("User[email]", new StringBody(email));
                    entity.addPart("User[password]", new StringBody(password));
                    entity.addPart("User[role_id]", new StringBody("2"));
                    entity.addPart("User[mobile]", new StringBody(mobile));
                    entity.addPart("User[full_name]", new StringBody(username));
                    entity.addPart("User[image_file]", new FileBody(sourceFile));
                }

                else if (!isImageSelected){

                    sourceFile = new File("https://www.infrascan.net/demo/assets/img/avatar5.png");

                    entity.addPart("User[email]", new StringBody(email));
                    entity.addPart("User[password]", new StringBody(password));
                    entity.addPart("User[role_id]", new StringBody("2"));
                    entity.addPart("User[mobile]", new StringBody(mobile));
                    entity.addPart("User[full_name]", new StringBody(username));
                    entity.addPart("User[image_file]", new FileBody(sourceFile));

                }

                // Extra parameters if you want to pass to server
            /*    entity.addPart("website",
                        new StringBody("www.androidhive.info"));
                entity.addPart("email", new StringBody("abc@gmail.com"));*/

              //  totalSize = entity.getContentLength();
                        httppost.setEntity(entity);

                // Making server call
                HttpResponse response = httpclient.execute(httppost);
                HttpEntity r_entity = response.getEntity();

                int statusCode = response.getStatusLine().getStatusCode();
                if (statusCode == 200) {
                    // Server response
                    responseString = EntityUtils.toString(r_entity);
                } else {
                    responseString = "Error occurred! Http Status Code: "
                            + statusCode;
                }

            } catch (ClientProtocolException e) {
                responseString = e.toString();
            } catch (IOException e) {
                responseString = e.toString();
            }

            return responseString;

        }

        @Override
        protected void onPostExecute(String result) {
            Log.e("<><", "Response from server: " + result);



            try {
                JSONObject json = new JSONObject(result);
                Log.e("My Complete Data ", " " + json);
                String status = json.getString("status");


                if (status.equals("OK")) {
                    Log.e("- request sent--------", "" + status);
                    enableButtons();

                    txt_signUp_action.setProgress(100);
                    txt_signUp.setText("Success");

                    String success = json.getString("success");

                    SweetAlertDialog pDialog = new SweetAlertDialog(SignUp.this, SweetAlertDialog.SUCCESS_TYPE);
                    pDialog.setCancelable(false);
                    pDialog.setTitleText("Account Created");
                    pDialog.setContentText(success);
                    pDialog.setConfirmText("ok");
                    pDialog.setConfirmClickListener(new SweetAlertDialog.OnSweetClickListener() {
                        @Override
                        public void onClick(SweetAlertDialog sweetAlertDialog) {

                            Intent in = new Intent(SignUp.this, Login.class);
                            startActivity(in);
                            Global.loginSampEmail = et_email_signup.getText().toString();
                            Global.loginSampPwd = et_password_signup.getText().toString();

                            finish();

                            // new UploadFileToServer().execute();

                        }
                    });


                    pDialog.show();


                } else if (status.equals("NOK")) {
                    String error = json.getString("error");
                    txt_signUp_action.setProgress(-1);
                    txt_signUp.setText("Sign Up");
                    enableButtons();

                    Log.e("--Request not sent----",""+ error);
                    alert.showErrorPopup(SignUp.this,"Error",""+error);
                }
            } catch (Exception e) {
                e.printStackTrace();
                txt_signUp_action.setProgress(-1);
                txt_signUp.setText("Sign Up");
                enableButtons();
            }

            super.onPostExecute(result);
        }

    }

}


