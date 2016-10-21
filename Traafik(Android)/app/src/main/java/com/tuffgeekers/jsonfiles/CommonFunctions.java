package com.tuffgeekers.jsonfiles;

import android.annotation.SuppressLint;
import android.util.Log;

import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.params.HttpConnectionParams;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;

@SuppressLint("SimpleDateFormat")
public class CommonFunctions{
	   
	public InputStream connectionEstablished(String mUrl) {
		InputStream mInputStreamis = null;

		HttpClient client = new DefaultHttpClient();
		HttpConnectionParams.setConnectionTimeout(client.getParams(), 10000); // Timeout Limit
		HttpResponse response;
		try {
			HttpPost post = new HttpPost(mUrl);
			response = client.execute(post);
			/* Checking response */
			if (response != null) {
				Log.e("URLLLLLLLLL", mUrl);
				mInputStreamis = response.getEntity().getContent(); // Get the entity.
			}
		}
 
		catch (Exception e) {
		
			Log.e("Caught in exception", "Error  ===== " + e.toString()); 
			
		}

		return mInputStreamis;
	}

	public String converResponseToString(InputStream InputStream) {
		String mResult = "";
		StringBuilder mStringBuilder;

		try {
			BufferedReader reader = new BufferedReader(new InputStreamReader(
					InputStream, "UTF8"), 8);
			mStringBuilder = new StringBuilder();
			mStringBuilder.append(reader.readLine() + "\n");
			String line = "0";
			while ((line = reader.readLine()) != null) {
				mStringBuilder.append(line + "\n");
			}
			InputStream.close();
			mResult = mStringBuilder.toString(); 

			return mResult;
		} catch (Exception e) {
		
			return mResult;
		}
	}
}
