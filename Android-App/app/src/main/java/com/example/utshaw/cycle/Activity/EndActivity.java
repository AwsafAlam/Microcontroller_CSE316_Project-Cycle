package com.example.utshaw.cycle.Activity;


import android.Manifest;
import android.bluetooth.BluetoothDevice;
import android.content.Intent;
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
import me.aflak.bluetooth.BluetoothCallback;
import me.aflak.bluetooth.DeviceCallback;
import me.aflak.bluetooth.DiscoveryCallback;

public class EndActivity extends AppCompatActivity {

    Bluetooth bluetooth;
    boolean mPermission;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_end);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        askPermissions();
//        bluetooth = new Bluetooth(this);
        //List<BluetoothDevice> devices = bluetooth.getPairedDevices();
        //bluetooth.startScanning();

        //bluetooth.connectToName("HC-05");

//        bluetooth.setBluetoothCallback(new BluetoothCallback() {
//            @Override
//            public void onBluetoothTurningOn() {showToast("Bluetooth Turning On");}
//
//            @Override
//            public void onBluetoothOn() {showToast("Bluetooth Turning On");}
//
//            @Override
//            public void onBluetoothTurningOff() {showToast("Bluetooth Turning OFF");}
//
//            @Override
//            public void onBluetoothOff() {showToast("Bluetooth Turning On");}
//
//            @Override
//            public void onUserDeniedActivation() {
//                // when using bluetooth.showEnableDialog()
//                // you will also have to call bluetooth.onActivityResult()
//            }
//        });
//
//
//        bluetooth.setDiscoveryCallback(new DiscoveryCallback() {
//            @Override public void onDiscoveryStarted() {showToast("Bluetooth Turning On");}
//            @Override public void onDiscoveryFinished() {showToast("Bluetooth Turning On");}
//            @Override public void onDeviceFound(BluetoothDevice device) {bluetooth.pair(device);}
//            @Override public void onDevicePaired(BluetoothDevice device) {showToast("Bluetooth Paired On");}
//            @Override public void onDeviceUnpaired(BluetoothDevice device) {}
//            @Override public void onError(String message) {}
//        });
//
//
//
//
//        bluetooth.setDeviceCallback(new DeviceCallback() {
//            @Override public void onDeviceConnected(BluetoothDevice device) {showToast("Bluetooth Connected On");}
//            @Override public void onDeviceDisconnected(BluetoothDevice device, String message) {}
//            @Override public void onMessage(String message) {}
//            @Override public void onError(String message) {}
//            @Override public void onConnectError(BluetoothDevice device, String message) {}
//        });

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

//    @Override
//    protected void onStart() {
//        super.onStart();
//        bluetooth.onStart();
//        bluetooth.enable();
//    }
//
//    @Override
//    protected void onStop() {
//        super.onStop();
//        bluetooth.onStop();
//    }

    public void showToast(String message) {
        Toast.makeText(this, message, Toast.LENGTH_SHORT).show();
    }


}