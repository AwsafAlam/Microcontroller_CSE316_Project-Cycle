package com.example.utshaw.cycle.Activity;


import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.Button;
import android.widget.Toast;

import com.example.utshaw.cycle.R;

public class EndActivity extends AppCompatActivity {


    private Button payment;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_end);

        payment = findViewById(R.id.button_signin);

        payment.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(EndActivity.this , MapActivity2.class));
                finish();

            //TODO : Add API call to server

            }
        });
    }



    public void showToast(String message) {
        Toast.makeText(this, message, Toast.LENGTH_SHORT).show();
    }


}