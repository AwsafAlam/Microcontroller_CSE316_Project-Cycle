package com.example.utshaw.stopwatch;

import android.app.Activity;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.TimeZone;

public class MainActivity extends Activity implements OnClickListener{

    final int MSG_START_TIMER = 0;
    final int MSG_STOP_TIMER = 1;
    final int MSG_UPDATE_TIMER = 2;

    Stopwatch timer = new Stopwatch();
    final int REFRESH_RATE = 100;

    Handler mHandler = new Handler()
    {
        @Override
        public void handleMessage(Message msg) {
            super.handleMessage(msg);
            switch (msg.what) {
                case MSG_START_TIMER:
                    timer.start(); //start timer
                    mHandler.sendEmptyMessage(MSG_UPDATE_TIMER);
                    break;

                case MSG_UPDATE_TIMER:
                    tvTextView.setText(formarDate(timer.getElapsedTime()));
                    mHandler.sendEmptyMessageDelayed(MSG_UPDATE_TIMER,REFRESH_RATE); //text view is updated every second,
                    break;                                  //though the timer is still running
                case MSG_STOP_TIMER:
                    mHandler.removeMessages(MSG_UPDATE_TIMER); // no more updates.
                    timer.stop();//stop timer
                    tvTextView.setText(formarDate(timer.getElapsedTime()));
                    break;

                default:
                    break;
            }
        }
    };

    TextView tvTextView;
    Button btnStart,btnStop;

    /** Called when the activity is first created. */
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        tvTextView = (TextView)findViewById(R.id.text_view);

        btnStart = (Button)findViewById(R.id.btn_start);
        btnStop= (Button)findViewById(R.id.btn_stop);
        btnStart.setOnClickListener(this);
        btnStop.setOnClickListener(this);

    }

    public void onClick(View v) {
        if(btnStart == v)
        {
            mHandler.sendEmptyMessage(MSG_START_TIMER);
        }else
        if(btnStop == v){
            mHandler.sendEmptyMessage(MSG_STOP_TIMER);
        }
    }


    String formarDate(long timeSTamp){
        Date date = new Date(timeSTamp);
        DateFormat formatter = new SimpleDateFormat("HH:mm:ss.SSS");
        formatter.setTimeZone(TimeZone.getTimeZone("UTC"));
        String dateFormatted = formatter.format(date);
        return dateFormatted;
    }

}