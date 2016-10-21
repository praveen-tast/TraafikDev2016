package com.tuffgeekers.Adapter;

import android.app.Activity;
import android.content.Context;
import android.text.Html;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.tuffgeekers.Loader.Image_Loader;
import com.tuffgeekers.circularImageView.CircularImageView;
import com.tuffgeekers.traafik.R;

import java.util.ArrayList;
import java.util.HashMap;


public class NearByUserAdapter extends BaseAdapter {

	Context context;
	ArrayList<HashMap<String, String>> list;
	Image_Loader imgLoad;

	public NearByUserAdapter(Context context, ArrayList<HashMap<String, String>> arr_list) {
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
			convertView = mInflater.inflate(R.layout.adp_nearby, null);
			holder = new ViewHolder();
			
			holder.iv_image = (CircularImageView)convertView.findViewById(R.id.iv_image);
			holder.tv_type = (TextView)convertView.findViewById(R.id.tv_type);

			
			convertView.setTag(holder);
		} else {
			holder = (ViewHolder) convertView.getTag();
		}
		
			
		
		try {


			holder.tv_type.setText(""+list.get(arg0).get("Userfull_name"));

			String Userimage_file = list.get(arg0).get("Userimage_file");
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
		public TextView tv_type;

	
	}
}
