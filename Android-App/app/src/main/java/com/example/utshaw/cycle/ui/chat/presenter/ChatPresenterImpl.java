package com.example.utshaw.cycle.ui.chat.presenter;

import android.app.Activity;
import android.bluetooth.BluetoothDevice;
import android.content.Intent;
import android.os.Handler;
import android.os.Parcel;
import android.os.Parcelable;

import com.example.utshaw.cycle.R;
import com.example.utshaw.cycle.ui.chat.interactor.ChatInteractor;
import com.example.utshaw.cycle.ui.chat.view.ChatView;

import java.io.Serializable;

import me.aflak.bluetooth.BluetoothCallback;
import me.aflak.bluetooth.DeviceCallback;


/**
 * Created by Omar on 20/12/2017.
 */

public class ChatPresenterImpl implements ChatPresenter,Serializable {
    private ChatView view;
    private ChatInteractor interactor;
    private BluetoothDevice device;

    public ChatPresenterImpl(ChatView view, ChatInteractor interactor) {
        this.view = view;
        this.interactor = interactor;
    }

    @Override
    public void onCreate(Intent intent) {
        if(intent.getExtras()!=null) {
            device = intent.getExtras().getParcelable("device");
            view.enableHWButton(false);
        }
    }

    @Override
    public void onHelloWorld() {
        interactor.sendMessage("0");
        //view.appendMessage("--> 0");
        //interactor.onStop();
    }

    @Override
    public void onHelloWorld1() {
        interactor.sendMessage("1");
        //view.appendMessage("--> 1");
    }

    private DeviceCallback communicationCallback = new DeviceCallback() {
        @Override
        public void onDeviceConnected(BluetoothDevice device) {
            view.setStatus(R.string.bluetooth_connected);
            view.enableHWButton(true);
            interactor.sendMessage("1");
        }

        @Override
        public void onDeviceDisconnected(BluetoothDevice device, String message) {
            view.setStatus(R.string.bluetooth_connecting);
            view.enableHWButton(false);
            interactor.connectToDevice(device, communicationCallback);
        }

        @Override
        public void onMessage(String message) {
            view.appendMessage("<-- " + message);
        }

        @Override
        public void onError(String message) {
            view.setStatus(message);
        }

        @Override
        public void onConnectError(final BluetoothDevice device, String message) {
            view.setStatus(R.string.bluetooth_connect_in_3sec);
            //view.showToast("New attempt in 3 sec...");
            new Handler().postDelayed(new Runnable() {
                @Override
                public void run() {
                    interactor.connectToDevice(device, communicationCallback);
                }
            }, 3000);
        }
    };

    @Override
    public void onStart(Activity activity) {
        interactor.onStart(bluetoothCallback, activity);
        if(interactor.isBluetoothEnabled()){
            interactor.connectToDevice(device, communicationCallback);
            view.setStatus(R.string.bluetooth_connecting);
        }
        else{
            interactor.enableBluetooth();
        }
    }

    @Override
    public void onStop() {
        interactor.onStop();
    }

    private BluetoothCallback bluetoothCallback = new BluetoothCallback() {
        @Override
        public void onBluetoothTurningOn() {

        }

        @Override
        public void onBluetoothOn() {
            interactor.connectToDevice(device, communicationCallback);
            view.setStatus(R.string.bluetooth_connecting);
            view.enableHWButton(false);
        }

        @Override
        public void onBluetoothTurningOff() {

        }

        @Override
        public void onBluetoothOff() {

        }

        @Override
        public void onUserDeniedActivation() {

        }
    };

}
