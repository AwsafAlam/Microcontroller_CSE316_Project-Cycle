package com.example.utshaw.cycle.Activity;


import android.Manifest;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.widget.Toast;

import com.example.utshaw.cycle.R;
import com.karumi.dexter.Dexter;
import com.karumi.dexter.MultiplePermissionsReport;
import com.karumi.dexter.PermissionToken;
import com.karumi.dexter.listener.PermissionRequest;
import com.karumi.dexter.listener.multi.MultiplePermissionsListener;

import java.util.List;

import me.aflak.bluetooth.Bluetooth;

public class EndActivity extends AppCompatActivity {


    boolean mPermission;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_end);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        askPermissions();
    }

    void askPermissions(){
        Dexter.withActivity(this).withPermissions(
                Manifest.permission.BLUETOOTH,
                Manifest.permission.BLUETOOTH_ADMIN,
                Manifest.permission.ACCESS_COARSE_LOCATION)
                .withListener(new MultiplePermissionsListener() {
                    @Override
                    public void onPermissionsChecked(MultiplePermissionsReport report) {
                        if(report.areAllPermissionsGranted()){
                            //Intent intent = new Intent(EndActivity.this, ScanActivity.class);
                            //startActivity(intent);
                            //finish();
                            Toast.makeText(EndActivity.this, "Premission enabled", Toast.LENGTH_SHORT).show();
                            mPermission = true;
                        }
                        else{
                            Toast.makeText(EndActivity.this, "We need these permissions...", Toast.LENGTH_SHORT).show();
                            mPermission = false;
                            askPermissions();
                        }
                    }

                    @Override
                    public void onPermissionRationaleShouldBeShown(List<PermissionRequest> permissions, PermissionToken token) {
                        token.continuePermissionRequest();
                    }
                }).check();
    }


    public void showToast(String message) {
        Toast.makeText(this, message, Toast.LENGTH_SHORT).show();
    }


}