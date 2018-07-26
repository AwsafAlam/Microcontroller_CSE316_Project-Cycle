package com.example.utshaw.cycle.Activity;


import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.example.utshaw.cycle.Model.LocationInfo;
import com.example.utshaw.cycle.Model.Response;
import com.example.utshaw.cycle.R;
import com.example.utshaw.cycle.Rest.ApiClient;
import com.example.utshaw.cycle.Rest.ApiInterface;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

import retrofit2.Call;
import retrofit2.Callback;

public class Signup_form_two extends AppCompatActivity {

    public static final int RC_SIGN_IN = 1;

    private String userAuthPhoneNumber;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        setTheme(R.style.signupAppTheme);
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signup_form_two);

        this.getWindow().setSoftInputMode(WindowManager.LayoutParams.SOFT_INPUT_ADJUST_PAN);

        Button sign_up_finish_button = (Button) findViewById(R.id.button_signup_finish);

        final EditText signUp_Mobile = (EditText) findViewById(R.id.signupMobile);
        final EditText signUp_Email = (EditText) findViewById(R.id.signupEmail);
        final EditText signUp_address = (EditText) findViewById(R.id.signupAddress);


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
                                editor.putString("userPass", "");
                                editor.putString("userEmail", "");
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
                                editor.putString("userPass", "");
                                editor.putString("userEmail", "");
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
                String given_Mobile = signUp_Mobile.getText().toString();
                String given_Email = signUp_Email.getText().toString();
                String given_address = signUp_address.getText().toString();
                if(given_Email.equals("") ){

                    Toast.makeText(getApplicationContext(), "Please fill up the mandatory fields", Toast.LENGTH_SHORT).show();
                }
                else{
                    final SharedPreferences sharedPreferences = getSharedPreferences("signUpInfo", Context.MODE_PRIVATE);
                    SharedPreferences.Editor editor = sharedPreferences.edit();
                    editor.putString("userMobile", given_Mobile);
                    editor.putString("userEmail", given_Email);
                    editor.putString("userAddress", given_address);
                    editor.putString("loggedIn", "true");
                    editor.apply();


                    Map<String, String> data = new HashMap<>();
                    data.put("username", sharedPreferences.getString("userName", ""));
                    data.put("password", sharedPreferences.getString("userPass", ""));

                    data.put("email", given_Email);
                    data.put("phone", given_Mobile);
                    data.put("address", given_address);


                    ApiInterface apiService =
                            ApiClient.getClient().create(ApiInterface.class);

                    Call<Response> call = apiService.signUP(data); //Sending Bike code to API
                    call.enqueue(new Callback<Response>() {
                        @Override
                        public void onResponse(Call<Response> call, retrofit2.Response<Response> response) {
                            List<LocationInfo> LocationObj = response.body().getResults();
                            //textView.setText(textView.getText() + " ->" + LocationObj.get(0).getOverview());
                            //Toast.makeText(context, "Posted to bike", Toast.LENGTH_SHORT).show();
                            final SharedPreferences sharedPreferences = getSharedPreferences("appInfo", Context.MODE_PRIVATE);
                            SharedPreferences.Editor editor = sharedPreferences.edit();

                            editor.putString("promo", LocationObj.get(0).getOverview());
                            editor.putString("user_id", String.valueOf(2));
                            editor.putString("balance", String.valueOf(0));
                            editor.putString("promoapplied", "false");
                            editor.apply();

                            Intent loginPage = new Intent(getApplicationContext(),MapActivity2.class);
                            startActivity(loginPage);
                            finish();

                        }

                        @Override
                        public void onFailure(Call<Response> call, Throwable t) {
                            Toast.makeText(Signup_form_two.this, "Failed To SignUp, Check Your network Connection", Toast.LENGTH_SHORT).show();
                            Intent loginPage = new Intent(getApplicationContext(),Signup_form_one.class);
                            startActivity(loginPage);
                            finish();

                        }

                    });




                }

            }
        });
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
                        editor.putString("userPass", "");
                        editor.putString("userEmail", "");
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
}
