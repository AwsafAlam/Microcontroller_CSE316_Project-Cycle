package com.example.utshaw.cycle.ui.scan.data;

import com.example.utshaw.cycle.ui.scan.interactor.ScanInteractor;
import com.example.utshaw.cycle.ui.scan.interactor.ScanInteractorImpl;
import com.example.utshaw.cycle.ui.scan.presenter.ScanPresenter;
import com.example.utshaw.cycle.ui.scan.presenter.ScanPresenterImpl;
import com.example.utshaw.cycle.ui.scan.view.ScanView;

import javax.inject.Singleton;

import dagger.Module;
import dagger.Provides;
import me.aflak.bluetooth.Bluetooth;

/**
 * Created by Omar on 20/12/2017.
 */

@Module
public class ScanModule {
    private ScanView view;

    public ScanModule(ScanView view) {
        this.view = view;
    }

    @Provides @Singleton
    public ScanView provideScanView(){
        return view;
    }

    @Provides @Singleton
    public ScanInteractor provideScanInteractor(Bluetooth bluetooth){
        return new ScanInteractorImpl(bluetooth);
    }

    @Provides @Singleton
    public ScanPresenter provideScanPresenter(ScanView view, ScanInteractor interactor){
        return new ScanPresenterImpl(view, interactor);
    }
}
