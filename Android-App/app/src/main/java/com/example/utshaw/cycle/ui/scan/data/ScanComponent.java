package com.example.utshaw.cycle.ui.scan.data;

import com.example.utshaw.cycle.data.BluetoothModule;
import com.example.utshaw.cycle.ui.scan.view.ScanActivity;

import javax.inject.Singleton;

import dagger.Component;

/**
 * Created by Omar on 20/12/2017.
 */

@Singleton
@Component(modules = {BluetoothModule.class, ScanModule.class})
public interface ScanComponent {
    void inject(ScanActivity scanActivity);
}
