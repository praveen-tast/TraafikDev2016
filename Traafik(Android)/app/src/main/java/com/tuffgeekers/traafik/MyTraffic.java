package com.tuffgeekers.traafik;

import android.app.Activity;
import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.drawable.ColorDrawable;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.StrictMode;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.MapFragment;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;
import com.tuffgeekers.Adapter.MatchesAdapter;
import com.tuffgeekers.Adapter.MyMarker;
import com.tuffgeekers.jsonfiles.MainAsynListener;
import com.tuffgeekers.jsonfiles.MainAsyncTask;
import com.tuffgeekers.utils.AlertMessage;
import com.tuffgeekers.utils.Global;
import com.tuffgeekers.utils.SharedPref;
import org.json.JSONArray;
import org.json.JSONObject;
import java.io.IOException;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;
import java.util.HashMap;

public class MyTraffic extends Activity implements View.OnClickListener, MainAsynListener<String> {

    ImageView iv_gobackmy;
    AlertMessage alert = new AlertMessage();
    private GoogleMap googleMap;
    String fetlatitude, fetlongitude;
    ListView lv_list;
    ArrayList<HashMap<String, String>> matchesListArr = new ArrayList<HashMap<String, String>>();
    HashMap<String, String> hshListCategory;

    private ArrayList<MyMarker> mMyMarkersArray = new ArrayList<MyMarker>();
    private HashMap<Marker, MyMarker> mMarkersHashMap;
    ImageView markerIcon;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_my_traffic);

        StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
        StrictMode.setThreadPolicy(policy);

        initializeViews();

        iv_gobackmy.setOnClickListener(this);

        try {
            initilizeMap();
        } catch (Exception e) {
            e.printStackTrace();
        }

        new MainAsyncTask(MyTraffic.this, Global.BaseUrl + "user/posts/id/" + SharedPref.get_UserId(MyTraffic.this), 100, MyTraffic.this, Global.json, true).execute();

    }

    @Override
    public void onBackPressed() {
        finish();
    }

    @Override
    public void onClick(View v) {

        if (v == iv_gobackmy) {

            onBackPressed();
        }

    }

    public void initializeViews() {

        iv_gobackmy = (ImageView) findViewById(R.id.iv_gobackmy);
        lv_list = (ListView) findViewById(R.id.lv_list);
        mMarkersHashMap = new HashMap<Marker, MyMarker>();

    }


    @Override
    public void onPostSuccess(String result, int id, boolean isSucess) {
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

                        hshListCategory = new HashMap<String, String>();
                        hshListCategory.put("report_id", report_id);
                        hshListCategory.put("report_cause_id", report_cause_id);
                        hshListCategory.put("post_id", post_id);
                        hshListCategory.put("post_content", post_content);
                        hshListCategory.put("file_path", file_path);
                        hshListCategory.put("file_address", file_address);
                        hshListCategory.put("file_create_time", file_create_time);
                        hshListCategory.put("fetlatitude", fetlatitude);
                        hshListCategory.put("fetlongitude", fetlongitude);

                        matchesListArr.add(hshListCategory);

                        MatchesAdapter pop_adap = new MatchesAdapter(MyTraffic.this, matchesListArr);
                        lv_list.setAdapter(pop_adap);
                        lv_list.setDividerHeight(2);

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


    }

    private void plotMarkers(ArrayList<MyMarker> markers) {
        if (markers.size() > 0) {
            for (MyMarker myMarker : markers) {

                int id = myMarker.getmID();
                // Create user marker with custom icon and other options
                MarkerOptions markerOption = new MarkerOptions().position(new LatLng(myMarker.getmLatitude(), myMarker.getmLongitude()));

              /*  if (id == 1) {
                    markerOption.icon(BitmapDescriptorFactory.defaultMarker(BitmapDescriptorFactory.HUE_CYAN));
                } else if (id == 2) {
                    markerOption.icon(BitmapDescriptorFactory.defaultMarker(BitmapDescriptorFactory.HUE_AZURE));
                } else if (id == 3) {
                    markerOption.icon(BitmapDescriptorFactory.defaultMarker(BitmapDescriptorFactory.HUE_GREEN));
                } else if (id == 4) {
                    markerOption.icon(BitmapDescriptorFactory.defaultMarker(BitmapDescriptorFactory.HUE_RED));
                } else if (id == 5) {
                    markerOption.icon(BitmapDescriptorFactory.defaultMarker(BitmapDescriptorFactory.HUE_VIOLET));
                } else if (id == 6) {
                    markerOption.icon(BitmapDescriptorFactory.defaultMarker(BitmapDescriptorFactory.HUE_YELLOW));
                } else if (id == 7) {
                    markerOption.icon(BitmapDescriptorFactory.defaultMarker(BitmapDescriptorFactory.HUE_MAGENTA));
                }
*/


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

                googleMap.setInfoWindowAdapter(new MarkerInfoWindowAdapter());
                googleMap.setOnInfoWindowLongClickListener(new GoogleMap.OnInfoWindowLongClickListener() {
                    @Override
                    public void onInfoWindowLongClick(Marker marker) {

                        Intent in = new Intent(MyTraffic.this, DetailedViewLocation.class);
                        startActivity(in);
                        overridePendingTransition(android.R.anim.fade_in, android.R.anim.fade_out);

                    }
                });

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
        public View getInfoContents(Marker marker) {
            View v = getLayoutInflater().inflate(R.layout.infowindow_layout, null);

            MyMarker myMarker = mMarkersHashMap.get(marker);

            markerIcon = (ImageView) v.findViewById(R.id.marker_icon);

            TextView markerLabel = (TextView) v.findViewById(R.id.marker_label);

            TextView anotherLabel = (TextView) v.findViewById(R.id.another_label);

           //  markerIcon.setImageBitmap(getBitmapFromURL(myMarker.getmIcon()));

            if(myMarker.getmID()==1){
                markerIcon.setImageResource(R.drawable.goslow_feed);
            }
            else if (myMarker.getmID()==2){
                markerIcon.setImageResource(R.drawable.police_feed);
            }
            else if (myMarker.getmID()==3){
                markerIcon.setImageResource(R.drawable.accident_feed);
            }
            else if (myMarker.getmID()==4){
                markerIcon.setImageResource(R.drawable.hazard_feed);
            }
            else if (myMarker.getmID()==5){
                markerIcon.setImageResource(R.drawable.place_feed);
            }
            else if (myMarker.getmID()==6){
                markerIcon.setImageResource(R.drawable.roadclosed_feed);
            }
            else if (myMarker.getmID()==7){
                markerIcon.setImageResource(R.drawable.check_feed);
            }

            Global.detailImage = ""+myMarker.getmIcon();
            Global.detailAddress = ""+myMarker.getmAdrress();
            Global.detailCreated = ""+myMarker.getmcreated();
            Global.detailType = ""+myMarker.getmLabel();

            markerLabel.setText(myMarker.getmLabel());
            anotherLabel.setText("A custom text");

            return v;
        }
    }


    @Override
    public void onPostError(int id, int error) {

    }

    private void initilizeMap() {
        if (googleMap == null) {
            googleMap = ((MapFragment) getFragmentManager().findFragmentById(
                    R.id.map_myTraffic)).getMap();
            googleMap.setMyLocationEnabled(true);

            // create marker


            // check if map is created successfully or not
            if (googleMap == null) {
                Toast.makeText(getApplicationContext(),
                        "Sorry! unable to create maps", Toast.LENGTH_SHORT)
                        .show();
            }
        }
    }

}
