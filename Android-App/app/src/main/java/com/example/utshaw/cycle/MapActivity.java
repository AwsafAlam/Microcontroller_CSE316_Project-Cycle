package com.example.utshaw.cycle;

import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.design.widget.BottomSheetBehavior;
import android.support.design.widget.NavigationView;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.text.TextUtils;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.common.api.Status;
import com.google.android.gms.location.places.Place;
import com.google.android.gms.location.places.ui.PlaceAutocompleteFragment;
import com.google.android.gms.location.places.ui.PlaceSelectionListener;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.MapFragment;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.model.CameraPosition;

public class MapActivity extends AppCompatActivity implements OnMapReadyCallback,
        NavigationView.OnNavigationItemSelectedListener{

    private GoogleMap mMap;
    private DrawerLayout mDrawerLayout;
    private ActionBarDrawerToggle mToggle;
    private Toolbar mToolbar;
    private BottomSheetBehavior sheetBehavior;
    private Button btn;
    private TextView textView;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_map);

        String barcode = getIntent().getStringExtra("code");

        textView = findViewById(R.id.barcode);
        if (TextUtils.isEmpty(barcode)) {
            //Toast.makeText(getApplicationContext(), "Barcode is empty!", Toast.LENGTH_LONG).show();
            //finish();
            textView.setText("No Code");
        }
        else{
            textView.setText(barcode);
            sendtoGSM(barcode);
        }

        mToolbar = findViewById(R.id.nav_action);
        setSupportActionBar(mToolbar);

//        android.support.v7.app.ActionBar actionBar = getSupportActionBar();
//        actionBar.hide();
//        actionBar.setDisplayHomeAsUpEnabled(true);

        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);

        mDrawerLayout = findViewById(R.id.drawerlayout);
        mToggle = new ActionBarDrawerToggle(this , mDrawerLayout , R.string.Open_nav,R.string.Close_nav);

        mDrawerLayout.addDrawerListener(mToggle);
        mToggle.syncState();

        btn = findViewById(R.id.unlock);

        btn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
//                Toast.makeText(this , "Clicked acc" , Toast.LENGTH_SHORT).show();
                startActivity(new Intent(MapActivity.this, ScannerActivity.class));

            }
        });


//        layoutBottomSheet = findViewById(R.id.bottom_sheet);

//        sheetBehavior = BottomSheetBehavior.from(layoutBottomSheet);
        sheetBehavior = BottomSheetBehavior.from(findViewById(R.id.bottom_sheet));

        sheetBehavior.setBottomSheetCallback(new BottomSheetBehavior.BottomSheetCallback() {
            @Override
            public void onStateChanged(@NonNull View bottomSheet, int newState) {
                switch (newState) {
                    case BottomSheetBehavior.STATE_HIDDEN:
                        sheetBehavior.setState(BottomSheetBehavior.STATE_EXPANDED);
                        break;
                    case BottomSheetBehavior.STATE_EXPANDED: {
//                        btnBottomSheet.setText("Close Sheet");
//                        Toast.makeText(this , "Bottom sheet triggerd",Toast.LENGTH_SHORT).show();
                    }
                    break;
                    case BottomSheetBehavior.STATE_COLLAPSED: {
//                        btnBottomSheet.setText("Expand Sheet");
//                          Toast.makeText(this,"cloased",Toast.LENGTH_SHORT).show();
                    }
                    break;
                    case BottomSheetBehavior.STATE_DRAGGING:
                        break;
                    case BottomSheetBehavior.STATE_SETTLING:
                        break;
                }
            }

            @Override
            public void onSlide(@NonNull View bottomSheet, float slideOffset) {

            }
        });

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowTitleEnabled(false);

        MapFragment mapFragment = (MapFragment)
                getFragmentManager().findFragmentById(R.id.map);
        mapFragment.getMapAsync(MapActivity.this);


        PlaceAutocompleteFragment autocompleteFragment = (PlaceAutocompleteFragment)
                getFragmentManager().findFragmentById(R.id.place_autocomplete_fragment);



        autocompleteFragment.setOnPlaceSelectedListener(new PlaceSelectionListener() {
            @Override
            public void onPlaceSelected(Place place) {
                // TODO: Get info about the selected place.
                Toast.makeText(MapActivity.this, place.getName(), Toast.LENGTH_SHORT).show();



                CameraPosition cameraPosition = new CameraPosition.Builder()
                        .target(place.getLatLng())      // Sets the center of the map to Mountain View
                        .zoom(17)                   // Sets the zoom
                        .bearing(90)                // Sets the orientation of the camera to east
                        .tilt(30)                   // Sets the tilt of the camera to 30 degrees
                        .build();                   // Creates a CameraPosition from the builder
                mMap.animateCamera(CameraUpdateFactory.newCameraPosition(cameraPosition));

            }

            @Override
            public void onError(Status status) {
                // TODO: Handle the error.
                Log.i("Utshaw", "An error occurred: " + status);
            }
        });
    }

    private void sendtoGSM(String barcode) {

        String phoneNumber = "+8801556358935";
        String message = "Sending Test Message : "+barcode;

        Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse("sms:" + phoneNumber));
        intent.putExtra("sms_body", message);
        startActivity(intent);
    }


    @Override
    public boolean onOptionsItemSelected(MenuItem item) {

        if(mToggle.onOptionsItemSelected(item)){
            int id = item.getItemId();

            if(id == R.id.user){
                Toast.makeText(this , "Clicked acc" , Toast.LENGTH_SHORT).show();
                startActivity(new Intent(MapActivity.this, ScannerActivity.class));
                return true;

            }
            else if(id == R.id.places){
                return true;
            }
        }

        return super.onOptionsItemSelected(item);
    }


    @Override
    public boolean onNavigationItemSelected(@NonNull MenuItem item) {
        int id = item.getItemId();

        if(id == R.id.timeline){
            Toast.makeText(this , "Clicked timeLine---" , Toast.LENGTH_SHORT).show();
            startActivity(new Intent(MapActivity.this, ScannerActivity.class));
            return true;
        }
        return false;
    }

    @Override
    public void onMapReady(GoogleMap googleMap) {
        mMap = googleMap;
    }
}
