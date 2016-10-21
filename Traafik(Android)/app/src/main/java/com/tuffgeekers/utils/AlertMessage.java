package com.tuffgeekers.utils;

import android.content.Context;

import cn.pedant.SweetAlert.SweetAlertDialog;

/**
 * Created by abc on 12/24/2015.
 */
public class AlertMessage {


    public void showErrorPopup(Context context, String title, String message){

        final SweetAlertDialog pDialog = new SweetAlertDialog(context, SweetAlertDialog.WARNING_TYPE);
        pDialog.setCancelable(true);
        pDialog.setTitleText(title);
        pDialog.setContentText(message);
        pDialog.setConfirmText("ok");
        pDialog.setConfirmClickListener(new SweetAlertDialog.OnSweetClickListener() {
            @Override
            public void onClick(SweetAlertDialog sweetAlertDialog) {

                pDialog.cancel();

            }
        });


        pDialog.show();

    }


    public void showSuccessIntent(Context context, String title, String message){

        final SweetAlertDialog pDialog = new SweetAlertDialog(context, SweetAlertDialog.SUCCESS_TYPE);
        pDialog.setCancelable(false);
        pDialog.setTitleText(title);
        pDialog.setContentText(message);

        pDialog.show();

    }

}
