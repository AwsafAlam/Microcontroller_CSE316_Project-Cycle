package com.example.utshaw.cycle.Activity;


import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.example.utshaw.cycle.R;
import com.firebase.ui.auth.AuthUI;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;

import java.util.Arrays;

public class Signup_form_two extends AppCompatActivity {

    public static final int RC_SIGN_IN = 1;

    private String userAuthPhoneNumber;

    private FirebaseAuth mFirebaseAuth;
    private FirebaseAuth.AuthStateListener mAuthStateListener;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        setTheme(R.style.signupAppTheme);
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signup_form_two);

        this.getWindow().setSoftInputMode(WindowManager.LayoutParams.SOFT_INPUT_ADJUST_PAN);

        Button sign_up_finish_button = (Button) findViewById(R.id.button_signup_finish);

        final EditText signUp_age = (EditText) findViewById(R.id.signupAge);
        final EditText signUp_gender = (EditText) findViewById(R.id.signupGender);
        final EditText signUp_bloodgrp = (EditText) findViewById(R.id.signupBlood);
        final EditText signUp_address = (EditText) findViewById(R.id.signupAddress);

        final TextView genderText = (TextView) findViewById(R.id.textView12);
        final TextView addressText = (TextView) findViewById(R.id.textView14);

        final TextView goto_login_text = (TextView) findViewById(R.id.textView_signupform_login_button2);

        goto_login_text.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                AlertDialog.Builder a_builder = new AlertDialog.Builder(Signup_form_two.this);
                a_builder.setMessage("Do you want to go the Login Page?")
                        .setCancelable(false)
                        .setPositiveButton("Yes",new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                final SharedPreferences sharedPreferences = getSharedPreferences("signUpInfo", Context.MODE_PRIVATE);
                                SharedPreferences.Editor editor = sharedPreferences.edit();
                                editor.putString("userName","");
                                editor.putString("userMobile", "");
                                editor.putString("userAge", "");
                                editor.putString("userGender", "");
                                editor.putString("userBloodGroup", "");
                                editor.putString("userAddress", "");
                                editor.apply();
                                Intent loginPage = new Intent(getApplicationContext(),MainActivity.class);
                                startActivity(loginPage);
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
                alert.setTitle("Login Page Confirmation");
                alert.show();
            }
        });

        final TextView goto_login_text2 = (TextView) findViewById(R.id.textView3);

        goto_login_text2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                AlertDialog.Builder a_builder = new AlertDialog.Builder(Signup_form_two.this);
                a_builder.setMessage("Do you want to go the Login Page?")
                        .setCancelable(false)
                        .setPositiveButton("Yes",new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                final SharedPreferences sharedPreferences = getSharedPreferences("signUpInfo", Context.MODE_PRIVATE);
                                SharedPreferences.Editor editor = sharedPreferences.edit();
                                editor.putString("userName","");
                                editor.putString("userMobile", "");
                                editor.putString("userAge", "");
                                editor.putString("userGender", "");
                                editor.putString("userBloodGroup", "");
                                editor.putString("userAddress", "");
                                editor.putString("loggedIn", "false");
                                editor.apply();
                                Intent loginPage = new Intent(getApplicationContext(),MainActivity.class);
                                startActivity(loginPage);
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
                alert.setTitle("Login Page Confirmation");
                alert.show();
            }
        });


        sign_up_finish_button.setOnClickListener(
                new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {
                        String given_age = signUp_age.getText().toString();
                        String given_gender = signUp_gender.getText().toString();
                        String given_bloodgrp = signUp_bloodgrp.getText().toString();
                        String given_address = signUp_address.getText().toString();
                        if(given_gender.equals("") || given_address.equals("")){
                            genderText.setText("*GENDER");
                            addressText.setText("*ADDRESS");
                            Toast.makeText(getApplicationContext(), "Please fill up the mandatory fields", Toast.LENGTH_SHORT).show();
                        }
                        else{
                            final SharedPreferences sharedPreferences = getSharedPreferences("signUpInfo", Context.MODE_PRIVATE);
                            SharedPreferences.Editor editor = sharedPreferences.edit();
                            editor.putString("userAge", given_age);
                            editor.putString("userGender", given_gender);
                            editor.putString("userBloodGroup", given_bloodgrp);
                            editor.putString("userAddress", given_address);
                            editor.putString("loggedIn", "true");
                            editor.apply();

                        }


                        mFirebaseAuth = FirebaseAuth.getInstance();

                        mAuthStateListener = new FirebaseAuth.AuthStateListener() {
                            @Override
                            public void onAuthStateChanged(@NonNull FirebaseAuth firebaseAuth) {
                                FirebaseUser user = mFirebaseAuth.getCurrentUser();
                                if(user != null){
                                    // user is signed in
                                    onSignedInInitalize();
                                }else{
                                    // user is logged out
                                    startActivityForResult(
                                            AuthUI.getInstance()
                                                    .createSignInIntentBuilder()
                                                    .setAvailableProviders(
                                                            Arrays.asList(
                                                                    new AuthUI.IdpConfig.Builder(AuthUI.PHONE_VERIFICATION_PROVIDER).build()))
                                                    .build(),
                                            RC_SIGN_IN);
                                }

                            }
                        };
                        Intent loginPage = new Intent(getApplicationContext(),MapActivity2.class);

                        startActivity(loginPage);
                        finish();
                    }
                }
        );
    }


    private void onSignedInInitalize(){
        userAuthPhoneNumber = mFirebaseAuth.getCurrentUser().getPhoneNumber().toString();
        Toast.makeText(this, "Hello " + userAuthPhoneNumber, Toast.LENGTH_SHORT).show();
    }

    @Override
    protected void onRestart() {
        setTheme(R.style.signupAppTheme);
        super.onRestart();
    }

    @Override
    public void onBackPressed() {
        AlertDialog.Builder a_builder = new AlertDialog.Builder(Signup_form_two.this);
        a_builder.setMessage("Do you want to go the Login Page?")
                .setCancelable(false)
                .setPositiveButton("Yes",new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        final SharedPreferences sharedPreferences = getSharedPreferences("signUpInfo", Context.MODE_PRIVATE);
                        SharedPreferences.Editor editor = sharedPreferences.edit();
                        editor.putString("userName","");
                        editor.putString("userMobile", "");
                        editor.putString("userAge", "");
                        editor.putString("userGender", "");
                        editor.putString("userBloodGroup", "");
                        editor.putString("userAddress", "");
                        editor.apply();
                        Intent loginPage = new Intent(getApplicationContext(),MainActivity.class);
                        startActivity(loginPage);
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
        alert.setTitle("Login Page Confirmation");
        alert.show();
    }
}
