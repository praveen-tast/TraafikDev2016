package com.tuffgeekers.traafik.GeneralUser;

import android.app.Activity;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.Typeface;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;

import com.navdrawer.SimpleSideDrawer;
import com.tuffgeekers.traafik.EditProfile;
import com.tuffgeekers.traafik.GoslowDetails;
import com.tuffgeekers.traafik.MyTraffic;
import com.tuffgeekers.traafik.R;
import com.tuffgeekers.traafik.Setting;
import com.tuffgeekers.traafik.TraafikFeed;
import com.tuffgeekers.traafik.TrafficManger.FriendLocation;
import com.tuffgeekers.traafik.TrafficManger.Inbox;
import com.tuffgeekers.utils.AutoResizeTextView;

/**
 * Created by hitesh on 2/17/16.
 */
public class Slider extends Activity {
    SimpleSideDrawer drawer_left, drawer_right;
    LinearLayout ll_navigate, ll_traafik, ll_inbox, ll_send, ll_setting, ll_sounds, ll_share_location,ll_advertise, ll_goslow, ll_police, ll_accident, ll_traafic_chat, ll_hazard, ll_place, ll_road_closed, ll_checkin, ll_traafik_feed;
    public static int flag_rightDrawer = 0;
    public static int flag_leftDrawer = 0;
    public AutoResizeTextView profile_name_slider, tv_sound_slider, tv_adv_slider, tv_send_slider, tv_mytraafik_slider, profile_post_slider, tv_setting_slider, tv_navigation_slider, tv_inbox_slider;
    private Typeface tf;
    ImageView ll_logout;
    LinearLayout nullClicker;

    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        drawer_left = new SimpleSideDrawer(this);
        drawer_left.setLeftBehindContentView(R.layout.activity_slider_menu);

        drawer_right = new SimpleSideDrawer(this);
        drawer_right.setRightBehindContentView(R.layout.activity_report_menu);

        initializeViews();

        ll_police.setEnabled(false);

