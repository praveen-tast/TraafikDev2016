package com.tuffgeekers.traafik;

import android.app.Activity;
import android.os.Bundle;
import android.os.Handler;

import is.arontibo.library.ElasticDownloadView;
import is.arontibo.library.ProgressDownloadView;

public class Uploadfile extends Activity {

    ElasticDownloadView mElasticDownloadView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_uploadfile);

        mElasticDownloadView = (ElasticDownloadView)findViewById(R.id.elastic_download_view);

        new Handler().post(new Runnable() {
            @Override
            public void run() {
                mElasticDownloadView.startIntro();
            }
        });

        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                mElasticDownloadView.success();

                new Handler().postDelayed(new Runnable() {
                    @Override
                    public void run() {

                        finish();


                    }
                }, 1 * ProgressDownloadView.ANIMATION_DURATION_BASE);



            }
        }, 2 * ProgressDownloadView.ANIMATION_DURATION_BASE);




      /*  new Handler().post(new Runnable() {
            @Override
            public void run() {
                mElasticDownloadView.startIntro();
            }
        });

        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                mElasticDownloadView.setProgress(45);
            }
        }, 2 * ProgressDownloadView.ANIMATION_DURATION_BASE);

        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                mElasticDownloadView.fail();
            }
        }, 3 * ProgressDownloadView.ANIMATION_DURATION_BASE);*/


    }

    @Override
    public void onBackPressed() {
        finish();
    }
}
