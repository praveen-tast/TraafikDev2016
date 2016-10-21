package com.tuffgeekers.traafik.TrafficManger;

import android.app.Activity;
import android.app.ActivityManager;
import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.ComponentName;
import android.content.ContentResolver;
import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.graphics.drawable.Drawable;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Environment;
import android.os.Handler;
import android.os.StrictMode;
import android.provider.MediaStore;
import android.os.Bundle;
import android.support.v4.content.ContextCompat;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.getbase.floatingactionbutton.FloatingActionButton;
import com.getbase.floatingactionbutton.FloatingActionsMenu;
import com.google.android.gms.appindexing.Action;
import com.google.android.gms.appindexing.AppIndex;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.MapFragment;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.CameraPosition;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;
import com.nightonke.boommenu.BoomMenuButton;
import com.nightonke.boommenu.Types.BoomType;
import com.nightonke.boommenu.Types.ButtonType;
import com.nightonke.boommenu.Types.DimType;
import com.nightonke.boommenu.Types.PlaceType;
import com.nightonke.boommenu.Util;
import com.rey.material.widget.CheckBox;
import com.tuffgeekers.Adapter.MyMarker;
import com.tuffgeekers.GPSdata.GPSService;
import com.tuffgeekers.GoogleClasses.DownloadTask;
import com.tuffgeekers.GoogleClasses.GooglePlacesAutocompleteAdapter;
import com.tuffgeekers.GoogleClasses.PrintingPath;
import com.tuffgeekers.jsonfiles.MainAsynListener;
import com.tuffgeekers.jsonfiles.MainAsyncTask;
import com.tuffgeekers.traafik.DetailedViewLocation;
import com.tuffgeekers.traafik.GeneralUser.Home;
import com.tuffgeekers.traafik.Login;
import com.tuffgeekers.traafik.R;
import com.tuffgeekers.traafik.Uploadfile;
import com.tuffgeekers.utils.AlertMessage;
import com.tuffgeekers.utils.AutoResizeTextView;
import com.tuffgeekers.utils.Global;
import com.tuffgeekers.utils.MyService;
import com.tuffgeekers.utils.SharedPref;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.File;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Random;

import cn.pedant.SweetAlert.SweetAlertDialog;

