package com.tuffgeekers.traafik;

import android.app.Activity;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.Html;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.tuffgeekers.Adapter.MyMarker;
import com.tuffgeekers.Loader.Image_Loader;
import com.tuffgeekers.utils.AutoResizeTextView;
import com.tuffgeekers.utils.Global;

import java.io.IOException;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.URL;

public class DetailedViewLocation extends Activity implements View.OnClickListener{

    ImageView iv_back_detail, iv_main;
    TextView tv_type, tv_created;
    TextView tv_address;
    Image_Loader imgload;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detailed_view_location);

        initializeViews();
        imgload = new Image_Loader(this);
        iv_back_detail.setOnClickListener(this);

        imgload.DisplayImage(Global.detailImage,R.drawable.ic_launcher, iv_main, false );

        String type = "<font color=#fd5722>  <u> "+Global.detailType+" </u></font>";
        String address = "<font color=#fd5722>Location: </font> <font color=#000000>"+Global.detailAddress+"</font>";
        String created = "<font color=#fd5722>Created at: </font> <font color=#000000>"+Global.detailCreated+"</font>";

        tv_address.setText(Html.fromHtml(address));
        tv_type.setText(Html.fromHtml(type));
        tv_created.setText(Html.fromHtml(created));

    }

    @Override
    public void onBackPressed() {
        finish();
    }

    public void initializeViews(){

        iv_back_detail = (ImageView)findViewById(R.id.iv_back_detail);
        iv_main = (ImageView)findViewById(R.id.iv_main);

        tv_type = (TextView)findViewById(R.id.tv_type);
        tv_created = (TextView)findViewById(R.id.tv_created);
        tv_address = (TextView)findViewById(R.id.tv_address);

    }

    @Override
    public void onClick(View v) {
        if (v==iv_back_detail){
            onBackPressed();
        }
    }





}
