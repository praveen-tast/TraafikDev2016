package com.tuffgeekers.traafik;

import android.annotation.SuppressLint;
import android.app.IntentService;
import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.media.RingtoneManager;
import android.net.Uri;
import android.os.Bundle;
import android.os.Vibrator;
import android.preference.PreferenceManager;
import android.util.Log;

import com.google.android.gms.gcm.GoogleCloudMessaging;


import org.json.JSONArray;
import org.json.JSONObject;


public class GcmIntentService extends IntentService {

	SharedPreferences sharedPreferences;


	public GcmIntentService() {

		super("GCMIntentService");
	}

	@Override
	protected void onHandleIntent(Intent intent) {
		Bundle extras = intent.getExtras();
		Log.i("extras", "" + extras.toString());
		GoogleCloudMessaging gcm = GoogleCloudMessaging.getInstance(this);
		String messageType = gcm.getMessageType(intent);
		sharedPreferences= PreferenceManager.getDefaultSharedPreferences(this);
		if (!extras.isEmpty()) {

			if (GoogleCloudMessaging.MESSAGE_TYPE_SEND_ERROR
					.equals(messageType)) {
				Log.e("Error", "in gcm message");
			} else if (GoogleCloudMessaging.MESSAGE_TYPE_DELETED
					.equals(messageType)) {

				Log.e("Error", "in gcm message");
			} else if (GoogleCloudMessaging.MESSAGE_TYPE_MESSAGE
					.equals(messageType)) {

				Log.e("response_from_gcm", ""+ extras.toString());
				sendAllNotification(extras);

			}
		}

		GcmBroadcastReceiver.completeWakefulIntent(intent);

	}

	/*
	 * private void savePreferences(String request_id, String Request_id) {
	 * 
	 * SharedPreferences shared = getSharedPreferences(Globals.PREFS_USER,
	 * Context.MODE_PRIVATE); editor = shared.edit();
	 * editor.putString(request_id,Request_id); editor.commit();}
	 */
	private void sendAllNotification(Bundle extra) {
		Log.e("response are=====>", "" + extra.toString());
		// ================ASK For HELP=============>


				try {

					Notify(extra);

				} catch (Exception e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}


		}

		// ============================END==========================//



	@SuppressLint("NewApi")
	public void Notify(Bundle bundle) {
		String model_action=bundle.getString("model_action");
		String model_type=bundle.getString("model_type");


		Uri soundUri = RingtoneManager.getDefaultUri(RingtoneManager.TYPE_NOTIFICATION);
		// intent triggered, you can add other intent for other actions

		Vibrator v = (Vibrator) getSystemService(Context.VIBRATOR_SERVICE);
		long[] pattern = {0, 100, 1000};

	}

}