public class HomeManager extends SliderManager implements View.OnClickListener, MainAsynListener<String>,
        BoomMenuButton.OnSubButtonClickListener,
        BoomMenuButton.AnimatorListener {

    private Spinner spinner1, spinner2, spinner3;
    private String[] Report = {"Go Slow", "Police", "Accident", "Hazard", "Place", "Road Closed", "Check In"};
    private String goslow[] = {"Moderate", "heavy", "Stand Still"};
    private String police[] = {"Hidden", "Visible"};
    private String accident[] = {"Minor", "Major"};
    private String hazard[] = {"On Road", "Road Side", "Weather"};
    private String side[] = {"My side", "other side"};
    private static final int TAKE_PICTURE = 1;
    private AutoResizeTextView tv_pic_proceed;
    private Uri imageUri;

    private GoogleMap googleMap;
    private double latitude, longitude;
    private ImageView side_menu_manager, report_menu_manager, map_icon_manager;
    private LinearLayout ll_main_home_manager;
    private double changingLat, changingLng;
    private FloatingActionsMenu multiple_actions;
    private FloatingActionButton action_addLocation, action_Filter, action_navigate, action_refresh;
    private Dialog dialog_addLocationPop;
    private MarkerOptions markerME, markerNavigateTo;
    private PrintingPath printPath = new PrintingPath();
    private String fetlatitude, fetlongitude;
    int apiHit = 0;
    String checkCondition = "both";
    private StringBuilder sb;
    private ArrayList<MyMarker> mMyMarkersArray = new ArrayList<MyMarker>();
    private HashMap<Marker, MyMarker> mMarkersHashMap;
    View viewMarker;
    String ShareFor;

    BoomMenuButton boomMenuButton;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_home_manager);


        StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder()
                .permitAll().build();
        StrictMode.setThreadPolicy(policy);

        Global.auth = SharedPref.get_LogAuth(HomeManager.this);
        Global.userId = SharedPref.get_UserId(HomeManager.this);

        initializeViews();
        boomMenuButton = (BoomMenuButton)findViewById(R.id.boom);
        initBoom();



        boomMenuButton.setOnSubButtonClickListener(this);
        boomMenuButton.setAnimatorListener(this);
        boomMenuButton.setDimType(DimType.DIM_0);

        Intent service = new Intent(getApplicationContext(), MyService.class);
        getApplicationContext().startService(service);

        //setTypeface();
        getLocation();

        try {
            initilizeMap();
        } catch (Exception e) {
            e.printStackTrace();
        }
        getAllPosts();


        multiple_actions.setOnFloatingActionsMenuUpdateListener(new FloatingActionsMenu.OnFloatingActionsMenuUpdateListener() {
            @Override
            public void onMenuExpanded() {

                action_addLocation.setVisibility(View.VISIBLE);
                action_Filter.setVisibility(View.VISIBLE);
                action_navigate.setVisibility(View.VISIBLE);
                action_refresh.setVisibility(View.VISIBLE);
            }

            @Override
            public void onMenuCollapsed() {

                action_addLocation.setVisibility(View.GONE);
                action_Filter.setVisibility(View.GONE);
                action_navigate.setVisibility(View.GONE);
                action_refresh.setVisibility(View.GONE);

            }
        });
        multiple_actions.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                multiple_actions.expand();
            }
        });

        action_Filter.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                multiple_actions.collapse();
                showCustomViewDialog();

            }
        });

        action_addLocation.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                multiple_actions.collapse();
                // addLocationPopup();
                drawer_right.toggleRightDrawer();

            }
        });

        action_navigate.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                multiple_actions.collapse();
                showNavigatePopUp();
            }
        });

        action_refresh.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                recreate();
            }
        });


        side_menu_manager.setOnClickListener(this);
        report_menu_manager.setOnClickListener(this);
        ll_navigate.setOnClickListener(this);
        ll_logout.setOnClickListener(this);
        ll_share_location.setOnClickListener(this);

        //     getAllTraafic();
    }

    private void getAllPosts() {

        //new AsynData().execute();
        apiHit = 1;
        new MainAsyncTask(HomeManager.this, Global.BaseUrl + "post/allPosts", 100, HomeManager.this, Global.json, true).execute();


    }

    public void getUserPosts() {
        apiHit = 2;


        new MainAsyncTask(HomeManager.this, Global.BaseUrl + "post/postsByRole/role/2", 100, HomeManager.this, Global.json, true).execute();
    }

    public void getManagerPosts() {
        apiHit = 3;

        //  http://tuffgeekers.com/demo/AppTraafik/api/post/postsByRole/role/{role_id}
        new MainAsyncTask(HomeManager.this, Global.BaseUrl + "post/postsByRole/role/1", 100, HomeManager.this, Global.json, true).execute();
    }

    @Override
    public void onBackPressed() {
       /* Intent in = new Intent(Home.this, Login.class);
        startActivity(in);
        finish();*/
        final SweetAlertDialog pDialog = new SweetAlertDialog(this, SweetAlertDialog.SUCCESS_TYPE);
        pDialog.setCancelable(true);
        pDialog.setTitleText("Logged Out");
        pDialog.setContentText("Are you sure you want to logout?");
        pDialog.setConfirmText("ok");
        pDialog.setConfirmClickListener(new SweetAlertDialog.OnSweetClickListener() {
            @Override
            public void onClick(SweetAlertDialog sweetAlertDialog) {


                new LogoutLoad().execute();


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

    private void initializeViews() {
        side_menu_manager = (ImageView) findViewById(R.id.side_menu_manager);
        report_menu_manager = (ImageView) findViewById(R.id.report_menu_manager);
        map_icon_manager = (ImageView) findViewById(R.id.map_icon_manager);

        ll_main_home_manager = (LinearLayout) findViewById(R.id.ll_main_home_manager);

        multiple_actions = (FloatingActionsMenu) findViewById(R.id.multiple_actions);
        action_addLocation = (FloatingActionButton) findViewById(R.id.action_addLocation);
        action_Filter = (FloatingActionButton) findViewById(R.id.action_Filter);
        action_navigate = (FloatingActionButton) findViewById(R.id.action_navigate);
        action_refresh = (FloatingActionButton) findViewById(R.id.action_refresh);
        mMarkersHashMap = new HashMap<Marker, MyMarker>();


    }

    private void initilizeMap() {
        if (googleMap == null) {
            googleMap = ((MapFragment) getFragmentManager().findFragmentById(
                    R.id.map_home_manager)).getMap();
            Log.e("latlong", "Lat " + latitude + " long " + longitude);

            // create marker

            markerME = new MarkerOptions().position(new LatLng(latitude, longitude)).title("You are here");
            markerME.icon(BitmapDescriptorFactory
                    .defaultMarker(BitmapDescriptorFactory.HUE_ROSE));
            // adding marker
            //   googleMap.addMarker(markerME);
            CameraPosition cameraPosition = new CameraPosition.Builder().target(
                    new LatLng(latitude, longitude)).zoom(15.0F)
                    .bearing(300F) // orientation
                    .tilt(30F) // viewing angle
                    .build();

            googleMap.animateCamera(CameraUpdateFactory.newCameraPosition(cameraPosition));

             googleMap.setMyLocationEnabled(true);

            googleMap.setOnCameraChangeListener(new GoogleMap.OnCameraChangeListener() {
                @Override
                public void onCameraChange(CameraPosition cameraPosition) {


                    map_icon_manager.setVisibility(View.GONE);

                }
            });




           /* googleMap.setOnCameraChangeListener(new GoogleMap.OnCameraChangeListener() {
                @Override
                public void onCameraChange(CameraPosition cameraPosition) {

                    LatLng changingLatLng = cameraPosition.target;

                    changingLat = changingLatLng.latitude;
                    changingLng = changingLatLng.longitude;
                    Log.e("<><><><changing", ""+changingLat+" "+changingLng);

                }
            });*/


            // check if map is created successfully or not
            if (googleMap == null) {
                Toast.makeText(getApplicationContext(),
                        "Sorry! unable to create maps", Toast.LENGTH_SHORT)
                        .show();
            }
        }
    }

    private void getLocation() {
        // TODO Auto-generated method stub


        String address = "";
        GPSService mGPSService = new GPSService(HomeManager.this);
        mGPSService.getLocation();

        if (mGPSService.isLocationAvailable == false) {

            // Here you can ask the user to try again, using return; for that
            Toast.makeText(HomeManager.this, "Your location is not available, please try again.", Toast.LENGTH_SHORT).show();
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

            //tvLocation.setText("Latitude: " + latitude + " \nLongitude: " + longitude);
            //	tvAddress.setText("Address: " + address);

            Log.e("location", "Latitude: " + latitude + " \nLongitude: " + longitude);
            Log.e("address", address);

            //showAlertDialog(AddLocation.this, "Address", ""+address);

            String[] separated = address.split("@@##@@");
            String St_line = separated[0];


            Log.e("St_line", St_line);


        }

        // make sure you close the gps after using it. Save user's battery power
        mGPSService.closeGPS();

    }


    private void showCustomViewDialog() {


        final Dialog dialog = new Dialog(HomeManager.this);
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog.getWindow().setBackgroundDrawable(new ColorDrawable(Color.TRANSPARENT));
        dialog.setContentView(R.layout.inputview);

        final CheckBox reportFrom_user = (CheckBox) dialog.findViewById(R.id.reportFrom_user);
        final CheckBox reportFrom_managers = (CheckBox) dialog.findViewById(R.id.reportFrom_managers);
        final CheckBox reportFrom_both = (CheckBox) dialog.findViewById(R.id.reportFrom_both);

        if (checkCondition.equalsIgnoreCase("both")) {
            reportFrom_both.setChecked(true);
            reportFrom_user.setChecked(false);
            reportFrom_managers.setChecked(false);

        } else if (checkCondition.equalsIgnoreCase("user")) {
            reportFrom_both.setChecked(false);
            reportFrom_user.setChecked(true);
            reportFrom_managers.setChecked(false);

        } else if (checkCondition.equalsIgnoreCase("manager")) {
            reportFrom_both.setChecked(false);
            reportFrom_user.setChecked(false);
            reportFrom_managers.setChecked(true);

        }


        reportFrom_both.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                reportFrom_both.setChecked(true);
                reportFrom_user.setChecked(false);
                reportFrom_managers.setChecked(false);

                checkCondition = "both";

                googleMap.clear();
                googleMap.addMarker(markerME);
                getAllPosts();

            }
        });

        reportFrom_user.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                reportFrom_both.setChecked(false);
                reportFrom_user.setChecked(true);
                reportFrom_managers.setChecked(false);
                checkCondition = "user";
                googleMap.clear();
                googleMap.addMarker(markerME);
                getUserPosts();

            }
        });

        reportFrom_managers.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                reportFrom_both.setChecked(false);
                reportFrom_user.setChecked(false);
                reportFrom_managers.setChecked(true);
                checkCondition = "manager";
                googleMap.clear();
                googleMap.addMarker(markerME);
                getManagerPosts();

            }
        });

        dialog.show();


    }


    public void addLocationPopup() {

        dialog_addLocationPop = new Dialog(this);
        dialog_addLocationPop.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog_addLocationPop.getWindow().setBackgroundDrawable(new ColorDrawable(Color.TRANSPARENT));
        dialog_addLocationPop.setContentView(R.layout.activity_addpopup);


        spinner1 = (Spinner) dialog_addLocationPop.findViewById(R.id.spinner1);
        spinner2 = (Spinner) dialog_addLocationPop.findViewById(R.id.spinner2);
        spinner3 = (Spinner) dialog_addLocationPop.findViewById(R.id.spinner3);
        tv_pic_proceed = (AutoResizeTextView) dialog_addLocationPop.findViewById(R.id.tv_pic_proceed);
        tv_pic_proceed.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                openCamera();
            }

            private void openCamera() {
                Intent intent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
                File photo = new File(Environment.getExternalStorageDirectory(), "Pic.jpg");
                intent.putExtra(MediaStore.EXTRA_OUTPUT,
                        Uri.fromFile(photo));
                imageUri = Uri.fromFile(photo);
                Log.e("path of image", "" + imageUri);
                startActivityForResult(intent, TAKE_PICTURE);

            }


        });


        final ArrayAdapter<String> adapter_salary = new ArrayAdapter<String>(this, R.layout.adap_edit_spinner, Report);

        final ArrayAdapter<String> adapter_goSlow = new ArrayAdapter<String>(this, R.layout.adap_edit_spinner, goslow);
        final ArrayAdapter<String> adapter_police = new ArrayAdapter<String>(this, R.layout.adap_edit_spinner, police);
        final ArrayAdapter<String> adapter_accident = new ArrayAdapter<String>(this, R.layout.adap_edit_spinner, accident);
        final ArrayAdapter<String> adapter_hazard = new ArrayAdapter<String>(this, R.layout.adap_edit_spinner, hazard);
        final ArrayAdapter<String> adapter_side = new ArrayAdapter<String>(this, R.layout.adap_edit_spinner, side);

        spinner3.setAdapter(adapter_side);
        spinner1.setAdapter(adapter_salary);

        spinner1.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                Log.e("pos", "" + position + " " + adapter_salary.getItem(position));

                if (position == 0) {
                    spinner2.setAdapter(adapter_goSlow);
                    spinner2.setVisibility(View.VISIBLE);

                } else if (position == 1) {

                    spinner2.setAdapter(adapter_police);
                    spinner2.setVisibility(View.VISIBLE);

                } else if (position == 2) {
                    spinner2.setAdapter(adapter_accident);
                    spinner2.setVisibility(View.VISIBLE);
                } else if (position == 3) {
                    spinner2.setAdapter(adapter_hazard);
                    spinner2.setVisibility(View.VISIBLE);
                } else {

                    spinner2.setVisibility(View.INVISIBLE);
                }


            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });


        dialog_addLocationPop.show();


    }

    @Override
    public void onClick(View v) {
        switch (v.getId()) {
            case R.id.side_menu_manager:
                drawer_left.toggleLeftDrawer();
                break;


            case R.id.report_menu_manager:
                drawer_right.toggleRightDrawer();
                break;

            case R.id.ll_navigate:
                drawer_left.toggleRightDrawer();
                showNavigatePopUp();
                break;

            case R.id.ll_logout:
                drawer_left.toggleRightDrawer();
                onBackPressed();


                break;

            case R.id.ll_traafik:


                break;
            case R.id.ll_share_location:

                drawer_left.toggleRightDrawer();
                showSharePopUp();
                break;

        }
    }


    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        switch (requestCode) {
            case TAKE_PICTURE:
                if (resultCode == Activity.RESULT_OK) {
                    Uri selectedImage = imageUri;
                    getContentResolver().notifyChange(selectedImage, null);
                    // ImageView imageView = (ImageView) findViewById(R.id.ImageView);
                    ContentResolver cr = getContentResolver();
                    Bitmap bitmap;
                    try {
                        bitmap = MediaStore.Images.Media
                                .getBitmap(cr, selectedImage);

                        // imageView.setImageBitmap(bitmap);
                        Toast.makeText(this, selectedImage.toString(),
                                Toast.LENGTH_LONG).show();
                        Intent in = new Intent(HomeManager.this, Uploadfile.class);
                        startActivity(in);
                        dialog_addLocationPop.dismiss();


                    } catch (Exception e) {
                        Toast.makeText(this, "Failed to load", Toast.LENGTH_SHORT)
                                .show();
                        Log.e("Camera", e.toString());
                    }
                }
        }
    }

    private void showNavigatePopUp() {


        final Dialog dialog = new Dialog(HomeManager.this);
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog.getWindow().setBackgroundDrawable(new ColorDrawable(Color.TRANSPARENT));
        dialog.setCancelable(true);
        dialog.setContentView(R.layout.navigatepopup);

        final Button btn_cancel = (Button) dialog.findViewById(R.id.btn_cancel);
        final Button btn_continue = (Button) dialog.findViewById(R.id.btn_continue);
        final AutoCompleteTextView atv_navigate = (AutoCompleteTextView) dialog.findViewById(R.id.atv_navigate);


        btn_cancel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                dialog.cancel();
            }
        });

        btn_continue.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                if (atv_navigate.getText().toString().replace(" ", "%20").equalsIgnoreCase("")) {

                    Toast.makeText(HomeManager.this, "Please add an address to navigate", Toast.LENGTH_SHORT).show();

                } else {


                    getLocation();

                    double sourceLat = latitude;
                    double sourceLng = longitude;
                    double destiLat = Double.parseDouble(Global.dest_lat);
                    double destiLng = Double.parseDouble(Global.dest_long);

                    printPath.printPath(sourceLat, sourceLng, destiLat, destiLng, googleMap);

                    markerNavigateTo = new MarkerOptions().position(new LatLng(destiLat, destiLng)).title("Destination");
                    markerNavigateTo.icon(BitmapDescriptorFactory
                            .defaultMarker(BitmapDescriptorFactory.HUE_CYAN));
                    // adding marker
                    //    googleMap.addMarker(markerNavigateTo);

                    CameraPosition cameraPosition = new CameraPosition.Builder().target(
                            new LatLng(latitude, longitude)).zoom(16.0F)
                            .bearing(300F) // orientation
                            .tilt(70F) // viewing angle
                            .build();

                    googleMap.animateCamera(CameraUpdateFactory.newCameraPosition(cameraPosition));

                    dialog.dismiss();


                }


            }
        });


        atv_navigate.setAdapter(new GooglePlacesAutocompleteAdapter(this, R.layout.list_item));
        atv_navigate.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {


                long id_item = parent.getSelectedItemId();
                String Str_id = String.valueOf(id_item);
                String location = atv_navigate.getText().toString();

                if (location == null || location.equals("")) {
                    Toast.makeText(getBaseContext(), "No Place is entered", Toast.LENGTH_SHORT).show();
                    return;
                }

                String url = "https://maps.googleapis.com/maps/api/geocode/json?";

                try {
                    // encoding special characters like space in the user input place
                    location = URLEncoder.encode(location, "utf-8");
                } catch (UnsupportedEncodingException e) {
                    e.printStackTrace();
                }

                String address = "address=" + location;

                Log.e("address", address);

                String sensor = "sensor=false";

                // url , from where the geocoding data is fetched
                url = url + address + "&" + sensor;

                // Instantiating DownloadTask to get places from Google Geocoding service
                // in a non-ui thread

                DownloadTask downloadTask = new DownloadTask();

                // Start downloading the geocoding places
                downloadTask.execute(url);

            }
        });

        dialog.show();


    }

    private void showSharePopUp() {
        final Dialog dialog = new Dialog(HomeManager.this);
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog.getWindow().setBackgroundDrawable(new ColorDrawable(Color.TRANSPARENT));
        dialog.setCancelable(true);
        dialog.setContentView(R.layout.share_popup);
        String[] timeLimit = {"15 minutes", "30 minutes", "45 minutes", "1 hour", "2 hours", "3 hours", "4 hours"};
        final ArrayAdapter<String> adapter_time;
        final Button btn_cancel = (Button) dialog.findViewById(R.id.btn_cancel);
        final Button btn_continue = (Button) dialog.findViewById(R.id.btn_continue);
        final EditText atv_emai = (EditText) dialog.findViewById(R.id.atv_emai);
        final Spinner time_spinner = (Spinner) dialog.findViewById(R.id.time_spinner);


        adapter_time = new ArrayAdapter<String>(this, R.layout.adap_share_pop, timeLimit);
        time_spinner.setAdapter(adapter_time);

        time_spinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {


                if (position == 0){
                    ShareFor = "15";
                }
                else if (position == 1){
                    ShareFor = "30";
                }
                else if (position == 2){
                    ShareFor = "45";
                }
                else if (position == 3){
                    ShareFor = "60";
                }
                else if (position == 4){
                    ShareFor = "120";
                }
                else if (position == 5){
                    ShareFor = "180";
                }
                else if (position == 6){
                    ShareFor = "240";
                }

                Log.e("pos", ""+ShareFor);

             //   "15 minutes", "30 minutes", "45 minutes", "1 hour", "2 hours", "3 hours", "4 hours"

            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });

        btn_cancel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                dialog.cancel();
            }
        });
        btn_continue.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                String emailSend = atv_emai.getText().toString().trim();

                if (emailSend.equalsIgnoreCase("")){
                    Toast.makeText(HomeManager.this, "Please fill email id to share location", Toast.LENGTH_SHORT).show();
                }

                else {

                    apiHit = 4;
                    new MainAsyncTask(HomeManager.this, Global.BaseUrl + "user/createLocation/from_user/" + SharedPref.get_UserId(HomeManager.this) + "/to_user_email/"+emailSend+"/duration/"+ShareFor+"/type/1", 100, HomeManager.this, Global.json, true).execute();
                    dialog.dismiss();

                }



            }
        });
        dialog.show();
    }

    @Override
    public void toShow() {

    }

    @Override
    public void showing(float fraction) {

    }

    @Override
    public void showed() {

    }

    @Override
    public void toHide() {

    }

    @Override
    public void hiding(float fraction) {

    }

    @Override
    public void hided() {

    }

    @Override
    public void onClick(int buttonIndex) {

       if (buttonIndex==0){
           showNavigatePopUp();
       }
        else if (buttonIndex==1){
            showCustomViewDialog();
        }

        else if (buttonIndex==2){
           drawer_right.toggleRightDrawer();
       }
        else if (buttonIndex==3){
           recreate();
       }

    }


    private void initBoom() {
        int number = 4;

        Drawable[] drawables = new Drawable[number];
        int[] drawablesResource = new int[]{
                R.drawable.mark1,
                R.drawable.mark2,
                R.drawable.mark3,
                R.drawable.mark4,
        };
        for (int i = 0; i < number; i++)
            drawables[i] = ContextCompat.getDrawable(this, drawablesResource[i]);

        String[] STRINGS = new String[]{
                "Navigate",
                "Filter",
                "Add new",
                "Refresh",

        };
        String[] strings = new String[number];
        for (int i = 0; i < number; i++)
            strings[i] = STRINGS[i];

        int[][] colors = new int[number][2];
        for (int i = 0; i < number; i++) {
            colors[i][1] = GetRandomColor();
            colors[i][0] = Util.getInstance().getPressedColor(colors[i][1]);
        }

        ButtonType buttonType = ButtonType.CIRCLE;



        boomMenuButton.init(
                drawables,
                strings,
                colors,
                buttonType,
                BoomType.HORIZONTAL_THROW_2,
                PlaceType.CIRCLE_4_2,
                null,
                null,
                null,
                null,
                null,
                null,
                null);


        boomMenuButton.setSubButtonShadowOffset(Util.getInstance().dp2px(2), Util.getInstance().dp2px(2));
    }



    private String[] Colors = {
            "#fd5722",
            "#fd5722",
            "#fd5722",
            "#fd5722",
            "#fd5722"};

    public int GetRandomColor() {
        Random random = new Random();
        int p = random.nextInt(Colors.length);
        return Color.parseColor(Colors[p]);
    }





    public class LogoutLoad extends AsyncTask<String, String, String> {
        protected void onPreExecute() {
            super.onPreExecute();


        }

        protected String doInBackground(String... params) {
            try {
                HttpClient client = new DefaultHttpClient();
                HttpPost post = new HttpPost(Global.BaseUrl + "user/logout");
                post.addHeader("auth_code", SharedPref.get_LogAuth(HomeManager.this));

                HttpResponse response = client.execute(post);
                sb = new StringBuilder();
                BufferedReader br = new BufferedReader(new InputStreamReader(response.getEntity().getContent()));
                String code = "";
                while ((code = br.readLine()) != null) {
                    Log.e("mytag", code);

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


                SharedPref.set_Logged(HomeManager.this, "loggedOff");
                Intent in = new Intent(HomeManager.this, Login.class);
                startActivity(in);
                finish();


            } catch (Exception e) {

                e.printStackTrace();

            }


        }
    }


    @Override
    public void onPostSuccess(String result, int id, boolean isSucess) {

        if (apiHit == 1) {
            if (isSucess) {

                try {

                    Log.e("<>s<>", "" + result);

                    JSONObject json = new JSONObject(result);
                    Log.e("My Complete Data ", " " + json);


                    String status = json.getString("status");
                    if (status.equals("OK")) {

                        JSONArray list = json.getJSONArray("list");
                        Log.e("length", "" + list.length());

                        for (int i = 0; i <= list.length(); i++) {
                            JSONObject obj = list.getJSONObject(i);


                            fetlatitude = obj.getString("latitude");
                            fetlongitude = obj.getString("longitude");
                            String report_id = obj.getString("report_id");
                            String report_cause_id = obj.getString("report_cause_id");
                            String post_id = obj.getString("id");
                            String post_content = obj.getString("content");
                            String file_path = obj.getString("file_path");
                            String file_address = obj.getString("address");
                            String file_create_time = obj.getString("create_time");


                            Log.e("latitude", fetlatitude);
                            Log.e("longitude", fetlongitude);
                            Log.e("report_id", report_id);
                            Log.e("report_cause_id", report_cause_id);

                            double reportLat = Double.parseDouble(fetlatitude);
                            double reportLng = Double.parseDouble(fetlongitude);

                            if (report_id.equalsIgnoreCase("1")) {

                                if (report_cause_id.equalsIgnoreCase("1")) {

                                    mMyMarkersArray.add(new MyMarker("Go Slow- Traffic: Moderate", "" + file_path, reportLat, reportLng, 1, file_address, file_create_time));
                                } else if (report_cause_id.equalsIgnoreCase("2")) {
                                    mMyMarkersArray.add(new MyMarker("Go Slow- Traffic: Heavy", "" + file_path, reportLat, reportLng, 1, file_address, file_create_time));
                                } else if (report_cause_id.equalsIgnoreCase("3")) {

                                    mMyMarkersArray.add(new MyMarker("Go Slow- Traffic: StandStill", "" + file_path, reportLat, reportLng, 1, file_address, file_create_time));
                                } else {

                                    mMyMarkersArray.add(new MyMarker("Go Slow", "" + file_path, reportLat, reportLng, 1, file_address, file_create_time));

                                }


                            } else if (report_id.equalsIgnoreCase("2")) {

                                if (report_cause_id.equalsIgnoreCase("4")) {
                                    mMyMarkersArray.add(new MyMarker("Police Hidden", "" + file_path, reportLat, reportLng, 2, file_address, file_create_time));
                                } else if (report_cause_id.equalsIgnoreCase("5")) {
                                    mMyMarkersArray.add(new MyMarker("Police Visible", "" + file_path, reportLat, reportLng, 2, file_address, file_create_time));
                                } else {
                                    mMyMarkersArray.add(new MyMarker("police", "" + file_path, reportLat, reportLng, 2, file_address, file_create_time));
                                }

                            } else if (report_id.equalsIgnoreCase("3")) {
                                if (report_cause_id.equalsIgnoreCase("6")) {

                                    mMyMarkersArray.add(new MyMarker("Accident- Minor", "" + file_path, reportLat, reportLng, 3, file_address, file_create_time));
                                } else if (report_cause_id.equalsIgnoreCase("7")) {

                                    mMyMarkersArray.add(new MyMarker("Accident - Major", "" + file_path, reportLat, reportLng, 3, file_address, file_create_time));
                                } else {
                                    mMyMarkersArray.add(new MyMarker("Accident", "" + file_path, reportLat, reportLng, 3, file_address, file_create_time));
                                }

                            } else if (report_id.equalsIgnoreCase("4")) {

                                if (report_cause_id.equalsIgnoreCase("8")) {
                                    mMyMarkersArray.add(new MyMarker("Hazard - On Road", "" + file_path, reportLat, reportLng, 4, file_address, file_create_time));
                                } else if (report_cause_id.equalsIgnoreCase("9")) {
                                    mMyMarkersArray.add(new MyMarker("Hazard- Off Road", "" + file_path, reportLat, reportLng, 4, file_address, file_create_time));
                                } else if (report_cause_id.equalsIgnoreCase("10")) {
                                    mMyMarkersArray.add(new MyMarker("Hazard- weather", "" + file_path, reportLat, reportLng, 4, file_address, file_create_time));
                                } else {
                                    mMyMarkersArray.add(new MyMarker("Hazard", "" + file_path, reportLat, reportLng, 4, file_address, file_create_time));
                                }

                            } else if (report_id.equalsIgnoreCase("5")) {

                                mMyMarkersArray.add(new MyMarker("Place", "" + file_path, reportLat, reportLng, 5, file_address, file_create_time));

                            } else if (report_id.equalsIgnoreCase("6")) {
                                mMyMarkersArray.add(new MyMarker("Road Closed", "" + file_path, reportLat, reportLng, 6, file_address, file_create_time));

                            } else if (report_id.equalsIgnoreCase("7")) {

                                mMyMarkersArray.add(new MyMarker("Check In", "" + file_path, reportLat, reportLng, 7, file_address, file_create_time));

                            }

                            plotMarkers(mMyMarkersArray);


                        }

                    } else if (status.equals("NOK")) {
                        Log.e("status", status);
                    }

                } catch (Exception e) {

                    e.printStackTrace();
                }


            }


        } else if (apiHit == 2) {
            if (isSucess) {

                try {

                    Log.e("<>s<>", "" + result);

                    JSONObject json = new JSONObject(result);
                    Log.e("My Complete Data ", " " + json);


                    String status = json.getString("status");
                    if (status.equals("OK")) {

                        JSONArray list = json.getJSONArray("list");
                        Log.e("length", "" + list.length());

                        for (int i = 0; i <= list.length(); i++) {
                            JSONObject obj = list.getJSONObject(i);


                            fetlatitude = obj.getString("latitude");
                            fetlongitude = obj.getString("longitude");
                            String report_id = obj.getString("report_id");
                            String report_cause_id = obj.getString("report_cause_id");
                            String post_id = obj.getString("id");
                            String post_content = obj.getString("content");
                            String file_path = obj.getString("file_path");
                            String file_address = obj.getString("address");
                            String file_create_time = obj.getString("create_time");


                            Log.e("latitude", fetlatitude);
                            Log.e("longitude", fetlongitude);
                            Log.e("report_id", report_id);
                            Log.e("report_cause_id", report_cause_id);

                            double reportLat = Double.parseDouble(fetlatitude);
                            double reportLng = Double.parseDouble(fetlongitude);

                            if (report_id.equalsIgnoreCase("1")) {

                                if (report_cause_id.equalsIgnoreCase("1")) {

                                    mMyMarkersArray.add(new MyMarker("Go Slow- Traffic: Moderate", "" + file_path, reportLat, reportLng, 1, file_address, file_create_time));
                                } else if (report_cause_id.equalsIgnoreCase("2")) {
                                    mMyMarkersArray.add(new MyMarker("Go Slow- Traffic: Heavy", "" + file_path, reportLat, reportLng, 1, file_address, file_create_time));
                                } else if (report_cause_id.equalsIgnoreCase("3")) {

                                    mMyMarkersArray.add(new MyMarker("Go Slow- Traffic: StandStill", "" + file_path, reportLat, reportLng, 1, file_address, file_create_time));
                                } else {

                                    mMyMarkersArray.add(new MyMarker("Go Slow", "" + file_path, reportLat, reportLng, 1, file_address, file_create_time));

                                }


                            } else if (report_id.equalsIgnoreCase("2")) {

                                if (report_cause_id.equalsIgnoreCase("4")) {
                                    mMyMarkersArray.add(new MyMarker("Police Hidden", "" + file_path, reportLat, reportLng, 2, file_address, file_create_time));
                                } else if (report_cause_id.equalsIgnoreCase("5")) {
                                    mMyMarkersArray.add(new MyMarker("Police Visible", "" + file_path, reportLat, reportLng, 2, file_address, file_create_time));
                                } else {
                                    mMyMarkersArray.add(new MyMarker("police", "" + file_path, reportLat, reportLng, 2, file_address, file_create_time));
                                }

                            } else if (report_id.equalsIgnoreCase("3")) {
                                if (report_cause_id.equalsIgnoreCase("6")) {

                                    mMyMarkersArray.add(new MyMarker("Accident- Minor", "" + file_path, reportLat, reportLng, 3, file_address, file_create_time));
                                } else if (report_cause_id.equalsIgnoreCase("7")) {

                                    mMyMarkersArray.add(new MyMarker("Accident - Major", "" + file_path, reportLat, reportLng, 3, file_address, file_create_time));
                                } else {
                                    mMyMarkersArray.add(new MyMarker("Accident", "" + file_path, reportLat, reportLng, 3, file_address, file_create_time));
                                }

                            } else if (report_id.equalsIgnoreCase("4")) {

                                if (report_cause_id.equalsIgnoreCase("8")) {
                                    mMyMarkersArray.add(new MyMarker("Hazard - On Road", "" + file_path, reportLat, reportLng, 4, file_address, file_create_time));
                                } else if (report_cause_id.equalsIgnoreCase("9")) {
                                    mMyMarkersArray.add(new MyMarker("Hazard- Off Road", "" + file_path, reportLat, reportLng, 4, file_address, file_create_time));
                                } else if (report_cause_id.equalsIgnoreCase("10")) {
                                    mMyMarkersArray.add(new MyMarker("Hazard- weather", "" + file_path, reportLat, reportLng, 4, file_address, file_create_time));
                                } else {
                                    mMyMarkersArray.add(new MyMarker("Hazard", "" + file_path, reportLat, reportLng, 4, file_address, file_create_time));
                                }

                            } else if (report_id.equalsIgnoreCase("5")) {

                                mMyMarkersArray.add(new MyMarker("Place", "" + file_path, reportLat, reportLng, 5, file_address, file_create_time));

                            } else if (report_id.equalsIgnoreCase("6")) {
                                mMyMarkersArray.add(new MyMarker("Road Closed", "" + file_path, reportLat, reportLng, 6, file_address, file_create_time));

                            } else if (report_id.equalsIgnoreCase("7")) {

                                mMyMarkersArray.add(new MyMarker("Check In", "" + file_path, reportLat, reportLng, 7, file_address, file_create_time));

                            }

                            plotMarkers(mMyMarkersArray);


                        }

                    } else if (status.equals("NOK")) {
                        Log.e("status", status);
                    }

                } catch (Exception e) {

                    e.printStackTrace();
                }


            }


        } else if (apiHit == 3) {
            if (isSucess) {

                try {

                    Log.e("<>s<>", "" + result);

                    JSONObject json = new JSONObject(result);
                    Log.e("My Complete Data ", " " + json);


                    String status = json.getString("status");
                    if (status.equals("OK")) {

                        JSONArray list = json.getJSONArray("list");
                        Log.e("length", "" + list.length());

                        for (int i = 0; i <= list.length(); i++) {
                            JSONObject obj = list.getJSONObject(i);


                            fetlatitude = obj.getString("latitude");
                            fetlongitude = obj.getString("longitude");
                            String report_id = obj.getString("report_id");
                            String report_cause_id = obj.getString("report_cause_id");
                            String post_id = obj.getString("id");
                            String post_content = obj.getString("content");
                            String file_path = obj.getString("file_path");
                            String file_address = obj.getString("address");
                            String file_create_time = obj.getString("create_time");


                            Log.e("latitude", fetlatitude);
                            Log.e("longitude", fetlongitude);
                            Log.e("report_id", report_id);
                            Log.e("report_cause_id", report_cause_id);

                            double reportLat = Double.parseDouble(fetlatitude);
                            double reportLng = Double.parseDouble(fetlongitude);

                            if (report_id.equalsIgnoreCase("1")) {

                                if (report_cause_id.equalsIgnoreCase("1")) {

                                    mMyMarkersArray.add(new MyMarker("Go Slow- Traffic: Moderate", "" + file_path, reportLat, reportLng, 1, file_address, file_create_time));
                                } else if (report_cause_id.equalsIgnoreCase("2")) {
                                    mMyMarkersArray.add(new MyMarker("Go Slow- Traffic: Heavy", "" + file_path, reportLat, reportLng, 1, file_address, file_create_time));
                                } else if (report_cause_id.equalsIgnoreCase("3")) {

                                    mMyMarkersArray.add(new MyMarker("Go Slow- Traffic: StandStill", "" + file_path, reportLat, reportLng, 1, file_address, file_create_time));
                                } else {

                                    mMyMarkersArray.add(new MyMarker("Go Slow", "" + file_path, reportLat, reportLng, 1, file_address, file_create_time));

                                }


                            } else if (report_id.equalsIgnoreCase("2")) {

                                if (report_cause_id.equalsIgnoreCase("4")) {
                                    mMyMarkersArray.add(new MyMarker("Police Hidden", "" + file_path, reportLat, reportLng, 2, file_address, file_create_time));
                                } else if (report_cause_id.equalsIgnoreCase("5")) {
                                    mMyMarkersArray.add(new MyMarker("Police Visible", "" + file_path, reportLat, reportLng, 2, file_address, file_create_time));
                                } else {
                                    mMyMarkersArray.add(new MyMarker("police", "" + file_path, reportLat, reportLng, 2, file_address, file_create_time));
                                }

                            } else if (report_id.equalsIgnoreCase("3")) {
                                if (report_cause_id.equalsIgnoreCase("6")) {

                                    mMyMarkersArray.add(new MyMarker("Accident- Minor", "" + file_path, reportLat, reportLng, 3, file_address, file_create_time));
                                } else if (report_cause_id.equalsIgnoreCase("7")) {

                                    mMyMarkersArray.add(new MyMarker("Accident - Major", "" + file_path, reportLat, reportLng, 3, file_address, file_create_time));
                                } else {
                                    mMyMarkersArray.add(new MyMarker("Accident", "" + file_path, reportLat, reportLng, 3, file_address, file_create_time));
                                }

                            } else if (report_id.equalsIgnoreCase("4")) {

                                if (report_cause_id.equalsIgnoreCase("8")) {
                                    mMyMarkersArray.add(new MyMarker("Hazard - On Road", "" + file_path, reportLat, reportLng, 4, file_address, file_create_time));
                                } else if (report_cause_id.equalsIgnoreCase("9")) {
                                    mMyMarkersArray.add(new MyMarker("Hazard- Off Road", "" + file_path, reportLat, reportLng, 4, file_address, file_create_time));
                                } else if (report_cause_id.equalsIgnoreCase("10")) {
                                    mMyMarkersArray.add(new MyMarker("Hazard- weather", "" + file_path, reportLat, reportLng, 4, file_address, file_create_time));
                                } else {
                                    mMyMarkersArray.add(new MyMarker("Hazard", "" + file_path, reportLat, reportLng, 4, file_address, file_create_time));
                                }

                            } else if (report_id.equalsIgnoreCase("5")) {

                                mMyMarkersArray.add(new MyMarker("Place", "" + file_path, reportLat, reportLng, 5, file_address, file_create_time));

                            } else if (report_id.equalsIgnoreCase("6")) {
                                mMyMarkersArray.add(new MyMarker("Road Closed", "" + file_path, reportLat, reportLng, 6, file_address, file_create_time));

                            } else if (report_id.equalsIgnoreCase("7")) {

                                mMyMarkersArray.add(new MyMarker("Check In", "" + file_path, reportLat, reportLng, 7, file_address, file_create_time));

                            }

                            plotMarkers(mMyMarkersArray);


                        }

                    } else if (status.equals("NOK")) {
                        Log.e("status", status);
                    }

                } catch (Exception e) {

                    e.printStackTrace();
                }


            }


        } else if (apiHit == 4) {
            if (isSucess) {

                try {

                    Log.e("<>s<>", "" + result);

                    JSONObject json = new JSONObject(result);
                    Log.e("My Complete Data ", " " + json);


                    String status = json.getString("status");
                    if (status.equals("OK")) {
                        Toast.makeText(HomeManager.this, "Location shared successfully", Toast.LENGTH_SHORT).show();

                    } else if (status.equals("NOK")) {
                        Log.e("status", status);
                        AlertMessage alert = new AlertMessage();
                        String message = json.getString("message");
                        alert.showErrorPopup(HomeManager.this, "Error", message);
                        
                    }

                } catch (Exception e) {

                    e.printStackTrace();
                }


            }


        }
    }

    @Override
    public void onPostError(int id, int error) {

    }

    private void plotMarkers(ArrayList<MyMarker> markers) {
        if (markers.size() > 0) {
            for (MyMarker myMarker : markers) {


                int id = myMarker.getmID();


                // Create user marker with custom icon and other options
                MarkerOptions markerOption = new MarkerOptions().position(new LatLng(myMarker.getmLatitude(), myMarker.getmLongitude()));


                if (id == 1) {
                    markerOption.icon(BitmapDescriptorFactory.fromResource(R.drawable.goslow_feed));
                } else if (id == 2) {
                    markerOption.icon(BitmapDescriptorFactory.fromResource(R.drawable.police_feed));
                } else if (id == 3) {
                    markerOption.icon(BitmapDescriptorFactory.fromResource(R.drawable.accident_feed));
                } else if (id == 4) {
                    markerOption.icon(BitmapDescriptorFactory.fromResource(R.drawable.hazard_feed));
                } else if (id == 5) {
                    markerOption.icon(BitmapDescriptorFactory.fromResource(R.drawable.place_feed));
                } else if (id == 6) {
                    markerOption.icon(BitmapDescriptorFactory.fromResource(R.drawable.roadclosed_feed));
                } else if (id == 7) {
                    markerOption.icon(BitmapDescriptorFactory.fromResource(R.drawable.check_feed));
                }


                Marker currentMarker = googleMap.addMarker(markerOption);
                mMarkersHashMap.put(currentMarker, myMarker);

                try {

                    googleMap.setInfoWindowAdapter(new MarkerInfoWindowAdapter());
                } catch (Exception e) {
                    e.printStackTrace();
                }


                if (currentMarker.getTitle().equalsIgnoreCase("You are here")) {


                } else if (currentMarker.getTitle().equalsIgnoreCase("Destination")) {


                } else {


                    googleMap.setOnInfoWindowLongClickListener(new GoogleMap.OnInfoWindowLongClickListener() {
                        @Override
                        public void onInfoWindowLongClick(Marker marker) {

                            Intent in = new Intent(HomeManager.this, DetailedViewLocation.class);
                            startActivity(in);
                            overridePendingTransition(android.R.anim.fade_in, android.R.anim.fade_out);

                        }
                    });


                }


            }
        }
    }

    public class MarkerInfoWindowAdapter implements GoogleMap.InfoWindowAdapter {
        public MarkerInfoWindowAdapter() {
        }

        @Override
        public View getInfoWindow(Marker marker) {
            return null;
        }

        @Override
        public View getInfoContents(final Marker marker) {


            viewMarker = getLayoutInflater().inflate(R.layout.infowindow_layout, null);
            final MyMarker myMarker = mMarkersHashMap.get(marker);

            ImageView markerIcon = (ImageView) viewMarker.findViewById(R.id.marker_icon);

            TextView markerLabel = (TextView) viewMarker.findViewById(R.id.marker_label);

            TextView anotherLabel = (TextView) viewMarker.findViewById(R.id.another_label);


            if (myMarker.getmID() == 1) {

                markerIcon.setImageResource(R.drawable.goslow_feed);

            } else if (myMarker.getmID() == 2) {
                markerIcon.setImageResource(R.drawable.police_feed);

            } else if (myMarker.getmID() == 3) {
                markerIcon.setImageResource(R.drawable.accident_feed);

            } else if (myMarker.getmID() == 4) {
                markerIcon.setImageResource(R.drawable.hazard_feed);

            } else if (myMarker.getmID() == 5) {
                markerIcon.setImageResource(R.drawable.place_feed);

            } else if (myMarker.getmID() == 6) {
                markerIcon.setImageResource(R.drawable.roadclosed_feed);

            } else if (myMarker.getmID() == 7) {
                markerIcon.setImageResource(R.drawable.check_feed);

            }


            Global.detailImage = "" + myMarker.getmIcon();
            Global.detailAddress = "" + myMarker.getmAdrress();
            Global.detailCreated = "" + myMarker.getmcreated();
            Global.detailType = "" + myMarker.getmLabel();

            markerLabel.setText(myMarker.getmLabel());
            anotherLabel.setText("A custom text");


            return viewMarker;

        }
    }


    public static Bitmap getBitmapFromURL(String src) {
        try {

            URL url = new URL(src);
            HttpURLConnection connection = (HttpURLConnection) url.openConnection();
            connection.setDoInput(true);
            connection.connect();
            InputStream input = connection.getInputStream();
            Bitmap myBitmap = BitmapFactory.decodeStream(input);

            return myBitmap;
        } catch (IOException e) {
            // Log exception
            return null;
        }
    }

}
