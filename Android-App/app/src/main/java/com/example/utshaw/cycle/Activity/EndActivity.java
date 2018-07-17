package com.example.utshaw.cycle.Activity;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.os.Handler;

import android.preference.PreferenceManager;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.example.utshaw.cycle.R;
import com.example.utshaw.cycle.Utils.TimerService;

import java.text.SimpleDateFormat;
import java.util.Calendar;


/**
 * Example activity to manage a long-running timer, which survives the destruction of the activity
 * by using a foreground service and notification
 *
 * Add the following to the manifest:
 * <service android:name=".MainActivity$TimerService" android:exported="false" />
 */

public class EndActivity extends AppCompatActivity {

    private static final String TAG = EndActivity.class.getSimpleName();

    private TimerService timerService;
    private boolean serviceBound;

    private Button btn_start;
    private TextView tv_timer;

    // Handler to update the UI every second when the timer is running
    private final Handler mUpdateTimeHandler = new UIUpdateHandler(this);

    // Message type for the handler
    private final static int MSG_UPDATE_TIME = 0;

    //Second Activity

    private Button  btn_cancel;
    String date_time;
    Calendar calendar;
    SimpleDateFormat simpleDateFormat;
    EditText et_hours;

    SharedPreferences mpref;
    SharedPreferences.Editor mEditor;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_end);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        btn_start = (Button)findViewById(R.id.timer_button);
        tv_timer = (TextView)findViewById(R.id.timer_text_view);


        init();
        listener();

    }

    private void init() {

        et_hours = (EditText) findViewById(R.id.et_hours);



        mpref = PreferenceManager.getDefaultSharedPreferences(getApplicationContext());
        mEditor = mpref.edit();

        try {
            String str_value = mpref.getString("data", "");
            if (str_value.matches("")) {
                et_hours.setEnabled(true);
                btn_start.setEnabled(true);
                tv_timer.setText("");

            } else {

                if (mpref.getBoolean("finish", false)) {
                    et_hours.setEnabled(true);
                    btn_start.setEnabled(true);
                    tv_timer.setText("");
                } else {

                    et_hours.setEnabled(false);
                    btn_start.setEnabled(false);
                    tv_timer.setText(str_value);
                }
            }
        } catch (Exception e) {

        }



    }

    private void listener() {
        btn_start.setOnClickListener(this);
        btn_cancel.setOnClickListener(this);

    }

    @Override
    public void onClick(View v) {

        switch (v.getId()) {
            case R.id.btn_timer:


                if (et_hours.getText().toString().length() > 0) {

                    int int_hours = 2;

                    if (int_hours<=24) {


                        et_hours.setEnabled(false);
                        btn_start.setEnabled(false);


                        calendar = Calendar.getInstance();
                        simpleDateFormat = new SimpleDateFormat("HH:mm:ss");
                        date_time = simpleDateFormat.format(calendar.getTime());

                        mEditor.putString("data", date_time).commit();
                        mEditor.putString("hours", et_hours.getText().toString()).commit();


                        Intent intent_service = new Intent(getApplicationContext(), Timer_Service.class);
                        startService(intent_service);
                    }else {
                        Toast.makeText(getApplicationContext(),"Please select the value below 24 hours",Toast.LENGTH_SHORT).show();
                    }
/*
                    mTimer = new Timer();
                    mTimer.scheduleAtFixedRate(new TimeDisplayTimerTask(), 5, NOTIFY_INTERVAL);*/
                } else {
                    Toast.makeText(getApplicationContext(), "Please select value", Toast.LENGTH_SHORT).show();
                }
                break;


            case R.id.btn_cancel:


                Intent intent = new Intent(getApplicationContext(),Timer_Service.class);
                stopService(intent);

                mEditor.clear().commit();

                et_hours.setEnabled(true);
                btn_start.setEnabled(true);
                tv_timer.setText("");


                break;

        }

    }

    private BroadcastReceiver broadcastReceiver = new BroadcastReceiver() {
        @Override
        public void onReceive(Context context, Intent intent) {
            String str_time = intent.getStringExtra("time");
            tv_timer.setText(str_time);

        }
    };

    @Override
    protected void onResume() {
        super.onResume();
        registerReceiver(broadcastReceiver,new IntentFilter(TimerService.str_receiver));

    }

    @Override
    protected void onPause() {
        super.onPause();
        unregisterReceiver(broadcastReceiver);
    }
}