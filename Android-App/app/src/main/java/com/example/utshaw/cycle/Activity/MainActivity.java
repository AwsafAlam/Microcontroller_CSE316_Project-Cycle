package com.example.utshaw.cycle.Activity;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.example.utshaw.cycle.R;


public class MainActivity extends AppCompatActivity {


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        this.getWindow().setSoftInputMode(WindowManager.LayoutParams.SOFT_INPUT_ADJUST_PAN);


        final SharedPreferences sharedPreferences = getSharedPreferences("signUpInfo", Context.MODE_PRIVATE);
        String loggedIn = sharedPreferences.getString("loggedIn", "false");

        if(loggedIn.equals("true")){
            Intent main_activity = new Intent(getApplicationContext(),MapActivity2.class);
            startActivity(main_activity);
            finish();
        }


        final TextView goto_signup_text = (TextView) findViewById(R.id.textView_login_signup_button);
        final TextView goto_signup_text2 = (TextView) findViewById(R.id.textView);

        goto_signup_text.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent signup_page = new Intent(getApplicationContext(),Signup_form_one.class);
                startActivity(signup_page);
                finish();
            }

        });


        goto_signup_text2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent signup_page = new Intent(getApplicationContext(),Signup_form_one.class);
                startActivity(signup_page);
                finish();

            }

        });



        final Button login_button = (Button) findViewById(R.id.button_signin);
        final EditText login_username = (EditText) findViewById(R.id.editText_login_name);
        final EditText login_mobile = (EditText) findViewById(R.id.editText_login_mobile);



        login_button.setOnClickListener(
                new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {

                        String rightusername = sharedPreferences.getString("userName", "");
                        String rightmobile = sharedPreferences.getString("userPass", "");
                        String given_username = login_username.getText().toString();
                        String given_mobile = login_mobile.getText().toString();

                        if(rightmobile.equals("") || rightusername.equals("")){
                            Toast.makeText(getApplicationContext(), "No user account available. Please signup.", Toast.LENGTH_SHORT).show();
                        }
                        else{
                            if(given_mobile.equals(rightmobile) && given_username.equals(rightusername)){
                                SharedPreferences.Editor editor = sharedPreferences.edit();
                                editor.putString("loggedIn", "true");
                                editor.apply();
                                Intent main_activity = new Intent(getApplicationContext(),MapActivity2.class);
                                startActivity(main_activity);
                                finish();
                            }
                            else{
                                Toast.makeText(getApplicationContext(), "Wrong Username or Mobile No", Toast.LENGTH_SHORT).show();
                            }
                        }

//                        SharedPreferences.Editor editor = sharedPreferences.edit();
//                        editor.putString("loggedIn", "true");
//                        editor.apply();
//                        Intent main_activity = new Intent(getApplicationContext(),MapActivity2.class);
//                        startActivity(main_activity);
//                        finish();

                    }
                }
        );


    }

    @Override
    public void onBackPressed() {
        AlertDialog.Builder a_builder = new AlertDialog.Builder(MainActivity.this);
        a_builder.setMessage("Do you want to Exit?")
                .setCancelable(false)
                .setPositiveButton("Yes",new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        finish();
                    }
                })
                .setNegativeButton("No",new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        dialog.cancel();
                    }
                }) ;
        AlertDialog alert = a_builder.create();
        alert.setTitle("Exit Confirmation");
        alert.show();
    }


    @Override
    protected void onPause() {
        super.onPause();

    }


    @Override
    protected void onResume() {
        super.onResume();
    }

}