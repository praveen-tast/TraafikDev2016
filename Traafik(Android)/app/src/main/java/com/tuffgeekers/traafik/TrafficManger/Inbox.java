package com.tuffgeekers.traafik.TrafficManger;

import android.app.Activity;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;

import com.tuffgeekers.Adapter.FriendsAdapter;
import com.tuffgeekers.Adapter.InboxAdapter;
import com.tuffgeekers.jsonfiles.MainAsynListener;
import com.tuffgeekers.jsonfiles.MainAsyncTask;
import com.tuffgeekers.traafik.GeneralUser.ChatPage;
import com.tuffgeekers.traafik.R;
import com.tuffgeekers.utils.Global;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;

public class Inbox extends Activity implements MainAsynListener<String>, View.OnClickListener {

    private TextView tv_nomessage;
    private ListView inbox_list;
    private HashMap<String, String> hshListInbox;
    private ArrayList<HashMap<String, String>> matchesListArr = new ArrayList<HashMap<String, String>>();
    private ImageView iv_gobackmy;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_inbox);
        intializeView();
        new MainAsyncTask(Inbox.this, Global.BaseUrl + "message/getAllMessage/fromid/" + Global.userId, 100, Inbox.this, Global.json, true).execute();
        iv_gobackmy.setOnClickListener(this);
    }

    private void intializeView() {

        tv_nomessage = (TextView) findViewById(R.id.tv_nomessage);
        inbox_list = (ListView) findViewById(R.id.inbox_list);
        iv_gobackmy = (ImageView) findViewById(R.id.iv_gobackmy);


    }

    @Override
    public void onBackPressed() {
        super.onBackPressed();
        finish();
    }

    @Override
    public void onPostSuccess(String result, int id, boolean isSucess) {
        Log.e("response of inbox", "" + result);
        try {
            JSONObject obj = new JSONObject(result);
            String status = obj.getString("status");
            if (status.equalsIgnoreCase("OK")) {
                JSONArray message = obj.getJSONArray("list");
                for (int i = 0; i < message.length(); i++) {
                    JSONObject obj2 = message.getJSONObject(i);
                    String content = obj2.getString("content");
                    String to_username = obj2.getString("to_username");
                    String file_path = obj2.getString("file_path");
                    String from_id = obj2.getString("from_id");
                    Log.e("content", content);
                    Log.e("to_username", to_username);
                    Log.e("file_path", file_path);
                    Log.e("from_id", from_id);

                    hshListInbox = new HashMap<String, String>();
                    hshListInbox.put("content", content);
                    hshListInbox.put("to_username", to_username);
                    hshListInbox.put("file_path", file_path);

                    hshListInbox.put("from_id", from_id);

                    matchesListArr.add(hshListInbox);

                    InboxAdapter pop_adap = new InboxAdapter(Inbox.this, matchesListArr);
                    inbox_list.setAdapter(pop_adap);
                    inbox_list.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                        @Override
                        public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                            String from_id = matchesListArr.get(position).get("from_id");
                            Log.e("from id", from_id);
                            Global.send_to = from_id;

                            Intent chat = new Intent(Inbox.this, ChatPage.class);
                            startActivity(chat);
                        }
                    });

                }
            }
        } catch (Exception e) {
            e.printStackTrace();
        }

    }

    @Override
    public void onPostError(int id, int error) {

    }

    @Override
    public void onClick(View v) {
        onBackPressed();
    }
}
