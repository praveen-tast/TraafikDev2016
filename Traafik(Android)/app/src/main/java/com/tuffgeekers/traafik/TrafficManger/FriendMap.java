package com.tuffgeekers.traafik.TrafficManger;

import android.app.Activity;
import android.os.Handler;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.widget.Toast;

import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.MapFragment;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.CameraPosition;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;
import com.tuffgeekers.jsonfiles.MainAsynListener;
import com.tuffgeekers.jsonfiles.MainAsyncTask;
import com.tuffgeekers.traafik.R;
import com.tuffgeekers.utils.Global;

import org.json.JSONArray;
import org.json.JSONObject;

public class FriendMap extends Activity implements MainAsynListener<String> {

    private GoogleMap googleMap;
    Handler mHandler = new Handler();
    int mInterval = 10000;
    Runnable mStatusChecker = new Runnable() {
        @Override
        public void run() {
            try {

                new MainAsyncTask(FriendMap.this, Global.BaseUrl+"user/profile/id/" + Global.friend_id, 100, FriendMap.this, Global.json, false).execute();
            } finally {
                // 100% guarantee that this always happens, even if
                // your update method throws an exception
                mHandler.postDelayed(mStatusChecker, mInterval);
            }
        }
    };

    void startRepeatingTask() {
        mStatusChecker.run();
    }

    void stopRepeatingTask() {
        mHandler.removeCallbacks(mStatusChecker);
    }


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_friendmap);



        try {
            initilizeMap();
        } catch (Exception e) {
            e.printStackTrace();
        }

       startRepeatingTask();
    }


    @Override
    public void onBackPressed() {
        stopRepeatingTask();
        finish();
    }

    private void initilizeMap() {


        if (googleMap == null) {
            googleMap = ((MapFragment) getFragmentManager().findFragmentById(
                    R.id.map_friend)).getMap();


            // create marker



            // check if map is created successfully or not
            if (googleMap == null) {
                Toast.makeText(getApplicationContext(),
                        "Sorry! unable to create maps", Toast.LENGTH_SHORT)
                        .show();
            }
        }
    }

    @Override
    public void onPostSuccess(String result, int id, boolean isSucess) {
Log.e("response on  map",result);
        try
        {
            JSONObject obj=new JSONObject(result);
            String status=obj.getString("status");
            if(status.equalsIgnoreCase("NOK"))
            {

            }
            else if(status.equalsIgnoreCase("OK"))
            {

                String listDat = obj.getString("list");
                JSONObject list= new JSONObject(listDat);

                Log.e("<><list", ""+listDat);

                    String latitude=list.getString("work_lat");
                    String longitude=list.getString("work_long");
                    Log.e("work_lat",latitude);
                    Log.e("work_long",longitude);


                googleMap.clear();
            MarkerOptions markerME = new MarkerOptions().position(new LatLng(Double.parseDouble(latitude), Double.parseDouble(longitude)));
            markerME.icon(BitmapDescriptorFactory
                    .defaultMarker(BitmapDescriptorFactory.HUE_ROSE));
            // adding marker
              googleMap.addMarker(markerME);
            CameraPosition cameraPosition = new CameraPosition.Builder().target(
                    new LatLng(Double.parseDouble(latitude), Double.parseDouble(longitude))).zoom(15.0F)
                    .bearing(300F) // orientation
                    .tilt(30F) // viewing angle
                    .build();

                 googleMap.animateCamera(CameraUpdateFactory.newCameraPosition(cameraPosition));


            }
        }
       catch(Exception e)
       {
           e.printStackTrace();
       }
    }

    @Override
    public void onPostError(int id, int error) {

    }
}
