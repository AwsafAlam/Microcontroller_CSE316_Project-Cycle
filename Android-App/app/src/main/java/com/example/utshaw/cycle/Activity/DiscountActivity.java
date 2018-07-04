package com.example.utshaw.cycle.Activity;

import android.content.ClipData;
import android.content.ClipboardManager;
import android.content.Intent;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.example.utshaw.cycle.R;

public class DiscountActivity extends AppCompatActivity {

    private TextView copy;
    private Button Invite;
    private ClipboardManager myClipboard;
    private ClipData myClip;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_discount);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowTitleEnabled(false);

        copy = findViewById(R.id.clipcpy);
        Invite = findViewById(R.id.invite);

        myClipboard = (ClipboardManager)getSystemService(CLIPBOARD_SERVICE);

//        myClip = ClipData.newPlainText("text", text);
//        myClipboard.setPrimaryClip(myClip);

        copy.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String text;
                text = copy.getText().toString();

                myClip = ClipData.newPlainText("text", text);
                myClipboard.setPrimaryClip(myClip);

                Toast.makeText(getApplicationContext(), "Code Copied",
                        Toast.LENGTH_SHORT).show();
            }
        });

        Invite.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String prompt = "Awsaf has given you a FREE Cycle ride (up to Tk 50). " +
                        "To claim your free gift, sign up using this Cycle App , and use the code :\n\n";
                String shareBody;
                shareBody = prompt + copy.getText().toString();

                Intent sendIntent = new Intent();
                sendIntent.setAction(Intent.ACTION_SEND);
                sendIntent.putExtra(Intent.EXTRA_TEXT, shareBody);
                sendIntent.setType("text/plain");
                startActivity(sendIntent);

            }
        });
    }

    @Override
    public boolean onSupportNavigateUp(){
        finish();
        return true;
    }


}
