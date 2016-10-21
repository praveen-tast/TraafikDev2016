package com.tuffgeekers.GoogleClasses;

import android.os.AsyncTask;
import android.util.Log;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

/**
 * Created by tuff on 21-Mar-16.
 */
public class DownloadTask extends AsyncTask<String, Integer, String> {

    String data = null;

    // Invoked by execute() method of this object

    protected String doInBackground(String... url) {
        try {
            data = downloadUrl(url[0]);
        } catch (Exception e) {
            Log.d("Background Task", e.toString());
        }
        return data;
    }

    private String downloadUrl(String strUrl) throws IOException {
        String data = "";
        InputStream iStream = null;
        HttpURLConnection urlConnection = null;
        try {
            URL url = new URL(strUrl);
            // Creating an http connection to communicate with url
            urlConnection = (HttpURLConnection) url.openConnection();

            // Connecting to url
            urlConnection.connect();

            // Reading data from url
            iStream = urlConnection.getInputStream();

            BufferedReader br = new BufferedReader(new InputStreamReader(iStream));

            StringBuffer sb = new StringBuffer();

            String line = "";
            while ((line = br.readLine()) != null) {
                sb.append(line);
            }

            data = sb.toString();
            br.close();

        } catch (Exception e) {
            Log.d("while downloading url", e.toString());
        } finally {
            iStream.close();
            urlConnection.disconnect();
        }

        return data;
    }

    // Executed after the complete execution of doInBackground() method
    @Override
    public void onPostExecute(String result) {

        // Instantiating ParserTask which parses the json data from Geocoding webservice
        // in a non-ui thread

        ParserTask parserTask = new ParserTask();

        // Start parsing the places in JSON format
        // Invokes the "doInBackground()" method of the class ParseTask
        parserTask.execute(result);


    }
}
