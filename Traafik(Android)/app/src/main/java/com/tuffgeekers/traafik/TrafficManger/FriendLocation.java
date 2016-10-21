package com.tuffgeekers.traafik.TrafficManger;

import android.app.Activity;
import android.content.Intent;
import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.widget.AdapterView;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;

import com.tuffgeekers.Adapter.FriendsAdapter;
import com.tuffgeekers.Adapter.NearByUserAdapter;
import com.tuffgeekers.jsonfiles.MainAsynListener;
import com.tuffgeekers.jsonfiles.MainAsyncTask;
import com.tuffgeekers.traafik.Login;
import com.tuffgeekers.traafik.R;
import com.tuffgeekers.utils.Global;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;


public class FriendLocation extends Activity implements MainAsynListener<String>, View.OnClickListener {

    private TextView tv_noFriend;
    private ListView lv_list;
    private StringBuilder sb;
    private HashMap<String, String> hshListFriend;
    private ArrayList<HashMap<String, String>> matchesListArr = new ArrayList<HashMap<String, String>>();
    private ImageView iv_gobackmy;
    ;

    @Override
    protected void onCreate(Bundle savedInstanceState) {

        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_friends_location);
        intializeViews();

        iv_gobackmy.setOnClickListener(this);
        new MainAsyncTask(FriendLocation.this, Global.BaseUrl + "user/viewAllLocation/id/" + Global.userId, 100, FriendLocation.this, Global.json, true).execute();
    }

    private void intializeViews() {
        tv_noFriend = (TextView) findViewById(R.id.tv_noFriend);
        lv_list = (ListView) findViewById(R.id.lv_list);
        iv_gobackmy=(ImageView)findViewById(R.id.iv_gobackmy);


    }


    @Override
    public void onPostSuccess(String result, int id, boolean isSucess) {
        Log.e("response", "" + result);
        try {
            JSONObject obj = new JSONObject(result);
            String status = obj.getString("status");


            if (status.equalsIgnoreCase("NOK")) {
                String message = obj.getString("message");
                Log.e("mesage",message);
                tv_noFriend.setVisibility(View.VISIBLE);
                lv_list.setVisibility(View.GONE);

            } else if (status.equalsIgnoreCase("OK")) {
                JSONArray user = obj.getJSONArray("user");


                for (int i = 0; i <= user.length(); i++) {
                    JSONObject obj2 = user.getJSONObject(i);
                    String friend_id = obj2.getString("id");
                    String friend_name = obj2.getString("full_name");
                    String friend_image = obj2.getString("image_file");
                    Log.e("friend_id", friend_id);
                    Log.e("friend_name", friend_name);
                    Log.e("friend_image", friend_image);

                    hshListFriend = new HashMap<String, String>();
                    hshListFriend.put("friend_id", friend_id);
                    hshListFriend.put("friend_name", friend_name);
                    hshListFriend.put("friend_image", friend_image);

                    matchesListArr.add(hshListFriend);

                    FriendsAdapter pop_adap = new FriendsAdapter(FriendLocation.this, matchesListArr);
                    lv_list.setAdapter(pop_adap);
                    lv_list.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                        @Override
                        public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                            String selected_id = matchesListArr.get(position).get("friend_id");
                            Log.e("friend_id", selected_id);
                            Global.friend_id = selected_id;
                            Intent fr_map = new Intent(FriendLocation.this, FriendMap.class);
                            startActivity(fr_map);

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
        finish();
    }
}
