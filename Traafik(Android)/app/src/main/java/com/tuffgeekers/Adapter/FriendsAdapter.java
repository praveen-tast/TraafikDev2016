package com.tuffgeekers.Adapter;

import android.app.Activity;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.tuffgeekers.Loader.Image_Loader;
import com.tuffgeekers.circularImageView.CircularImageView;
import com.tuffgeekers.traafik.R;

import java.util.ArrayList;
import java.util.HashMap;

/**
 * Created by tuff on 04-Apr-16.
 */
public class FriendsAdapter extends BaseAdapter

    {

        Context context;
        ArrayList<HashMap<String, String>> list;
        Image_Loader imgLoad;

        public FriendsAdapter(Context context, ArrayList<HashMap<String, String>> arr_list) {
        this.context = context;
        this.list = arr_list;
        imgLoad = new Image_Loader(context);


    }

        @Override
        public int getCount() {
        // TODO Auto-generated method stub
        return list.size();
    }

        @Override
        public Object getItem(int arg0) {
        // TODO Auto-generated method stub
        return list.get(arg0);
    }

        @Override
        public long getItemId(int arg0) {
        // TODO Auto-generated method stub
        return 0;
    }

        @Override
        public View getView(final int arg0, View convertView, ViewGroup arg2) {
        ViewHolder holder = null;

        LayoutInflater mInflater = (LayoutInflater) context
                .getSystemService(Activity.LAYOUT_INFLATER_SERVICE);
        if (convertView == null) {
            convertView = mInflater.inflate(R.layout.activity_friend_list, null);
            holder = new ViewHolder();

            holder.iv_image = (CircularImageView)convertView.findViewById(R.id.iv_image);
            holder.tv_name = (TextView)convertView.findViewById(R.id.tv_name);


            convertView.setTag(holder);
        } else {
            holder = (ViewHolder) convertView.getTag();
        }



        try {


            holder.tv_name.setText(""+list.get(arg0).get("friend_name"));

            String Userimage_file = list.get(arg0).get("friend_image");
            imgLoad.DisplayImage(Userimage_file, R.drawable.ic_launcher, holder.iv_image,false);



        } catch (Exception e) {
            // TODO: handle exception
            e.printStackTrace();
        }

        //holder.tv_name.setText(list.get(arg0));
        return convertView;



    }

        @Override
        public int getItemViewType(int position) {
        // TODO Auto-generated method stub
        return position;
    }

        @Override
        public int getViewTypeCount() {
        // TODO Auto-generated method stub
        return getCount();
    }

        class ViewHolder {

            public CircularImageView iv_image;
            public TextView tv_name;


        }
    }
