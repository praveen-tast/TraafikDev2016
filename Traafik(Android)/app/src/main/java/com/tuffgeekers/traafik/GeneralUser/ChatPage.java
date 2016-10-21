package com.tuffgeekers.traafik.GeneralUser;

import android.app.Activity;
import android.content.Intent;
import android.os.AsyncTask;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;

import com.tuffgeekers.jsonfiles.MainAsynListener;
import com.tuffgeekers.jsonfiles.MainAsyncTask;
import com.tuffgeekers.traafik.R;
import com.tuffgeekers.traafik.TrafficManger.HomeManager;
import com.tuffgeekers.utils.Global;
import com.tuffgeekers.utils.SharedPref;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.List;
import java.util.Timer;
import java.util.TimerTask;

import cn.pedant.SweetAlert.SweetAlertDialog;

public class ChatPage extends Activity implements MainAsynListener<String>, View.OnClickListener {

    EditText txt_msg;
    ListView lv_contained_messages;
    ImageView iv_send;
    private int apiHit;
    LinearLayout llmainparent;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_chat_page);

        txt_msg = (EditText) findViewById(R.id.txt_msg);
        lv_contained_messages = (ListView) findViewById(R.id.lv_contained_messages);
        iv_send = (ImageView) findViewById(R.id.iv_send);
        llmainparent = (LinearLayout)findViewById(R.id.llmainparent);
        iv_send.setOnClickListener(this);


        new Timer().scheduleAtFixedRate(new TimerTask() {
            @Override
            public void run() {

                apiHit = 0;
                new MainAsyncTask(ChatPage.this, Global.BaseUrl + "message/getAll?toid=" + Global.send_to + "&fromid=" + SharedPref.get_UserId(ChatPage.this) + "&auth_code=" + Global.auth, 100, ChatPage.this, Global.json, false).execute();


            }
        }, 0, 6000);//put here time 1000 milliseconds=1 second


    }

    @Override
    public void onBackPressed() {
        finish();
    }

    @Override
    public void onPostSuccess(String result, int id, boolean isSucess) {
        if (apiHit == 0) {
            Log.e("response", "" + result);

        }
        else if(apiHit==1)
        {

            Log.e("send response", "" + result);
        }
    }

    @Override
    public void onPostError(int id, int error) {

    }

    @Override
    public void onClick(View v) {
        sendMessage();
    }

    private void sendMessage() {

        apiHit=1;
        String text_message = txt_msg.getText().toString();

        new MainAsyncTask(ChatPage.this, Global.BaseUrl + "message/create?Message[content]=" + text_message + "&Message[to_id]=" + Global.send_to + "&Message[from_id]=" + Global.userId, 100, ChatPage.this, Global.json, false).execute();

    }


    public void showSnackBar(String message){

        Snackbar snackbar = Snackbar.make(llmainparent, message, Snackbar.LENGTH_LONG);
        snackbar.show();

    }


}
