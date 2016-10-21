package com.tuffgeekers.Adapter;

public class MyMarker
{
    private String mLabel;
    private String mIcon;
    private Double mLatitude;
    private Double mLongitude;
    private int mreportID;
    private String maddress,mcreated;

    public MyMarker(String label, String icon, Double latitude, Double longitude, int reportID, String address, String created)
    {
        this.mLabel = label;
        this.mLatitude = latitude;
        this.mLongitude = longitude;
        this.mIcon = icon;
        this.mreportID=reportID;
        this.maddress = address;
        this.mcreated = created;
    }

    public String getmAdrress()
    {
        return maddress;
    }

    public void setmAddress(String maddress)
    {
        this.maddress = maddress;
    }


    public String getmcreated()
    {
        return mcreated;
    }

    public void setmcreated(String mcreated)
    {
        this.mcreated = mcreated;
    }


    public String getmLabel()
    {
        return mLabel;
    }

    public void setmLabel(String mLabel)
    {
        this.mLabel = mLabel;
    }

    public int getmID()
    {
        return mreportID;
    }

    public void setmID(int ID)
    {
        this.mreportID = mreportID;
    }

    public String getmIcon()
    {
        return mIcon;
    }

    public void setmIcon(String icon)
    {
        this.mIcon = icon;
    }

    public Double getmLatitude()
    {
        return mLatitude;
    }

    public void setmLatitude(Double mLatitude)
    {
        this.mLatitude = mLatitude;
    }

    public Double getmLongitude()
    {
        return mLongitude;
    }

    public void setmLongitude(Double mLongitude)
    {
        this.mLongitude = mLongitude;
    }
}
