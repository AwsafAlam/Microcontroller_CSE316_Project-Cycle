package com.example.utshaw.cycle.Activity;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.text.InputType;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.example.utshaw.cycle.Model.LocationInfo;
import com.example.utshaw.cycle.Model.Response;
import com.example.utshaw.cycle.R;
import com.example.utshaw.cycle.Rest.ApiClient;
import com.example.utshaw.cycle.Rest.ApiInterface;
import com.example.utshaw.cycle.ui.SplashScreen;

import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;

public class PaymentActivity extends AppCompatActivity {

    private TextView Recharge , CreditCard , Balance;
    private Button Promo_Code;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_payment);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowTitleEnabled(false);

        Balance = findViewById(R.id.balance);
        Recharge = findViewById(R.id.recharge);
        CreditCard = findViewById(R.id.credit);
        Promo_Code = findViewById(R.id.button_signin);

        int bal = 0;
        Balance.setText("৳ "+bal);

        final SharedPreferences sharedPreferences = getSharedPreferences("appInfo", Context.MODE_PRIVATE);
        String promo = sharedPreferences.getString("balance", "");

        if(!promo.equals("")){
            Balance.setText("৳ "+promo);
        }

        Recharge.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
               // startActivity(new Intent(PaymentActivity.this , CheckOutActivity.class));
            }
        });

        CreditCard.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(PaymentActivity.this , CheckOutActivity.class));
            }
        });

        Promo_Code.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                AlertDialog.Builder alert = new AlertDialog.Builder(PaymentActivity.this);

                alert.setTitle("Add Promo Code");



                // Set an EditText view to get user input
                final EditText input = new EditText(PaymentActivity.this);
                //input.setBackgroundResource(R.drawable.login_edittext_background);
                input.setInputType(InputType.TYPE_CLASS_NUMBER);
                input.setPadding(15,10,15,15);
                input.setEms(10);

                input.setWidth(150);

                alert.setView(input);

                alert.setPositiveButton("Ok", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int whichButton) {

                        String value = String.valueOf(input.getText());
                        // Do something with value!
                        Toast.makeText(PaymentActivity.this, "Promo Code Applied", Toast.LENGTH_SHORT).show();
                        final SharedPreferences sharedPreferences = getSharedPreferences("appInfo", Context.MODE_PRIVATE);
                        SharedPreferences.Editor editor = sharedPreferences.edit();
                        String promo = sharedPreferences.getString("balance", "");
                        int bal =0;
                        if(!promo.equals("")){
                            bal += Integer.getInteger(promo);
                        }
                        bal += 50;
                        Balance.setText("৳ "+bal);

                        editor.putString("balance", String.valueOf(bal));
                        editor.putString("promoapplied", "true");
                        editor.apply();

//                        final String code = value;
//                        ApiInterface apiService =
//                                ApiClient.getClient().create(ApiInterface.class);
//
//                        Call<Response> call = apiService.startRide(value); //Sending Bike code to API
//                        call.enqueue(new Callback<Response>() {
//                            @Override
//                            public void onResponse(Call<Response> call, retrofit2.Response<Response> response) {
//                                List<LocationInfo> LocationObj = response.body().getResults();
//                                //Log.d(TAG, "Returned: " + LocationObj.size());
//                                //textView.setText(textView.getText() + " ->" + LocationObj.get(0).getOverview());
//
//                            }
//
//                            @Override
//                            public void onFailure(Call<Response> call, Throwable t) {
//                                //Log.e(TAG, t.toString());
//
//                            }
//
//
//                        });


                    }
                });

                alert.setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int whichButton) {
                        // Canceled.
                    }
                });

                alert.show();
            }
        });

    }

}
