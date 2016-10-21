package com.tuffgeekers.Loader;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.Collections;
import java.util.Map;
import java.util.WeakHashMap;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;

import android.app.Activity;
import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.Bitmap.Config;
import android.graphics.BitmapFactory;
import android.graphics.Canvas;
import android.graphics.Paint;
import android.graphics.PorterDuff.Mode;
import android.graphics.PorterDuffXfermode;
import android.graphics.Rect;
import android.util.Log;
import android.widget.ImageView;

import com.tuffgeekers.traafik.R;


public class Image_Loader {

    MemoryCache memoryCache=new MemoryCache();
    FileCache fileCache;
    Context c;
    Bitmap pic1,bitmap1,pic;
    Boolean bool;
    ImageView imview;
    private Map<ImageView, String> imageViews=Collections.synchronizedMap(new WeakHashMap<ImageView, String>());
    ExecutorService executorService; 
   
    public Image_Loader(Context context){
        fileCache=new FileCache(context);
        this.c=context;
        executorService=Executors.newFixedThreadPool(5);
    }
  
    int stub_id = R.drawable.ic_launcher;
    public void DisplayImage(String url, int loader, ImageView imageView, Boolean b)
    {
        stub_id = loader;
        imageViews.put(imageView, url);
        bool=b;
        this.imview=imageView;
        
        Bitmap bitmap=memoryCache.get(url);
        if(bitmap!=null)
        	if(bool){
            	pic=getCircularBitmap(bitmap);
            	imview.setImageBitmap(pic);
        	}else{
                imageView.setImageBitmap(bitmap);

        	}
        else
        { 
            queuePhoto(url, imageView);
            if(bool){
            	bitmap = BitmapFactory.decodeResource(c.getResources(),stub_id);
            	pic=getCircularBitmap(bitmap);
            	//imageView.setImageBitmap(pic);
            }else{
            	imageView.setImageResource(stub_id);
            
           
        }
    }
    }
  
    private void queuePhoto(String url, ImageView imageView)
    {
        PhotoToLoad p=new PhotoToLoad(url, imageView);
        executorService.submit(new PhotosLoader(p));
    }
  
    private Bitmap getBitmap(String url)
    {
        File f=fileCache.getFile(url);
  
        //from SD cache
        Bitmap b = decodeFile(f);
        if(b!=null)
            return b;
  
        //from web
        try {
            Bitmap bitmap=null;
            URL imageUrl = new URL(url);
            HttpURLConnection conn = (HttpURLConnection)imageUrl.openConnection();
            conn.setConnectTimeout(30000);
            conn.setReadTimeout(30000);
            conn.setInstanceFollowRedirects(true);
            Log.e("responce", conn.getResponseCode()+" code");
          //  if(conn.getResponseCode()==200){
            InputStream is=conn.getInputStream();
       
            OutputStream os = new FileOutputStream(f);
            Utils.CopyStream(is, os);
            os.close();
            bitmap = decodeFile(f);
           /* }else{
            	Log.e("res", conn.getResponseMessage()+" "+conn.getResponseCode());
             	bitmap = BitmapFactory.decodeResource(c.getResources(),
						R.drawable.image1);
            }*/
            Log.e("IMAGE LOADER", bitmap+"  " );
            return bitmap;
        } catch (Exception ex){
           ex.printStackTrace();
           return null;
        }
    }
  
    //decodes image and scales it to reduce memory consumption
    private Bitmap decodeFile(File f){
        try {
            //decode image size
            BitmapFactory.Options o = new BitmapFactory.Options();
            o.inJustDecodeBounds = true;
            BitmapFactory.decodeStream(new FileInputStream(f),null,o);
  
            //Find the correct scale value. It should be the power of 2.
            final int REQUIRED_SIZE=70;
            int width_tmp=o.outWidth, height_tmp=o.outHeight;
            int scale=1;
            while(true){
                if(width_tmp/2<REQUIRED_SIZE || height_tmp/2<REQUIRED_SIZE)
                    break;
                width_tmp/=2;
                height_tmp/=2;
                scale*=2;
            }
  
            //decode with inSampleSize
            BitmapFactory.Options o2 = new BitmapFactory.Options();
            o2.inSampleSize=scale;
            return BitmapFactory.decodeStream(new FileInputStream(f), null, o2);
        } catch (FileNotFoundException e) {
        	
        }
        return null;
    }
  
