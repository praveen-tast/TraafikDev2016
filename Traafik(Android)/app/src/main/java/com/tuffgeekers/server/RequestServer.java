package com.tuffgeekers.server;

import android.app.Dialog;
import android.content.Context;
import android.graphics.drawable.ColorDrawable;
import android.os.AsyncTask;
import android.util.Log;
import android.view.Window;
import android.view.WindowManager.BadTokenException;
import android.widget.Toast;
import com.tuffgeekers.traafik.R;
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
public class RequestServer extends AsyncTask<Void, Void, String> {

	private String TAG = RequestServer.class.getSimpleName();

	private static final String NETWORK_ISSUE = "NetworkIssue";

	public static enum RequestType {
		GET, POST, PUT, DELETE, MULTIPARTREQTYPE
	}

	private Context mContext;
	private String mUrl;
	private RequestType mRequestType;
	private JSONObject mUserData;
	private Dialog dialog;
	private IRequestListener iRequestListener;

	private HttpResponse response;
	private int httpStatus;
	private int number;

	private boolean mShowLoader;


	public RequestServer(Context context, String url, RequestType RequestType,
			JSONObject userData, IRequestListener iRquestListener,
			boolean showLoader, int pageId) {
		mContext = context;
		mUrl = url;
		mRequestType = RequestType;
		mUserData = userData;
		this.iRequestListener = iRquestListener;
		mShowLoader = showLoader;
		number = pageId;
		Log.d(TAG, "-" + url + "-");
		Log.d(TAG, mUserData != null ? mUserData.toString() : "");


		dialog = new Dialog(mContext);
		dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
		dialog.getWindow().setBackgroundDrawable(new ColorDrawable(android.graphics.Color.TRANSPARENT));
		dialog.setContentView(R.layout.progress_pre);
		dialog.setCancelable(false);
		
		
	}

	@Override
	protected void onPreExecute() {
		if (mShowLoader) {
			try {

			
				try {
					dialog.show();
				} catch (BadTokenException e) {

				}
				
				//dialog.show();
				
			} catch (Exception e) {
				e.printStackTrace();
			}
		}
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
			//	postRequest.addHeader("X-Auth-Token", info.getAccess_token());
				
			//	postRequest.addHeader("X-Auth-Token", pref.getDefaults("access_token", mContext));
				//postRequest.addHeader("X-Auth-Token", GeneralValues.get_savedToken((Activity)mContext));
				StringEntity stringEntity = new StringEntity(
						mUserData.toString());
				postRequest.setEntity(stringEntity);

				response = client.execute(postRequest);

				break;
			case GET:
				HttpGet getRequest = new HttpGet(mUrl);
			//	getRequest.addHeader("X-Auth-Token", info.getAccess_token());
				//getRequest.addHeader("X-Auth-Token", info.getAccess_token());
			//	getRequest.addHeader("X-Auth-Token",  pref.getDefaults("access_token", mContext));
			//	getRequest.addHeader("X-Auth-Token",  GeneralValues.get_savedToken((Activity) mContext));

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
		try {
			if (dialog != null)
				if (dialog.isShowing())

					dialog.dismiss();

		} catch (Exception e) {
			e.printStackTrace();
		}
		if (iRequestListener != null) {
			if (result.equals(NETWORK_ISSUE))
				Toast.makeText(
						mContext,
						"No internet connection, Please connect to internet first",
						Toast.LENGTH_LONG).show();
			else {
				/*
				 * if (Preference.getString(mContext, mUrl) == null)
				 * Preference.saveString(mContext, mUrl, result);
				 */
				iRequestListener.onRequestListener(result, httpStatus,
						mRequestType);
			}
		}
	}

	
	
	
	public interface IRequestListener {
		public void onRequestListener(String response, int httpStatus,
									  RequestType requesttype);

	}
}
