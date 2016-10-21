package com.tuffgeekers.traafik;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.content.ContentResolver;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.location.Location;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Environment;
import android.provider.MediaStore;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.widget.Button;
import android.widget.CompoundButton;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.Toast;

import com.dd.processbutton.iml.ActionProcessButton;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.MapFragment;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.CameraPosition;
import com.google.android.gms.maps.model.CircleOptions;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;
import com.tuffgeekers.GPSdata.GPSService;
import com.tuffgeekers.traafik.GeneralUser.Slider;
import com.tuffgeekers.traafik.TrafficManger.SliderManager;
import com.tuffgeekers.utils.AlertMessage;
import com.tuffgeekers.utils.AndroidMultiPartEntity;
import com.tuffgeekers.utils.AutoResizeTextView;
import com.tuffgeekers.utils.Global;
import com.tuffgeekers.utils.SharedPref;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.mime.content.FileBody;
import org.apache.http.entity.mime.content.StringBody;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.util.EntityUtils;
import org.json.JSONObject;

import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;

import cn.pedant.SweetAlert.SweetAlertDialog;
import is.arontibo.library.ElasticDownloadView;

/**
 * Created by hitesh on 2/19/16.
 */
public class GoslowDetails extends Activity implements View.OnClickListener {

    private ImageView iv_goback, btn_sendReport;
    AutoResizeTextView tv_header_goslow, tv_detail_heading, tv_detail_heading_2;
    private LinearLayout ll_take_picture, ll_mySide;
    private Uri imageUri;
    private static final int TAKE_PICTURE = 1;
    private EditText et_detail_traffic;
    int REQUEST_CAMERA = 0, SELECT_FILE = 1;
    Bitmap lastBitmap ;
    boolean isImageSelected = false;
    int reportID ;
    int reportCauseID ;
    double latitude, longitude;
    double changelatitude, changelongitude;
    File sourceFile;
    AutoResizeTextView tv_sideText ;
    int side=0;
    long totalSize = 0;
    ActionProcessButton ac_loading;
    GoogleMap googleMap;
    Dialog dialogConfirm;
    ImageView iv_preview;
    boolean isInside = true;



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_goslow);

        initializeViews();
        SharedPref.get_UserId(GoslowDetails.this);
        iv_goback.setOnClickListener(this);
        ll_take_picture.setOnClickListener(this);
        ll_mySide.setOnClickListener(this);
        btn_sendReport.setOnClickListener(this);


        if (SliderManager.flag_rightDrawer == 1|| Slider.flag_rightDrawer == 1) {

            showGoSlowpopUp();
            reportID=1;


        } else if (SliderManager.flag_rightDrawer == 2||Slider.flag_rightDrawer == 2) {

            showPolicepopUp();
            tv_header_goslow.setText("Pothole");
            reportID=2;

        } else if (SliderManager.flag_rightDrawer == 3||Slider.flag_rightDrawer == 3) {
            showAccidentpopUp();
            tv_header_goslow.setText("Accident");
            reportID=3;
        } else if (SliderManager.flag_rightDrawer == 4||Slider.flag_rightDrawer == 4) {
            showHazardpopUp();
            tv_header_goslow.setText("Hazard");
            reportID=4;
        } else if (SliderManager.flag_rightDrawer == 5||Slider.flag_rightDrawer == 5) {

            tv_header_goslow.setText("Map Chat");
            tv_detail_heading_2.setVisibility(View.VISIBLE);
            tv_detail_heading.setVisibility(View.GONE);

        }

        else if (SliderManager.flag_rightDrawer == 6||Slider.flag_rightDrawer == 6) {

            tv_header_goslow.setText("Place");
            tv_detail_heading_2.setVisibility(View.VISIBLE);
            tv_detail_heading.setVisibility(View.GONE);
            reportID=5;
        }

        else if (SliderManager.flag_rightDrawer == 7||Slider.flag_rightDrawer == 7) {

            tv_header_goslow.setText("Road Closed");
            reportID=6;
        }

        else if (SliderManager.flag_rightDrawer == 8||Slider.flag_rightDrawer == 8) {

            tv_header_goslow.setText("CheckIn");
            reportID=7;
        }

        else if (SliderManager.flag_rightDrawer == 9||Slider.flag_rightDrawer == 9) {

        }

    }

    @Override
    public void onBackPressed() {

        finish();
    }

    private void initializeViews() {

        tv_header_goslow = (AutoResizeTextView) findViewById(R.id.tv_header_goslow);
        tv_detail_heading = (AutoResizeTextView) findViewById(R.id.tv_detail_heading);
        tv_detail_heading_2 = (AutoResizeTextView) findViewById(R.id.tv_detail_heading_2);
        tv_sideText = (AutoResizeTextView)findViewById(R.id.tv_sideText);

        ll_take_picture = (LinearLayout) findViewById(R.id.ll_take_picture);
        ll_mySide = (LinearLayout) findViewById(R.id.ll_mySide);

        et_detail_traffic = (EditText) findViewById(R.id.et_detail_traffic);

        ac_loading = (ActionProcessButton)findViewById(R.id.ac_loading);

        btn_sendReport = (ImageView)findViewById(R.id.btn_sendReport);
        iv_goback = (ImageView) findViewById(R.id.iv_goback);
        iv_preview = (ImageView)findViewById(R.id.iv_preview);

    }

    private void showGoSlowpopUp() {
        final Dialog dialog = new Dialog(GoslowDetails.this);
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog.getWindow().setBackgroundDrawable(new ColorDrawable(android.graphics.Color.TRANSPARENT));
        dialog.setCancelable(false);
        dialog.setContentView(R.layout.activity_goslow_popup);
//Radio buttons click listener


        final com.rey.material.widget.RadioButton Moderate = (com.rey.material.widget.RadioButton)dialog.findViewById(R.id.Moderate);
        final com.rey.material.widget.RadioButton Heavy = (com.rey.material.widget.RadioButton)dialog.findViewById(R.id.Heavy);
        final com.rey.material.widget.RadioButton StandStill = (com.rey.material.widget.RadioButton)dialog.findViewById(R.id.StandStill);
        final Button selectGoSlow = (Button)dialog.findViewById(R.id.selectGoSlow);


        Moderate.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Moderate.setChecked(true);
                Heavy.setChecked(false);
                StandStill.setChecked(false);
                selectGoSlow.setText("          Continue          ");
                reportCauseID = 1;
            }
        });

        Heavy.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Moderate.setChecked(false);
                Heavy.setChecked(true);
                StandStill.setChecked(false);
                selectGoSlow.setText("          Continue          ");
                reportCauseID = 2;
            }
        });

        StandStill.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Moderate.setChecked(false);
                Heavy.setChecked(false);
                StandStill.setChecked(true);
                selectGoSlow.setText("          Continue          ");
                reportCauseID = 3;
            }
        });

        selectGoSlow.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                if (!Moderate.isChecked()&&!Heavy.isChecked()&&!StandStill.isChecked()){

                    Toast.makeText(GoslowDetails.this, "Please select an option", Toast.LENGTH_SHORT).show();
                }

                else {
                    dialog.dismiss();
                }

            }
        });

        dialog.show();


    }

    private void showPolicepopUp() {
        final Dialog dialog = new Dialog(GoslowDetails.this);
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog.getWindow().setBackgroundDrawable(new ColorDrawable(android.graphics.Color.TRANSPARENT));
        dialog.setCancelable(false);
        dialog.setContentView(R.layout.activity_police_popup);

        final com.rey.material.widget.RadioButton hidden = (com.rey.material.widget.RadioButton)dialog.findViewById(R.id.hidden);
        final com.rey.material.widget.RadioButton visible = (com.rey.material.widget.RadioButton)dialog.findViewById(R.id.visible);
        final Button selectPolice = (Button)dialog.findViewById(R.id.selectPolice);

        hidden.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                hidden.setChecked(true);
                visible.setChecked(false);
                selectPolice.setText("          Continue          ");
                reportCauseID = 4;
            }
        });

        visible.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                visible.setChecked(true);
                hidden.setChecked(false);
                selectPolice.setText("          Continue          ");
                reportCauseID = 5;
            }
        });

        selectPolice.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                if (!visible.isChecked()&&!hidden.isChecked()){
                    Toast.makeText(GoslowDetails.this, "Please select an option", Toast.LENGTH_SHORT).show();
                }

                else {
                    dialog.dismiss();
                }

            }
        });


        dialog.show();
    }

    private void showAccidentpopUp() {
        final Dialog dialog = new Dialog(GoslowDetails.this);
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog.getWindow().setBackgroundDrawable(new ColorDrawable(android.graphics.Color.TRANSPARENT));
        dialog.setCancelable(false);
        dialog.setContentView(R.layout.activity_accident_popup);

        final com.rey.material.widget.RadioButton Minor = (com.rey.material.widget.RadioButton)dialog.findViewById(R.id.Minor);
        final com.rey.material.widget.RadioButton Major = (com.rey.material.widget.RadioButton)dialog.findViewById(R.id.Major);
        final Button selectAccident = (Button)dialog.findViewById(R.id.selectAccident);

        Minor.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Minor.setChecked(true);
                Major.setChecked(false);
                selectAccident.setText("          Continue          ");
                reportCauseID = 6;

            }
        });

        Major.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Minor.setChecked(false);
                Major.setChecked(true);
                selectAccident.setText("          Continue          ");
                reportCauseID = 7;

            }
        });

        selectAccident.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                if (!Minor.isChecked()&&!Major.isChecked()){
                    Toast.makeText(GoslowDetails.this, "Please select an option", Toast.LENGTH_SHORT).show();
                }

                else {
                    dialog.dismiss();
                }

            }
        });

        dialog.show();
    }

    private void showHazardpopUp() {
        final Dialog dialog = new Dialog(GoslowDetails.this);
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog.getWindow().setBackgroundDrawable(new ColorDrawable(android.graphics.Color.TRANSPARENT));
        dialog.setCancelable(false);
        dialog.setContentView(R.layout.activity_hazard_popup);

        final com.rey.material.widget.RadioButton OnRoad = (com.rey.material.widget.RadioButton)dialog.findViewById(R.id.OnRoad);
        final com.rey.material.widget.RadioButton OffRoad = (com.rey.material.widget.RadioButton)dialog.findViewById(R.id.OffRoad);
        final com.rey.material.widget.RadioButton Weather = (com.rey.material.widget.RadioButton)dialog.findViewById(R.id.Weather);
        final Button selectHazard = (Button)dialog.findViewById(R.id.selectHazard);

        OnRoad.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                OnRoad.setChecked(true);
                OffRoad.setChecked(false);
                Weather.setChecked(false);
                selectHazard.setText("          Continue          ");
                reportCauseID = 8;

            }
        });

        OffRoad.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                OnRoad.setChecked(false);
                OffRoad.setChecked(true);
                Weather.setChecked(false);
                selectHazard.setText("          Continue          ");
                reportCauseID = 9;

            }
        });

        Weather.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                OnRoad.setChecked(false);
                OffRoad.setChecked(false);
                Weather.setChecked(true);
                selectHazard.setText("          Continue          ");
                reportCauseID = 10;

            }
        });

        selectHazard.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                if (!OnRoad.isChecked()&&!OffRoad.isChecked()&&!Weather.isChecked()){

                    Toast.makeText(GoslowDetails.this, "Please select an option", Toast.LENGTH_SHORT).show();
                }

                else {
                    dialog.dismiss();
                }

            }
        });

        dialog.show();
    }

    @Override
    public void onClick(View v) {
        switch (v.getId()) {
            case R.id.iv_goback:
                finish();
                break;
            case R.id.ll_take_picture:
                selectImage();
                break;

            case R.id.ll_mySide:
                openDialog();
                break;

            case R.id.btn_later:
                break;

            case R.id.btn_sendReport:
                getLocation();
               confirmLocation();
                break;
        }
    }

    private void onSendReport() {



        String detailTraffic = et_detail_traffic.getText().toString().trim();
        Log.e("UserID", "" + Global.userId);
        Log.e("latitude", "" + latitude);
        Log.e("longitude", "" + longitude);


        if (detailTraffic.equalsIgnoreCase("")){

            Toast.makeText(GoslowDetails.this, "Please add a short detail", Toast.LENGTH_SHORT).show();
        }

        else if (!isImageSelected){


          final SweetAlertDialog pDialog = new SweetAlertDialog(this, SweetAlertDialog.WARNING_TYPE);
            pDialog.setCancelable(false);
            pDialog.setTitleText("No Image selected");
            pDialog.setContentText("Are you sure you want to continue without an image?");
            pDialog.setConfirmText("ok");
            pDialog.setConfirmClickListener(new SweetAlertDialog.OnSweetClickListener() {
                @Override
                public void onClick(SweetAlertDialog sweetAlertDialog) {


                    new UploadFileToServer().execute();
                    pDialog.cancel();


                }
            });
            pDialog.setCancelText("cancel");
            pDialog.setCancelClickListener(new SweetAlertDialog.OnSweetClickListener() {
                @Override
                public void onClick(SweetAlertDialog sweetAlertDialog) {

                    pDialog.cancel();

                }
            });


            pDialog.show();


        }

        else {

            new UploadFileToServer().execute();
        }

    }

    private void getLocation() {
        // TODO Auto-generated method stub


        String address = "";
        GPSService mGPSService = new GPSService(GoslowDetails.this);
        mGPSService.getLocation();

        if (mGPSService.isLocationAvailable == false) {

            // Here you can ask the user to try again, using return; for that
            Toast.makeText(GoslowDetails.this, "Your location is not available, please try again.", Toast.LENGTH_SHORT).show();
            return;

            // Or you can continue without getting the location, remove the return; above and uncomment the line given below
            // address = "Location not available";


        } else {

            // Getting location co-ordinates
            latitude = mGPSService.getLatitude();
            longitude = mGPSService.getLongitude();
            //	Toast.makeText(AddLocation.this, "Latitude:" + latitude + " | Longitude: " + longitude, Toast.LENGTH_LONG).show();
//Storing current lat/long in sharedPref

            Global.latitude = "" + latitude;
            Global.longitude = "" + longitude;
            address = mGPSService.getLocationAddress();

            changelongitude = longitude;
            changelatitude = latitude;

            //tvLocation.setText("Latitude: " + latitude + " \nLongitude: " + longitude);
            //	tvAddress.setText("Address: " + address);

            Log.e("location", "Latitude: " + latitude + " Longitude: " + longitude);
            Log.e("address", address);

            //showAlertDialog(AddLocation.this, "Address", ""+address);

            String[] separated = address.split("@@##@@");
            String St_line = separated[0];


            Log.e("St_line", St_line);

            if (St_line.contains("IO Exception trying to get address")) {

                recreate();
            }


        }

        // make sure you close the gps after using it. Save user's battery power
        mGPSService.closeGPS();

    }

    private void openDialog() {
        final Dialog dialog = new Dialog(GoslowDetails.this);
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog.getWindow().setBackgroundDrawable(new ColorDrawable(android.graphics.Color.TRANSPARENT));
        dialog.setContentView(R.layout.activity_side_popup);


        final com.rey.material.widget.RadioButton myside = (com.rey.material.widget.RadioButton)dialog.findViewById(R.id.myside);
        final com.rey.material.widget.RadioButton otherSide = (com.rey.material.widget.RadioButton)dialog.findViewById(R.id.otherSide);

        myside.setChecked(true);

        myside.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                tv_sideText.setText("My side");
                myside.setChecked(true);
                otherSide.setChecked(false);
                dialog.dismiss();
                side=0;

            }
        });


        otherSide.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                tv_sideText.setText("Other side");
                myside.setChecked(false);
                otherSide.setChecked(true);
                dialog.dismiss();
                side=1;

            }
        });



        dialog.show();
    }

    private void selectImage() {
        final CharSequence[] items = { "Take Photo", "Choose from Library",
                "Cancel" };

        AlertDialog.Builder builder = new AlertDialog.Builder(GoslowDetails.this);
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

        iv_preview.setImageBitmap(thumbnail);
        lastBitmap = thumbnail;
        isImageSelected = true;
    }

    @SuppressWarnings("deprecation")
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

        iv_preview.setImageBitmap(bm);
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
          //  proGress_show.setProgress(0);
            ac_loading.setVisibility(View.VISIBLE);
            ac_loading.setProgress(50);
            disableButtons();
            super.onPreExecute();
        }

        @Override
        protected void onProgressUpdate(Integer... progress) {
            // Making progress bar visible
         /*   proGress_show.setVisibility(View.VISIBLE);

            // updating progress bar value
            proGress_show.setProgress(progress[0]);

            // updating percentage value
            tv_percentage.setText(String.valueOf(progress[0]) + "%");*/
        }

        @Override
        protected String doInBackground(Void... params) {
            return uploadFile();
        }

        @SuppressWarnings("deprecation")
        private String uploadFile() {
            String responseString = null;

            HttpClient httpclient = new DefaultHttpClient();
            HttpPost httppost = new HttpPost("http://tuffgeekers.com/demo/AppTraafik/api/post/create");
            httppost.addHeader("auth_code", SharedPref.get_LogAuth(GoslowDetails.this));
            Log.e("<><", ""+SharedPref.get_LogAuth(GoslowDetails.this));

            try {
                AndroidMultiPartEntity entity = new AndroidMultiPartEntity(
                        new AndroidMultiPartEntity.ProgressListener() {

                            @Override
                            public void transferred(long num) {
                                  publishProgress((int) ((num / (float) totalSize) * 100));
                            }
                        });


                if (isImageSelected){

                    sourceFile = new File(""+getRealPathFromURI(getImageUri(GoslowDetails.this,lastBitmap)));

                    // arg.add(new BasicNameValuePair("do", "login"));
                    entity.addPart("Post[report_id]", new StringBody(""+reportID));
                    entity.addPart("Post[report_cause_id]", new StringBody(""+reportCauseID));
                    entity.addPart("Post[side_id]", new StringBody(""+side));
                    entity.addPart("Post[content]", new StringBody(""+et_detail_traffic.getText().toString().trim()));
                    entity.addPart("Post[latitude]", new StringBody(""+changelatitude));
                    entity.addPart("Post[longitude]", new StringBody(""+changelongitude));
                    entity.addPart("Post[type_id]", new StringBody("1"));
                    entity.addPart("Post[file_path]", new FileBody(sourceFile));
                    entity.addPart("Post[create_user_id]", new StringBody(""+SharedPref.get_UserId(GoslowDetails.this)));


                }

                else if (!isImageSelected){

                    entity.addPart("Post[report_id]", new StringBody(""+reportID));
                    entity.addPart("Post[report_cause_id]", new StringBody(""+reportCauseID));
                    entity.addPart("Post[side_id]", new StringBody(""+side));
                    entity.addPart("Post[content]", new StringBody(""+et_detail_traffic.getText().toString().trim()));
                    entity.addPart("Post[latitude]", new StringBody(""+changelatitude));
                    entity.addPart("Post[longitude]", new StringBody(""+changelongitude));
                    entity.addPart("Post[create_user_id]", new StringBody(""+SharedPref.get_UserId(GoslowDetails.this)));

                }


                  totalSize = entity.getContentLength();
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

                    ac_loading.setVisibility(View.VISIBLE);
                    ac_loading.setProgress(100);


                    SweetAlertDialog pDialog = new SweetAlertDialog(GoslowDetails.this, SweetAlertDialog.SUCCESS_TYPE);
                    pDialog.setCancelable(false);
                    pDialog.setTitleText("Post Updated");
                    pDialog.setContentText("The report has been sent successfully.");
                    pDialog.setConfirmText("ok");
                    pDialog.setConfirmClickListener(new SweetAlertDialog.OnSweetClickListener() {
                        @Override
                        public void onClick(SweetAlertDialog sweetAlertDialog) {


                            finish();

                            // new UploadFileToServer().execute();

                        }
                    });


                    pDialog.show();


                } else if (status.equals("NOK")) {
                    enableButtons();

                    AlertMessage alert = new AlertMessage();
                    alert.showErrorPopup(GoslowDetails.this,"Error", "Please try again later");
                }
            } catch (Exception e) {
                e.printStackTrace();
                ac_loading.setVisibility(View.INVISIBLE);
                ac_loading.setProgress(50);
                enableButtons();
            }

            super.onPostExecute(result);
        }

    }

    public void disableButtons(){

        btn_sendReport.setEnabled(false);
        ll_mySide.setEnabled(false);
        ll_take_picture.setEnabled(false);
        et_detail_traffic.setEnabled(false);
        iv_goback.setEnabled(false);

    }

    public void enableButtons(){

        btn_sendReport.setEnabled(true);
        ll_mySide.setEnabled(true);
        ll_take_picture.setEnabled(true);
        et_detail_traffic.setEnabled(true);
        iv_goback.setEnabled(true);

    }

    public void confirmLocation(){

        dialogConfirm = new Dialog(GoslowDetails.this);
        dialogConfirm.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialogConfirm.getWindow().setBackgroundDrawable(new ColorDrawable(android.graphics.Color.TRANSPARENT));
        dialogConfirm.setCancelable(false);
        dialogConfirm.setContentView(R.layout.goslow_map_popup);

        Button btn_confirm = (Button)dialogConfirm.findViewById(R.id.btn_confirm);

        // condition of Geo fence to upload
        if (SharedPref.get_LoggedAccess(GoslowDetails.this).equalsIgnoreCase("user")){

            try {
                if (googleMap == null) {
                    googleMap = ((MapFragment)getFragmentManager().findFragmentById(R.id.map_confirm)).getMap();
                    Log.e("latlong", "Lat " + latitude + " long " + longitude);

                    // create marker
                    final LatLng location = new LatLng(latitude, longitude);

                    final CircleOptions options = new CircleOptions();
                    options.center( location );
                    //Radius in meters
                    options.radius( 100 );
                    options.fillColor(Color.parseColor("#74BFBB"));
                    options.strokeColor(Color.parseColor("#15C1BD"));
                    options.strokeWidth( 10 );
                    googleMap.addCircle(options);


                    googleMap.setOnCameraChangeListener(new GoogleMap.OnCameraChangeListener() {
                        @Override
                        public void onCameraChange(CameraPosition cameraPosition) {
                            LatLng newPositon = cameraPosition.target;

                            changelongitude = newPositon.longitude;
                            changelatitude = newPositon.latitude;

                            Log.e("new position", ""+changelatitude+" "+changelongitude);

                            float[] distance = new float[2];

                            Location.distanceBetween(location.latitude,
                                    location.longitude, options.getCenter().latitude,
                                    options.getCenter().longitude, distance);

                            if (distance[0] > options.getRadius()) {
                                //Do what you need
                                Toast.makeText(getBaseContext(), "Outside", Toast.LENGTH_LONG).show();
                                isInside =false;

                            }else if (distance[0] < options.getRadius()) {
                                Toast.makeText(getBaseContext(), "Inside", Toast.LENGTH_LONG).show();
                                isInside =true;
//Do what you need
                            }
                        }
                    });


                    CameraPosition cameraPosition = new CameraPosition.Builder().target(
                            new LatLng(changelatitude, changelongitude)).zoom(15.0F)
                            .bearing(300F) // orientation
                            .tilt(30F) // viewing angle
                            .build();

                    googleMap.animateCamera(CameraUpdateFactory.newCameraPosition(cameraPosition));




                    // check if map is created successfully or not
                    if (googleMap == null) {
                        Toast.makeText(getApplicationContext(),
                                "Sorry! unable to create maps", Toast.LENGTH_SHORT)
                                .show();
                    }
                }
            } catch (Exception e) {
                e.printStackTrace();
            }


            btn_confirm.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    
                    if (isInside){

                        dialogConfirm.dismiss();
                        onSendReport();
                        
                    }

                    else {

                        Toast.makeText(GoslowDetails.this, "You can mark reports of nearby loactions only.", Toast.LENGTH_SHORT).show();
                    }
                  


                }
            });




        }

        // no conditon of geofence to upload
        else {

            try {
                if (googleMap == null) {
                    googleMap = ((MapFragment)getFragmentManager().findFragmentById(R.id.map_confirm)).getMap();
                    Log.e("latlong", "Lat " + latitude + " long " + longitude);

                    // create marker


                    googleMap.setOnCameraChangeListener(new GoogleMap.OnCameraChangeListener() {
                        @Override
                        public void onCameraChange(CameraPosition cameraPosition) {
                            LatLng newPositon = cameraPosition.target;

                            changelongitude = newPositon.longitude;
                            changelatitude = newPositon.latitude;

                            Log.e("new position", ""+changelatitude+" "+changelongitude);
                        }
                    });


                    CameraPosition cameraPosition = new CameraPosition.Builder().target(
                            new LatLng(changelatitude, changelongitude)).zoom(15.0F)
                            .bearing(300F) // orientation
                            .tilt(30F) // viewing angle
                            .build();

                    googleMap.animateCamera(CameraUpdateFactory.newCameraPosition(cameraPosition));




                    // check if map is created successfully or not
                    if (googleMap == null) {
                        Toast.makeText(getApplicationContext(),
                                "Sorry! unable to create maps", Toast.LENGTH_SHORT)
                                .show();
                    }
                }
            } catch (Exception e) {
                e.printStackTrace();
            }



            btn_confirm.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {

                    dialogConfirm.dismiss();
                    onSendReport();


                }
            });

        }

        dialogConfirm.show();

    }


}
