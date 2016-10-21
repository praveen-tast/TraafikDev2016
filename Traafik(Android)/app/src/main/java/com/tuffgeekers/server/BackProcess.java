package com.tuffgeekers.server;

import android.app.ProgressDialog;
import android.content.Context;
import android.os.AsyncTask;
import android.util.Log;
import android.widget.Toast;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpDelete;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.client.methods.HttpPut;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;


@SuppressWarnings("deprecation")
public class BackProcess extends AsyncTask<Void, Void, String> {

	private String TAG = BackProcess.class.getSimpleName();

	private static final String NETWORK_ISSUE = "NetworkIssue";

	public static enum RequestType {
		GET, POST, PUT, DELETE, MULTIPARTREQTYPE
	}

	private Context mContext;
	private String mUrl;
	private RequestType mRequestType;
	private JSONObject mUserData;
	private ProgressDialog dialog;
	private RequestListener RequestListener;

	private HttpResponse response;
	private int httpStatus;
	private int number;

	private boolean mShowLoader;



	public BackProcess(Context context, String url, RequestType RequestType,
			JSONObject userData, RequestListener RquestListener, int pageId) {
		mContext = context;
		mUrl = url;
		mRequestType = RequestType;
		mUserData = userData;
		this.RequestListener = RquestListener;
		number = pageId;
		Log.d(TAG, "-" + url + "-");
		Log.d(TAG, mUserData != null ? mUserData.toString() : "");

	}

	@Override
	protected void onPreExecute() {

	}

	@Override
	protected String doInBackground(Void... params) {
		// if (Preference.getString(mContext, mUrl) != null)
		// return Preference.getString(mContext, mUrl);

		/*
		 * if (!new ConnectionDetector(mContext).isConnectedToInternet()) return
		 * NETWORK_ISSUE;
		 */
		String result = "";
		String line = "";
		try {
			HttpClient client = new DefaultHttpClient();
			switch (mRequestType) {
			case POST:
				HttpPost postRequest = new HttpPost(mUrl);
			//	postRequest.addHeader("X-Auth-Token", info.getAccess_token());
				StringEntity stringEntity = new StringEntity(
						mUserData.toString());
				postRequest.setEntity(stringEntity);
				response = client.execute(postRequest);

				break;
			case GET:
				HttpGet getRequest = new HttpGet(mUrl);
			//	getRequest.addHeader("X-Auth-Token", info.getAccess_token());
				response = client.execute(getRequest);

				break;
			case PUT:
				HttpPut putRequest = new HttpPut(mUrl);
				putRequest.setHeader("Content-type", "application/json");
				putRequest.setHeader("Accept", "application/json");
				StringEntity se = new StringEntity(mUserData.toString());
				putRequest.setEntity(se);
				response = client.execute(putRequest);

				break;
			case DELETE:
				HttpDelete delRequest = new HttpDelete(mUrl);
				delRequest.setHeader("Content-type", "application/json");
				delRequest.setHeader("Accept", "application/json");
				response = client.execute(delRequest);
				break;

			}

			httpStatus = response.getStatusLine().getStatusCode();
			final HttpEntity entity = response.getEntity();
			if (entity == null) {
				Log.w(TAG, "The response has no entity.");
			} else {
				BufferedReader rd = new BufferedReader(new InputStreamReader(
						response.getEntity().getContent()));
				while ((line = rd.readLine()) != null) {
					result += line;
				}
			}

		} catch (ClientProtocolException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		} catch (Exception e) {
			e.printStackTrace();
		}

		Log.i(TAG, result);
		return result;
	}

	@Override
	protected void onPostExecute(String result) {

		if (RequestListener != null) {
			if (result.equals(NETWORK_ISSUE))
				Toast.makeText(
						mContext,
						"No internet connection, Please connect to internet first",
						Toast.LENGTH_LONG).show();
			else {
				RequestListener.onRequestListener(result, httpStatus,
						mRequestType);
			}
		}
	}

	public interface RequestListener {
		public void onRequestListener(String response, int httpStatus,
									  RequestType requesttype);

	}
}
