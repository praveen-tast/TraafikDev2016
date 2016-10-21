package com.tuffgeekers.Adapter;

import java.util.ArrayList;
import java.util.HashMap;

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

import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;
import com.tuffgeekers.traafik.R;


public class MatchesAdapter extends BaseAdapter {

	Context context;
	ArrayList<HashMap<String, String>> list;

	public MatchesAdapter(Context context, ArrayList<HashMap<String, String>> arr_list) {
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
			convertView = mInflater.inflate(R.layout.adap_list_trafic, null);
			holder = new ViewHolder();
			
			holder.iv_image = (ImageView)convertView.findViewById(R.id.iv_image);
			holder.tv_type = (TextView)convertView.findViewById(R.id.tv_type);
			holder.tv_description = (TextView)convertView.findViewById(R.id.tv_description);
			holder.tv_address = (TextView)convertView.findViewById(R.id.tv_address);
			holder.tv_createdAt = (TextView)convertView.findViewById(R.id.tv_createdAt);

			
			convertView.setTag(holder);
		} else {
			holder = (ViewHolder) convertView.getTag();
		}
		
			
		
		try {

			String desc = "<font color=#fd5722>Description: </font> <font color=#000000>"+list.get(arg0).get("post_content")+"</font>";
			String addr = "<font color=#fd5722>At: </font> <font color=#000000>"+list.get(arg0).get("file_address")+"</font>";
			String crea = "<font color=#fd5722>Created at : </font> <font color=#000000>"+list.get(arg0).get("file_create_time")+"</font>";

			holder.tv_description.setText(Html.fromHtml(desc));
			holder.tv_address.setText(Html.fromHtml(addr));
			holder.tv_createdAt.setText(Html.fromHtml(crea));

			String report_id = list.get(arg0).get("report_id");
			String report_cause_id = list.get(arg0).get("report_cause_id");

			if (report_id.equalsIgnoreCase("1")) {

				holder.iv_image.setImageResource(R.drawable.icon_cyan);


				if (report_cause_id.equalsIgnoreCase("1")) {
					holder.tv_type.setText("Go Slow- Traffic: Moderate");
				} else if (report_cause_id.equalsIgnoreCase("2")) {
					holder.tv_type.setText("Go Slow- Traffic: Heavy");
				} else if (report_cause_id.equalsIgnoreCase("3")) {
					holder.tv_type.setText("Go Slow- Traffic: StandStill");
				} else {
					holder.tv_type.setText("Go Slow");
				}


			} else if (report_id.equalsIgnoreCase("2")) {

				holder.iv_image.setImageResource(R.drawable.icon_azure);

				if (report_cause_id.equalsIgnoreCase("4")) {
					holder.tv_type.setText("Police- Hidden");
				} else if (report_cause_id.equalsIgnoreCase("5")) {
					holder.tv_type.setText("Police- Visible");
				} else {
					holder.tv_type.setText("Police");
				}

			} else if (report_id.equalsIgnoreCase("3")) {
				holder.iv_image.setImageResource(R.drawable.icon_green);
				if (report_cause_id.equalsIgnoreCase("6")) {
					holder.tv_type.setText("Accident - Minor");
				} else if (report_cause_id.equalsIgnoreCase("7")) {
					holder.tv_type.setText("Accident- Major");
				} else {
					holder.tv_type.setText("Accident");
				}

			} else if (report_id.equalsIgnoreCase("4")) {
				holder.iv_image.setImageResource(R.drawable.icon_red);

				if (report_cause_id.equalsIgnoreCase("8")) {
					holder.tv_type.setText("Hazard - On Road");
				} else if (report_cause_id.equalsIgnoreCase("9")) {
					holder.tv_type.setText("Hazard - Off Road");
				} else if (report_cause_id.equalsIgnoreCase("10")) {
					holder.tv_type.setText("Hazard - weather");
				} else {
					holder.tv_type.setText("Hazard");
				}

			} else if (report_id.equalsIgnoreCase("5")) {
				holder.iv_image.setImageResource(R.drawable.icon_violet);
				holder.tv_type.setText("Place");
			} else if (report_id.equalsIgnoreCase("6")) {
				holder.iv_image.setImageResource(R.drawable.icon_yellow);
				holder.tv_type.setText("Road Closed");
			} else if (report_id.equalsIgnoreCase("7")) {
				holder.iv_image.setImageResource(R.drawable.icon_magenta);
				holder.tv_type.setText("Check In");
			}

		
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

		public ImageView iv_image;
		public TextView tv_type, tv_description, tv_address, tv_createdAt;

	
	}
}
