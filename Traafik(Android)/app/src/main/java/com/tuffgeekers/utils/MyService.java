package com.tuffgeekers.utils;

import android.app.Service;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Handler;
import android.os.IBinder;
import android.support.annotation.Nullable;
import android.util.Log;
import android.widget.Toast;
import com.tuffgeekers.GPSdata.GPSService;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.List;

/**
 * Created by tuff on 01-Apr-16.
 */
public class MyService extends Service {

    double latitude ,longitude;
    StringBuilder sb;

    @Nullable
    @Override
    public IBinder onBind(Intent intent) {
        return null;
    }

    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {
        // TODO do something useful

        startRepeatingTask();
        //smsHandler.sendEmptyMessageDelayed(DISPLAY_DATA, 1000);
       //return Service.START_NOT_STICKY;
        return Service.START_STICKY;
    }


    Handler mHandler = new Handler();
    int mInterval = 10000;
    Runnable mStatusChecker = new Runnable() {
        @Override
        public void run() {
            try {
                updateLocation(); //this function can change value of mInterval.
                new AsynData().execute();

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

    public void updateLocation(){

        getLocation();

    }

    private void getLocation() {
        // TODO Auto-generated method stub


        String address = "";
        GPSService mGPSService = new GPSService(MyService.this);
        mGPSService.getLocation();

        if (mGPSService.isLocationAvailable == false) {

            // Here you can ask the user to try again, using return; for that
            Toast.makeText(MyService.this, "Your location is not available, please try again.", Toast.LENGTH_SHORT).show();
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
           // address = mGPSService.getLocationAddress();

            //tvLocation.setText("Latitude: " + latitude + " \nLongitude: " + longitude);
            //	tvAddress.setText("Address: " + address);

            Log.e("location", "Latitude: " + latitude + "Longitude: " + longitude);
            Log.e("address", address);

            //showAlertDialog(AddLocation.this, "Address", ""+address);


        }

        // make sure you close the gps after using it. Save user's battery power
        mGPSService.closeGPS();

    }

    public class AsynData extends AsyncTask<String, String, String> {
        protected void onPreExecute() {
            super.onPreExecute();

        }

        protected String doInBackground(String... params) {
            try {
                HttpClient client = new DefaultHttpClient();
                HttpPost post = new HttpPost(Global.BaseUrl + "user/update/id/"+Global.userId);
               // post.addHeader("auth_code", ""+Global.auth);

                List<NameValuePair> arg = new ArrayList<NameValuePair>();
              //  arg.add(new BasicNameValuePair("id", ""+Global.userId));
                arg.add(new BasicNameValuePair("User[work_lat]", ""+latitude));
                arg.add(new BasicNameValuePair("User[work_long]", ""+longitude));

                post.setEntity(new UrlEncodedFormEntity(arg));
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

            } catch (Exception e) {

                e.printStackTrace();
            }


        }
    }


}
