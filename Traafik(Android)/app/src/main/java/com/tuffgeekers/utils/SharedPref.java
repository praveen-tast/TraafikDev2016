package com.tuffgeekers.utils;

import android.app.Activity;
import android.content.SharedPreferences;
import android.preference.PreferenceManager;

/**
 * Created by hitesh on 2/20/16.
 */
public class SharedPref {

    public static void set_Logged(Activity activity, String Logged) {

        SharedPreferences preferences = PreferenceManager.getDefaultSharedPreferences(activity);
        SharedPreferences.Editor editor = preferences.edit();
        editor.putString("Logged", Logged);
        editor.commit();

    }

    public static String get_Logged(Activity activity) {
        SharedPreferences preferences = PreferenceManager.getDefaultSharedPreferences(activity);
        String Logged = preferences.getString("Logged", "");
        return Logged;

    }

    public static void set_LogAuth(Activity activity, String LogAuth) {

        SharedPreferences preferences = PreferenceManager.getDefaultSharedPreferences(activity);
        SharedPreferences.Editor editor = preferences.edit();
        editor.putString("LogAuth", LogAuth);
        editor.commit();

    }

    public static String get_LogAuth(Activity activity) {
        SharedPreferences preferences = PreferenceManager.getDefaultSharedPreferences(activity);
        String LogAuth = preferences.getString("LogAuth", "");
        return LogAuth;

    }



    public static void set_LoggedAccess(Activity activity, String LoggedAccess) {

        SharedPreferences preferences = PreferenceManager.getDefaultSharedPreferences(activity);
        SharedPreferences.Editor editor = preferences.edit();
        editor.putString("LoggedAccess", LoggedAccess);
        editor.commit();

    }

    public static String get_LoggedAccess(Activity activity) {
        SharedPreferences preferences = PreferenceManager.getDefaultSharedPreferences(activity);
        String Logged = preferences.getString("LoggedAccess", "");
        return Logged;

    }



    public static void set_UserId(Activity activity, String UserId) {

        SharedPreferences preferences = PreferenceManager.getDefaultSharedPreferences(activity);
        SharedPreferences.Editor editor = preferences.edit();
        editor.putString("UserId", UserId);
        editor.commit();

    }

    public static String get_UserId(Activity activity) {
        SharedPreferences preferences = PreferenceManager.getDefaultSharedPreferences(activity);
        String UserId = preferences.getString("UserId", "");
        return UserId;

    }
    public static void set_Lat(Activity activity, String Lat ){

        SharedPreferences preferences = PreferenceManager.getDefaultSharedPreferences(activity);
        SharedPreferences.Editor editor = preferences.edit();
        editor.putString("Lat", Lat);
        editor.commit();

    }

    public static String get_Lat(Activity activity) {
        SharedPreferences preferences = PreferenceManager.getDefaultSharedPreferences(activity);
        String Lat = preferences.getString("Lat", "");
        return Lat;

    }


    public static void set_Radius(Activity activity, String Radius ){

        SharedPreferences preferences = PreferenceManager.getDefaultSharedPreferences(activity);
        SharedPreferences.Editor editor = preferences.edit();
        editor.putString("Radius", Radius);
        editor.commit();

    }

    public static String get_Radius(Activity activity) {
        SharedPreferences preferences = PreferenceManager.getDefaultSharedPreferences(activity);
        String Radius = preferences.getString("Radius", "");
        return Radius;

    }

}
