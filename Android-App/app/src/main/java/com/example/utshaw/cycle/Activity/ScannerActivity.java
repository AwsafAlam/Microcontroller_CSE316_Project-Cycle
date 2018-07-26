package com.example.utshaw.cycle.Activity;

import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.hardware.Camera;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.text.InputType;
import android.util.SparseArray;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import com.example.utshaw.cycle.Model.LocationInfo;
import com.example.utshaw.cycle.Model.Response;
import com.example.utshaw.cycle.R;
import com.example.utshaw.cycle.Rest.ApiClient;
import com.example.utshaw.cycle.Rest.ApiInterface;
import com.example.utshaw.cycle.ui.SplashScreen;
import com.google.android.gms.vision.barcode.Barcode;

import java.util.List;

import info.androidhive.barcode.BarcodeReader;
import retrofit2.Call;
import retrofit2.Callback;

public class ScannerActivity extends AppCompatActivity implements BarcodeReader.BarcodeReaderListener {

    BarcodeReader barcodeReader;
    boolean flashon = false;
    Camera cam;
    Camera.Parameters p;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_scanner2);

        // get the barcode reader instance
        barcodeReader = (BarcodeReader) getSupportFragmentManager().findFragmentById(R.id.barcode_scanner);

        FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.fab);
        fab.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                if(!flashon){
                    if(getApplicationContext().getPackageManager().hasSystemFeature(PackageManager.FEATURE_CAMERA_FLASH)){
                        cam = Camera.open();
                        p = cam.getParameters();
                        p.setFlashMode(android.hardware.Camera.Parameters.FLASH_MODE_TORCH);
                        cam.setParameters(p);
                        cam.startPreview();
                    }
                    Snackbar.make(view, "Switching Flashlight On", Snackbar.LENGTH_LONG)
                            .setAction("Action", null).show();

                    flashon = true;
                }
                else {
                    if(getApplicationContext().getPackageManager().hasSystemFeature(PackageManager.FEATURE_CAMERA_FLASH)){
                        cam.stopPreview();
                        cam.release();
                    }
                    Snackbar.make(view, "Switching Flashlight Off", Snackbar.LENGTH_LONG)
                            .setAction("Action", null).show();

                    flashon = false;
                }


            }
        });

        FloatingActionButton fab2 = (FloatingActionButton) findViewById(R.id.fab2);
        fab2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Snackbar.make(view, "Manual Input", Snackbar.LENGTH_LONG)
                        .setAction("Action", null).show();

                AlertDialog.Builder alert = new AlertDialog.Builder(ScannerActivity.this);

                alert.setTitle("Get Code to Unlock");

                //alert.setMessage("Message");

                // Set an EditText view to get user input
                final EditText input = new EditText(ScannerActivity.this);
                input.setAllCaps(true);
                //input.setBackgroundResource(R.drawable.login_edittext_background);
                input.setInputType(InputType.TYPE_CLASS_NUMBER);
                input.setPadding(15,10,15,15);
                input.setWidth(200);

                alert.setView(input);

                alert.setPositiveButton("Ok", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int whichButton) {
                        String value = String.valueOf(input.getText());
                        // Do something with value!
                        Toast.makeText(ScannerActivity.this, "Starting Ride Now", Toast.LENGTH_SHORT).show();
                        //startActivity(new Intent(MapActivity2.this, SplashScreen.class));

//                        Intent intent = new Intent(ScannerActivity.this, SplashScreen.class);
//                        intent.putExtra("code", value);
//                        startActivity(intent);

                        final String code = value;
                        ApiInterface apiService =
                                ApiClient.getClient().create(ApiInterface.class);

                        Call<Response> call = apiService.startRide(value); //Sending Bike code to API
                        call.enqueue(new Callback<Response>() {
                            @Override
                            public void onResponse(Call<Response> call, retrofit2.Response<Response> response) {
                                List<LocationInfo> LocationObj = response.body().getResults();
                                //Log.d(TAG, "Returned: " + LocationObj.size());
                                //textView.setText(textView.getText() + " ->" + LocationObj.get(0).getOverview());
                                if(LocationObj.get(0).isOccupied() == 1){
                                    Intent intent = new Intent(ScannerActivity.this, SplashScreen.class);
                                    intent.putExtra("code", code);
                                    startActivity(intent);
                                }
                                else{
                                    Intent intent = new Intent(ScannerActivity.this, MapActivity2.class);
                                    startActivity(intent);
                                }
                            }

                            @Override
                            public void onFailure(Call<Response> call, Throwable t) {
                                //Log.e(TAG, t.toString());
                                Toast.makeText(ScannerActivity.this, "Check Network Connection", Toast.LENGTH_SHORT).show();
                                startActivity(new Intent(ScannerActivity.this , MapActivity2.class));
                            }


                        });


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

    @Override
    public void onScanned(Barcode barcode) {
        // playing barcode reader beep sound
        barcodeReader.playBeep();
        final String code = barcode.displayValue;
        ApiInterface apiService =
                ApiClient.getClient().create(ApiInterface.class);

        Call<Response> call = apiService.startRide(barcode.displayValue); //Sending Bike code to API
        call.enqueue(new Callback<Response>() {
            @Override
            public void onResponse(Call<Response> call, retrofit2.Response<Response> response) {
                List<LocationInfo> LocationObj = response.body().getResults();
                //Log.d(TAG, "Returned: " + LocationObj.size());
                //textView.setText(textView.getText() + " ->" + LocationObj.get(0).getOverview());
                if(LocationObj.get(0).isOccupied() == 1){
                    Intent intent = new Intent(ScannerActivity.this, SplashScreen.class);
                    intent.putExtra("code", code);
                    startActivity(intent);
                }
                else{
                    Intent intent = new Intent(ScannerActivity.this, MapActivity2.class);
                    startActivity(intent);
                    finish();
                }
            }

            @Override
            public void onFailure(Call<Response> call, Throwable t) {
                //Log.e(TAG, t.toString());
                Toast.makeText(ScannerActivity.this, "Check Network Connection", Toast.LENGTH_SHORT).show();
                startActivity(new Intent(ScannerActivity.this , MapActivity2.class));
            }


        });


    }

    @Override
    public void onScannedMultiple(List<Barcode> barcodes) {

    }

    @Override
    public void onBitmapScanned(SparseArray<Barcode> sparseArray) {

    }

    @Override
    public void onScanError(String errorMessage) {
        Toast.makeText(getApplicationContext(), "Error occurred while scanning " + errorMessage, Toast.LENGTH_SHORT).show();
    }

    @Override
    public void onCameraPermissionDenied() {
        finish();
    }
}