    //Task for the queue
    private class PhotoToLoad
    {
        public String url;
        public ImageView imageView;
        public PhotoToLoad(String u, ImageView i){
            url=u;
            imageView=i; 
        }
    }
  
    class PhotosLoader implements Runnable {
        PhotoToLoad photoToLoad;
        PhotosLoader(PhotoToLoad photoToLoad){
            this.photoToLoad=photoToLoad;
        }
  
        @Override
        public void run() {
            if(imageViewReused(photoToLoad))
                return;
            Bitmap bmp=getBitmap(photoToLoad.url);
            memoryCache.put(photoToLoad.url, bmp);
            if(imageViewReused(photoToLoad))
                return;
            BitmapDisplayer bd=new BitmapDisplayer(bmp, photoToLoad);
            Activity a=(Activity)photoToLoad.imageView.getContext();
            a.runOnUiThread(bd);
        }
    }
  
    boolean imageViewReused(PhotoToLoad photoToLoad){
        String tag=imageViews.get(photoToLoad.imageView);
        if(tag==null || !tag.equals(photoToLoad.url))
            return true;
        return false;
    }
    
  
    //Used to display bitmap in the UI thread
    class BitmapDisplayer implements Runnable
    {
        Bitmap bitmap,pic;
        PhotoToLoad photoToLoad;
        public BitmapDisplayer(Bitmap b, PhotoToLoad p){bitmap=b;photoToLoad=p;}
        public void run()
        {
            if(imageViewReused(photoToLoad))
                return;
            if(bitmap!=null){
            	if(bool){
            		
            		Log.e("<><><><><>", "print");
                	pic=getCircularBitmap(bitmap);
                	 photoToLoad.imageView.setImageBitmap(pic);
                	}else{
                		Log.e("eeeeeeee", bitmap+" s");
                		photoToLoad.imageView.setImageBitmap(bitmap);
                	}
                
          
            }else{
              	if(bool){
                	bitmap = BitmapFactory.decodeResource(c.getResources(),
    						stub_id);
                	pic=getCircularBitmap(bitmap);
                    photoToLoad.imageView.setImageBitmap(pic);
                	}else{
                		Log.e("vvvvvvvvvvvv", stub_id+" s");
                    photoToLoad.imageView.setImageResource(stub_id);
            }
             //   photoToLoad.imageView.setImageResource(stub_id);
                    }
    } 
    }
    

	public Bitmap getCircularBitmap(Bitmap bitmap) {
	    Bitmap output;

	    if (bitmap.getWidth() > bitmap.getHeight()) {
	        output = Bitmap.createBitmap(bitmap.getHeight(), bitmap.getHeight(), Config.ARGB_8888);
	    } else {
	        output = Bitmap.createBitmap(bitmap.getWidth(), bitmap.getWidth(), Config.ARGB_8888);
	    }

	    Canvas canvas = new Canvas(output);

	    final int color = 0xff424242;
	    final Paint paint = new Paint();
	    final Rect rect = new Rect(0, 0, bitmap.getWidth(), bitmap.getHeight());

	    float r = 0;

	    if (bitmap.getWidth() > bitmap.getHeight()) {
	        r = bitmap.getHeight() / 2;
	    } else {
	        r = bitmap.getWidth() / 2;
	    }

	    paint.setAntiAlias(true);
	    canvas.drawARGB(0, 0, 0, 0);
	    paint.setColor(color);
	    canvas.drawCircle(r, r, r, paint);
	    paint.setXfermode(new PorterDuffXfermode(Mode.SRC_IN));
	    canvas.drawBitmap(bitmap, rect, rect, paint);
	    
	 //    imview.setImageBitmap(output);
	    return output;
	}
	
    
    public void clearCache() {
        memoryCache.clear();
        fileCache.clear();
    }
  
}
