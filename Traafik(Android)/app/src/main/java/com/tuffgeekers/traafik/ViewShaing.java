package com.tuffgeekers.traafik;

import android.app.Activity;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.Window;

import com.tuffgeekers.jsonfiles.MainAsynListener;
import com.tuffgeekers.jsonfiles.MainAsyncTask;
import com.tuffgeekers.utils.Global;

public class ViewShaing extends Activity implements MainAsynListener<String>{

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_view_shaing);

     //   new MainAsyncTask()

    //    new MainAsyncTask(ViewShaing.this, Global.BaseUrl + "user/viewAllLocation/id/" + Global.userId, 100, ViewShaing.this, Global.json, true).execute();
        //http://tuffgeekers.com/demo/AppTraafik/api/user/viewAllLocation/id/{user_id}
    }

    @Override
    public void onPostSuccess(String result, int id, boolean isSucess) {

    }

    @Override
    public void onPostError(int id, int error) {

    }
}
