package com.tuffgeekers.GoogleClasses;

import android.os.AsyncTask;
import android.util.Log;

import com.google.android.gms.maps.model.LatLng;
import com.tuffgeekers.GPSdata.GeocodeJSONParser;
import com.tuffgeekers.utils.Global;

import org.json.JSONObject;

import java.util.HashMap;
import java.util.List;

/**
 * Created by tuff on 21-Mar-16.
 */
public class ParserTask extends AsyncTask<String, Integer, List<HashMap<String, String>>> {
    JSONObject jObject;


    // Invoked by execute() method of this object

    protected List<HashMap<String, String>> doInBackground(String... jsonData) {

        List<HashMap<String, String>> places = null;
        GeocodeJSONParser parser = new GeocodeJSONParser();
        JSONObject jObject;

        try {
            jObject = new JSONObject(jsonData[0]);

            /** Getting the parsed data as a an ArrayList */
            places = parser.parse(jObject);

        } catch (Exception e) {
            Log.d("Exception", e.toString());
        }
        return places;

    }

    // Executed after the complete execution of doInBackground() method

    protected void onPostExecute(List<HashMap<String, String>> list) {

        // Clears all the existing markers

        // map.clear();

        for (int i = 0; i < list.size(); i++) {

            // Creating a marker
            //  MarkerOptions markerOptions = new MarkerOptions();

            // Getting a place from the places list
            HashMap<String, String> hmPlace = list.get(i);

            // Getting latitude of the place
           double lat = Double.parseDouble(hmPlace.get("lat"));

            // Getting longitude of the place
            double lng = Double.parseDouble(hmPlace.get("lng"));
           LatLng latLng = new LatLng(lat, lng);

            Log.e("latitude of selected",""+lat);
            Log.e("latitude of selected",""+lng);

            Global.dest_lat = ""+lat;
            Global.dest_long = ""+lng;


/*

            Global.dest_lat=""+lat;
            Global.dest_long=""+lng;*/
            // Locate the first location


        }
    }






}