package com.tuffgeekers.traafik.GeneralUser;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.widget.AdapterView;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.Toast;

import com.google.android.gms.drive.events.ChangeEvent;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.CameraPosition;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;
import com.skyfishjy.library.RippleBackground;
import com.tuffgeekers.Adapter.MatchesAdapter;
import com.tuffgeekers.Adapter.NearByUserAdapter;
import com.tuffgeekers.jsonfiles.MainAsynListener;
import com.tuffgeekers.jsonfiles.MainAsyncTask;
import com.tuffgeekers.traafik.R;
import com.tuffgeekers.utils.Global;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;

import cn.pedant.SweetAlert.SweetAlertDialog;

public class TrafficChat extends Activity implements MainAsynListener<String>{

    RippleBackground rippleBackground;
    ImageView icon_sample;
    ListView lv_nearBy;
    ArrayList<HashMap<String, String>> matchesListArr = new ArrayList<HashMap<String, String>>();
    HashMap<String, String> hshListCategory;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_traffic_chat);

        rippleBackground=(RippleBackground)findViewById(R.id.content);
        icon_sample = (ImageView)findViewById(R.id.icon_sample);
        lv_nearBy = (ListView)findViewById(R.id.lv_nearBy);
        rippleBackground.startRippleAnimation();

        new MainAsyncTask(TrafficChat.this, Global.BaseUrl+"user/nearByUsers/radius/300/id/25", 100, TrafficChat.this, Global.json, false).execute();

    }

    @Override
    public void onBackPressed() {
        finish();
    }

    @Override
    public void onPostSuccess(String result, int id, boolean isSucess) {


        rippleBackground.setVisibility(View.GONE);
        icon_sample.setVisibility(View.GONE);
        if (isSucess){


            // Log.e("re<><><><>", result);

            try {
                JSONObject managerinfo = new JSONObject(result);

                String status = managerinfo.getString("status");

                if (status.equalsIgnoreCase("NOK")) {


                }

                else if (status.equalsIgnoreCase("OK")) {


                    JSONArray ja = managerinfo.getJSONArray("list");

                    if (ja.length()==0){

                        Toast.makeText(TrafficChat.this, "No Users Found NearBy", Toast.LENGTH_SHORT).show();
                        finish();

                    }

                    else {


                        for (int arr = 0; arr < ja.length(); arr++) {
                            JSONObject json1 = ja.getJSONObject(arr);

                            Log.e("length", "" + ja.length());
                            // Getting JSON Array node
                            String UserId = json1.getString("id");
                            String Userfull_name = json1.getString("full_name");
                            String Userimage_file = json1.getString("image_file");

                            Log.e("userID", ""+UserId);
                            Log.e("Userfull_name", ""+Userfull_name);
                            Log.e("Userimage_file", ""+Userimage_file);

                            hshListCategory = new HashMap<String, String>();
                            hshListCategory.put("Userfull_name", Userfull_name);
                            hshListCategory.put("Userimage_file", Userimage_file);
                            hshListCategory.put("UserId", UserId);

                            matchesListArr.add(hshListCategory);

                            NearByUserAdapter pop_adap = new NearByUserAdapter(TrafficChat.this, matchesListArr);
                            lv_nearBy.setAdapter(pop_adap);

                            lv_nearBy.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                                @Override
                                public void onItemClick(AdapterView<?> parent, View view, int position, long id) {

                                    String from_id=matchesListArr.get(position).get("UserId");
                                    Global.send_to=from_id;
                                    Intent in = new Intent(TrafficChat.this, ChatPage.class);
                                    startActivity(in);

                                }
                            });
                        }
                    }
                }



            } catch (Exception e) {

                e.printStackTrace();
                Toast.makeText(TrafficChat.this, "Please try again later", Toast.LENGTH_SHORT).show();

            }
        }


    }

    @Override
    public void onPostError(int id, int error) {

    }
}
