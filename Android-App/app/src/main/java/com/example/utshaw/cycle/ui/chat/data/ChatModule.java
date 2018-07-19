package com.example.utshaw.cycle.ui.chat.data;

import com.example.utshaw.cycle.ui.chat.interactor.ChatInteractor;
import com.example.utshaw.cycle.ui.chat.interactor.ChatInteractorImpl;
import com.example.utshaw.cycle.ui.chat.presenter.ChatPresenter;
import com.example.utshaw.cycle.ui.chat.presenter.ChatPresenterImpl;
import com.example.utshaw.cycle.ui.chat.view.ChatView;

import javax.inject.Singleton;

import dagger.Module;
import dagger.Provides;
import me.aflak.bluetooth.Bluetooth;


/**
 * Created by Omar on 20/12/2017.
 */

@Module
public class ChatModule {
    private ChatView view;

    public ChatModule(ChatView view) {
        this.view = view;
    }

    @Provides @Singleton
    public ChatView provideChatView(){
        return view;
    }

    @Provides @Singleton
    public ChatInteractor provideChatInteractor(Bluetooth bluetooth){
        return new ChatInteractorImpl(bluetooth);
    }

    @Provides @Singleton
    public ChatPresenter provideChatPresenter(ChatView view, ChatInteractor interactor){
        return new ChatPresenterImpl(view, interactor);
    }
}
