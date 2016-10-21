package com.tuffgeekers.Adapter;

import android.app.Activity;
import android.content.Context;
import android.text.Html;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.tuffgeekers.traafik.R;

import java.util.ArrayList;
import java.util.HashMap;


public class ChatAdapter extends BaseAdapter {

	Context context;
	ArrayList<HashMap<String, String>> list;

	public ChatAdapter(Context context, ArrayList<HashMap<String, String>> arr_list) {
		this.context = context;
		this.list = arr_list;


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
			convertView = mInflater.inflate(R.layout.adap_echat, null);
			holder = new ViewHolder();
			
			//holder.iv_image = (ImageView)convertView.findViewById(R.id.iv_image);
			holder.otherSide = (TextView) convertView.findViewById(R.id.otherSide_msg);
			holder.mySide_msg = (TextView) convertView.findViewById(R.id.mySide_msg);


			convertView.setTag(holder);
		} else {
			holder = (ViewHolder) convertView.getTag();


		}
		
			
		
		try {

		//	holder.tv_createdAt.setText(Html.fromHtml(crea));


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

		public TextView otherSide, mySide_msg;

	
	}
}
