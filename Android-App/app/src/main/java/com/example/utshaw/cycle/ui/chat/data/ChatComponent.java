package com.example.utshaw.cycle.ui.chat.data;

import com.example.utshaw.cycle.data.BluetoothModule;
import com.example.utshaw.cycle.ui.chat.view.ChatActivity;

import javax.inject.Singleton;

import dagger.Component;

/**
 * Created by Omar on 20/12/2017.
 */
@Singleton
@Component(modules = {BluetoothModule.class, ChatModule.class})
public interface ChatComponent {
    void inject(ChatActivity chatActivity);
}
