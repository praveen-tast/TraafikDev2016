package com.tuffgeekers.jsonfiles;

import android.annotation.TargetApi;
import android.app.Dialog;
import android.content.Context;
import android.graphics.drawable.ColorDrawable;
import android.os.AsyncTask;
import android.os.Build;
import android.util.Log;
import android.view.Window;

import com.tuffgeekers.traafik.R;

import org.json.JSONObject;

import java.io.InputStream;

public class MainAsyncTask extends AsyncTask<String, Void, String> {

	//ProgressDialog mDialog;
	InputStream is = null;
	Dialog dialog;
	
	JSONObject json;
	MainAsynListener<String> listener;
	int receivedId;
	int errorCode;
	boolean isDialogDisplay, isSuccess = false;
	Context context;
	public CommonFunctions sSetconnection; 
	InputStream mInputStreamis = null;
	int checkResponse = 0;
	String url;
	
	public MainAsyncTask(Context context, String url, int receivedId,
			MainAsynListener<String> listener, JSONObject json,
			boolean isDialogDisplay) {
		this.context = context;
		this.json = json;
		this.url = url;
		this.receivedId = receivedId;
		this.listener = listener;
		this.isDialogDisplay = isDialogDisplay;
	}

	@Override
	protected void onPreExecute() {
		sSetconnection = new CommonFunctions();

		if (isDialogDisplay){

			showCommonDialog(context);
		}


	}

	@Override
	protected String doInBackground(String... arg0) {
		String mResult = null;

//		JSONObject json = new JSONObject();
		
		try {
			mInputStreamis = sSetconnection.connectionEstablished(url);
			Log.e("input stream", " " + mInputStreamis);
			if (mInputStreamis != null) {
				mResult = sSetconnection.converResponseToString(mInputStreamis);
				Log.e("Result for", ""+ mResult);
				isSuccess = true;
			} else {
				checkResponse = 2;
			}

		} catch (Exception e) {
			checkResponse = 6;
		}
		return mResult;
	}

	/**
	 * activateDriverCheckResponse 1 = flag(Email does not Exist) 2 = Error with
	 * HTTP connection 3 = Error while convert into string 4 = Failure 5 = Email
	 * Already Exist
	 */
	@TargetApi(Build.VERSION_CODES.HONEYCOMB)
	protected void onPostExecute(String _result) {

		if (isDialogDisplay){

			if (dialog.isShowing()) {
				cancelDialog();
			}

		}


		if (isSuccess) {
			listener.onPostSuccess(_result, receivedId, isSuccess);
		} else {
			listener.onPostError(receivedId, errorCode);
		}
	}

	
	// Common Progress bar
    public void showCommonDialog(Context mContext) {

    	/*mDialog = new ProgressDialog(mContext);
    	mDialog.setMessage("Loading Please wait ....");
    	mDialog.setIndeterminate(false);
    	mDialog.setProgressStyle(ProgressDialog.STYLE_SPINNER);
    	mDialog.setCancelable(false);
    	mDialog.show();*/

		dialog = new Dialog(mContext);
		dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
		dialog.getWindow().setBackgroundDrawable(new ColorDrawable(android.graphics.Color.TRANSPARENT));
		dialog.setContentView(R.layout.progress_pre);
		dialog.setCancelable(false);

		dialog.show();

    }

    // cancel progress dialog

    public void cancelDialog() {

        if (dialog != null) {
			dialog.cancel();

        } 
}
}