        //setTypeface();
        ll_navigate.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ll_navigateClick();
            }
        });
        ll_traafik.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ll_traafikClick();
            }
        });
        ll_inbox.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ll_inboxClick();
            }
        });
        ll_send.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ll_sendClick();
            }
        });
        ll_setting.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ll_settingClick();
            }
        });
        ll_sounds.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ll_soundsClick();
            }
        });
        ll_advertise.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ll_advertiseClick();
            }
        });
        ll_share_location.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ll_sharelocationClick();
            }
        });

        //clicklistener on right drawer
        ll_goslow.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ll_goslowClick();
            }
        });
        ll_police.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ll_policeClick();
            }
        });
        ll_accident.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ll_accidentClick();
            }
        });
        ll_hazard.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ll_hazardClick();
            }
        });
        ll_traafic_chat.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ll_traafic_chatClick();
            }
        });
        ll_place.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ll_placeClick();
            }
        });
        ll_road_closed.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ll_road_closedClick();
            }
        });
        ll_checkin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ll_checkinClick();
            }
        });
        ll_traafik_feed.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ll_traafik_feedClick();
            }
        });


        nullClicker.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Log.d("<>", "<>");
            }
        });


       // ll_inbox.setVisibility(View.GONE);
        ll_send.setVisibility(View.GONE);
        ll_sounds.setVisibility(View.GONE);

    }

   /* private void setTypeface() {

        tf = Typeface.createFromAsset(this.getAssets(), "Roboto-Light.ttf");
        profile_name_slider.setTypeface(tf);
        profile_post_slider.setTypeface(tf);
        tv_navigation_slider.setTypeface(tf);
        tv_mytraafik_slider.setTypeface(tf);
        tv_inbox_slider.setTypeface(tf);
        tv_setting_slider.setTypeface(tf);
        tv_adv_slider.setTypeface(tf);
        tv_send_slider.setTypeface(tf);
        tv_sound_slider.setTypeface(tf);
    }*/

    private void initializeViews() {
        //layout of left drawer
        ll_navigate = (LinearLayout) findViewById(R.id.ll_navigate);
        ll_traafik = (LinearLayout) findViewById(R.id.ll_traafik);
        ll_inbox = (LinearLayout) findViewById(R.id.ll_inbox);
        ll_send = (LinearLayout) findViewById(R.id.ll_send);
        ll_setting = (LinearLayout) findViewById(R.id.ll_setting);
        ll_sounds = (LinearLayout) findViewById(R.id.ll_sounds);
        ll_advertise = (LinearLayout) findViewById(R.id.ll_advertise);
        ll_share_location = (LinearLayout) findViewById(R.id.ll_share_location);

        //layout of right drawer
        ll_goslow = (LinearLayout) findViewById(R.id.ll_goslow);
        ll_police = (LinearLayout) findViewById(R.id.ll_police);
        ll_accident = (LinearLayout) findViewById(R.id.ll_accident);
        ll_hazard = (LinearLayout) findViewById(R.id.ll_hazard);
        ll_traafic_chat = (LinearLayout) findViewById(R.id.ll_traafic_chat);
        ll_place = (LinearLayout) findViewById(R.id.ll_place);
        ll_road_closed = (LinearLayout) findViewById(R.id.ll_road_closed);
        ll_checkin = (LinearLayout) findViewById(R.id.ll_checkin);
        ll_traafik_feed = (LinearLayout) findViewById(R.id.ll_traafik_feed);
        nullClicker = (LinearLayout)findViewById(R.id.nullClicker);


        //textview of left drawer
        profile_name_slider = (AutoResizeTextView) findViewById(R.id.profile_name_slider);
        profile_post_slider = (AutoResizeTextView) findViewById(R.id.profile_post_slider);
        tv_navigation_slider = (AutoResizeTextView) findViewById(R.id.tv_navigation_slider);
        tv_mytraafik_slider = (AutoResizeTextView) findViewById(R.id.tv_mytraafik_slider);
        tv_inbox_slider = (AutoResizeTextView) findViewById(R.id.tv_inbox_slider);
        tv_setting_slider = (AutoResizeTextView) findViewById(R.id.tv_setting_slider);
        tv_adv_slider = (AutoResizeTextView) findViewById(R.id.tv_adv_slider);
        tv_send_slider = (AutoResizeTextView) findViewById(R.id.tv_send_slider);
        tv_sound_slider = (AutoResizeTextView) findViewById(R.id.tv_sound_slider);

        ll_logout = (ImageView)findViewById(R.id.ll_logout);

    }


    private void ll_goslowClick() {
        flag_rightDrawer = 1;
        ll_goslow.setBackgroundColor(Color.parseColor("#D6512A"));
        ll_police.setBackgroundColor(Color.parseColor("#515151"));
        ll_accident.setBackgroundColor(Color.parseColor("#515151"));
        ll_hazard.setBackgroundColor(Color.parseColor("#515151"));
        ll_traafic_chat.setBackgroundColor(Color.parseColor("#515151"));
        ll_place.setBackgroundColor(Color.parseColor("#515151"));
        ll_road_closed.setBackgroundColor(Color.parseColor("#515151"));
        ll_checkin.setBackgroundColor(Color.parseColor("#515151"));
        ll_traafik_feed.setBackgroundColor(Color.parseColor("#515151"));


        Intent goslow = new Intent(Slider.this, GoslowDetails.class);
        startActivity(goslow);

    }

    private void ll_policeClick() {
        flag_rightDrawer = 2;
        ll_goslow.setBackgroundColor(Color.parseColor("#515151"));
        ll_police.setBackgroundColor(Color.parseColor("#D6512A"));
        ll_accident.setBackgroundColor(Color.parseColor("#515151"));
        ll_hazard.setBackgroundColor(Color.parseColor("#515151"));
        ll_traafic_chat.setBackgroundColor(Color.parseColor("#515151"));
        ll_place.setBackgroundColor(Color.parseColor("#515151"));
        ll_road_closed.setBackgroundColor(Color.parseColor("#515151"));
        ll_checkin.setBackgroundColor(Color.parseColor("#515151"));
        ll_traafik_feed.setBackgroundColor(Color.parseColor("#515151"));


        Intent goslow = new Intent(Slider.this, GoslowDetails.class);
        startActivity(goslow);

    }


    private void ll_accidentClick() {
        flag_rightDrawer = 3;
        ll_goslow.setBackgroundColor(Color.parseColor("#515151"));
        ll_police.setBackgroundColor(Color.parseColor("#515151"));
        ll_accident.setBackgroundColor(Color.parseColor("#D6512A"));
        ll_hazard.setBackgroundColor(Color.parseColor("#515151"));
        ll_traafic_chat.setBackgroundColor(Color.parseColor("#515151"));
        ll_place.setBackgroundColor(Color.parseColor("#515151"));
        ll_road_closed.setBackgroundColor(Color.parseColor("#515151"));
        ll_checkin.setBackgroundColor(Color.parseColor("#515151"));
        ll_traafik_feed.setBackgroundColor(Color.parseColor("#515151"));


        Intent goslow = new Intent(Slider.this, GoslowDetails.class);
        startActivity(goslow);

    }

    private void ll_hazardClick() {
        flag_rightDrawer = 4;
        ll_goslow.setBackgroundColor(Color.parseColor("#515151"));
        ll_police.setBackgroundColor(Color.parseColor("#515151"));
        ll_accident.setBackgroundColor(Color.parseColor("#515151"));
        ll_hazard.setBackgroundColor(Color.parseColor("#D6512A"));
        ll_traafic_chat.setBackgroundColor(Color.parseColor("#515151"));
        ll_place.setBackgroundColor(Color.parseColor("#515151"));
        ll_road_closed.setBackgroundColor(Color.parseColor("#515151"));
        ll_checkin.setBackgroundColor(Color.parseColor("#515151"));
        ll_traafik_feed.setBackgroundColor(Color.parseColor("#515151"));

        Intent goslow = new Intent(Slider.this, GoslowDetails.class);
        startActivity(goslow);

    }

    private void ll_traafic_chatClick() {
        flag_rightDrawer = 5;
        ll_goslow.setBackgroundColor(Color.parseColor("#515151"));
        ll_police.setBackgroundColor(Color.parseColor("#515151"));
        ll_accident.setBackgroundColor(Color.parseColor("#515151"));
        ll_hazard.setBackgroundColor(Color.parseColor("#515151"));
        ll_traafic_chat.setBackgroundColor(Color.parseColor("#D6512A"));
        ll_place.setBackgroundColor(Color.parseColor("#515151"));
        ll_road_closed.setBackgroundColor(Color.parseColor("#515151"));
        ll_checkin.setBackgroundColor(Color.parseColor("#515151"));
        ll_traafik_feed.setBackgroundColor(Color.parseColor("#515151"));


        Intent goslow = new Intent(Slider.this, TrafficChat.class);
        startActivity(goslow);
        overridePendingTransition(android.R.anim.slide_in_left,android.R.anim.slide_out_right);

    }

    private void ll_placeClick() {
        flag_rightDrawer = 6;
        ll_goslow.setBackgroundColor(Color.parseColor("#515151"));
        ll_police.setBackgroundColor(Color.parseColor("#515151"));
        ll_accident.setBackgroundColor(Color.parseColor("#515151"));
        ll_hazard.setBackgroundColor(Color.parseColor("#515151"));
        ll_traafic_chat.setBackgroundColor(Color.parseColor("#515151"));
        ll_place.setBackgroundColor(Color.parseColor("#D6512A"));
        ll_road_closed.setBackgroundColor(Color.parseColor("#515151"));
        ll_checkin.setBackgroundColor(Color.parseColor("#515151"));
        ll_traafik_feed.setBackgroundColor(Color.parseColor("#515151"));

        Intent goslow = new Intent(Slider.this, GoslowDetails.class);
        startActivity(goslow);
    }

    private void ll_road_closedClick() {
        flag_rightDrawer = 7;
        ll_goslow.setBackgroundColor(Color.parseColor("#515151"));
        ll_police.setBackgroundColor(Color.parseColor("#515151"));
        ll_accident.setBackgroundColor(Color.parseColor("#515151"));
        ll_hazard.setBackgroundColor(Color.parseColor("#515151"));
        ll_traafic_chat.setBackgroundColor(Color.parseColor("#515151"));
        ll_place.setBackgroundColor(Color.parseColor("#515151"));
        ll_road_closed.setBackgroundColor(Color.parseColor("#D6512A"));
        ll_checkin.setBackgroundColor(Color.parseColor("#515151"));
        ll_traafik_feed.setBackgroundColor(Color.parseColor("#515151"));


        Intent goslow = new Intent(Slider.this, GoslowDetails.class);
        startActivity(goslow);

    }

    private void ll_checkinClick() {
        flag_rightDrawer = 8;
        ll_goslow.setBackgroundColor(Color.parseColor("#515151"));
        ll_police.setBackgroundColor(Color.parseColor("#515151"));
        ll_accident.setBackgroundColor(Color.parseColor("#515151"));
        ll_hazard.setBackgroundColor(Color.parseColor("#515151"));
        ll_traafic_chat.setBackgroundColor(Color.parseColor("#515151"));
        ll_place.setBackgroundColor(Color.parseColor("#515151"));
        ll_road_closed.setBackgroundColor(Color.parseColor("#515151"));
        ll_checkin.setBackgroundColor(Color.parseColor("#D6512A"));
        ll_traafik_feed.setBackgroundColor(Color.parseColor("#515151"));

        Intent goslow = new Intent(Slider.this, GoslowDetails.class);
        startActivity(goslow);
    }

    private void ll_traafik_feedClick() {
        flag_rightDrawer = 9;
        ll_goslow.setBackgroundColor(Color.parseColor("#515151"));
        ll_police.setBackgroundColor(Color.parseColor("#515151"));
        ll_accident.setBackgroundColor(Color.parseColor("#515151"));
        ll_hazard.setBackgroundColor(Color.parseColor("#515151"));
        ll_traafic_chat.setBackgroundColor(Color.parseColor("#515151"));
        ll_place.setBackgroundColor(Color.parseColor("#515151"));
        ll_road_closed.setBackgroundColor(Color.parseColor("#515151"));
        ll_checkin.setBackgroundColor(Color.parseColor("#515151"));
        ll_traafik_feed.setBackgroundColor(Color.parseColor("#D6512A"));

     /*   Intent goslow = new Intent(Slider.this, TraafikFeed.class);
        startActivity(goslow);*/
    }

    //methods of left drawer
    private void ll_navigateClick() {
flag_leftDrawer=1;

        ll_navigate.setBackgroundColor(Color.parseColor("#D6512A"));
        ll_traafik.setBackgroundColor(Color.parseColor("#515151"));
        ll_inbox.setBackgroundColor(Color.parseColor("#515151"));
        ll_send.setBackgroundColor(Color.parseColor("#515151"));
        ll_setting.setBackgroundColor(Color.parseColor("#515151"));
        ll_sounds.setBackgroundColor(Color.parseColor("#515151"));
        ll_advertise.setBackgroundColor(Color.parseColor("#515151"));



    }

    private void ll_traafikClick() {
        Log.d("----CLICK", "trafik");
        ll_navigate.setBackgroundColor(Color.parseColor("#515151"));
        ll_traafik.setBackgroundColor(Color.parseColor("#D6512A"));
        ll_inbox.setBackgroundColor(Color.parseColor("#515151"));
        ll_send.setBackgroundColor(Color.parseColor("#515151"));
        ll_setting.setBackgroundColor(Color.parseColor("#515151"));
        ll_sounds.setBackgroundColor(Color.parseColor("#515151"));
        ll_advertise.setBackgroundColor(Color.parseColor("#515151"));


        Intent edit = new Intent(Slider.this, MyTraffic.class);
        startActivity(edit);

    }

    private void ll_inboxClick() {
        ll_navigate.setBackgroundColor(Color.parseColor("#515151"));
        ll_traafik.setBackgroundColor(Color.parseColor("#515151"));
        ll_inbox.setBackgroundColor(Color.parseColor("#D6512A"));
        ll_send.setBackgroundColor(Color.parseColor("#515151"));
        ll_setting.setBackgroundColor(Color.parseColor("#515151"));
        ll_sounds.setBackgroundColor(Color.parseColor("#515151"));
        ll_advertise.setBackgroundColor(Color.parseColor("#515151"));

        Intent inbox=new Intent(Slider.this, Inbox.class);
        startActivity(inbox);
    }

    private void ll_sendClick() {
        ll_navigate.setBackgroundColor(Color.parseColor("#515151"));
        ll_traafik.setBackgroundColor(Color.parseColor("#515151"));
        ll_inbox.setBackgroundColor(Color.parseColor("#515151"));
        ll_send.setBackgroundColor(Color.parseColor("#D6512A"));
        ll_setting.setBackgroundColor(Color.parseColor("#515151"));
        ll_sounds.setBackgroundColor(Color.parseColor("#515151"));
        ll_advertise.setBackgroundColor(Color.parseColor("#515151"));
    }

    private void ll_settingClick() {
        ll_navigate.setBackgroundColor(Color.parseColor("#515151"));
        ll_traafik.setBackgroundColor(Color.parseColor("#515151"));
        ll_inbox.setBackgroundColor(Color.parseColor("#515151"));
        ll_send.setBackgroundColor(Color.parseColor("#515151"));
        ll_setting.setBackgroundColor(Color.parseColor("#D6512A"));
        ll_sounds.setBackgroundColor(Color.parseColor("#515151"));
        ll_advertise.setBackgroundColor(Color.parseColor("#515151"));


        Intent setting = new Intent(Slider.this, Setting.class);
        startActivity(setting);

    }

    private void ll_soundsClick() {
        ll_navigate.setBackgroundColor(Color.parseColor("#515151"));
        ll_traafik.setBackgroundColor(Color.parseColor("#515151"));
        ll_inbox.setBackgroundColor(Color.parseColor("#515151"));
        ll_send.setBackgroundColor(Color.parseColor("#515151"));
        ll_setting.setBackgroundColor(Color.parseColor("#515151"));
        ll_sounds.setBackgroundColor(Color.parseColor("#D6512A"));
        ll_advertise.setBackgroundColor(Color.parseColor("#515151"));
    }

    private void ll_advertiseClick() {
        ll_navigate.setBackgroundColor(Color.parseColor("#515151"));
        ll_traafik.setBackgroundColor(Color.parseColor("#515151"));
        ll_inbox.setBackgroundColor(Color.parseColor("#515151"));
        ll_send.setBackgroundColor(Color.parseColor("#515151"));
        ll_setting.setBackgroundColor(Color.parseColor("#515151"));
        ll_sounds.setBackgroundColor(Color.parseColor("#515151"));
        ll_advertise.setBackgroundColor(Color.parseColor("#D6512A"));
        ll_share_location.setBackgroundColor(Color.parseColor("#515151"));
        Intent friend=new Intent(Slider.this, FriendLocation.class);
        startActivity(friend);


    }


    private void ll_sharelocationClick() {
        ll_navigate.setBackgroundColor(Color.parseColor("#515151"));
        ll_traafik.setBackgroundColor(Color.parseColor("#515151"));
        ll_inbox.setBackgroundColor(Color.parseColor("#515151"));
        ll_send.setBackgroundColor(Color.parseColor("#515151"));
        ll_setting.setBackgroundColor(Color.parseColor("#515151"));
        ll_sounds.setBackgroundColor(Color.parseColor("#515151"));
        ll_advertise.setBackgroundColor(Color.parseColor("#515151"));
        ll_share_location.setBackgroundColor(Color.parseColor("#D6512A"));


    }
}
