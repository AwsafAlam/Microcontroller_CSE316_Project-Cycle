package com.example.utshaw.cycle.Activity;

import android.Manifest;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.location.Location;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.design.widget.BottomSheetBehavior;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AlertDialog;
import android.util.Log;
import android.view.View;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.example.utshaw.cycle.Model.LocationInfo;
import com.example.utshaw.cycle.Model.Response;
import com.example.utshaw.cycle.R;
import com.example.utshaw.cycle.Rest.ApiClient;
import com.example.utshaw.cycle.Rest.ApiInterface;
import com.example.utshaw.cycle.ui.SplashScreen;
import com.example.utshaw.cycle.ui.chat.view.ChatActivity;
import com.example.utshaw.cycle.ui.scan.view.ScanActivity;
import com.google.android.gms.common.api.Status;
import com.google.android.gms.location.FusedLocationProviderClient;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.location.places.Place;
import com.google.android.gms.location.places.ui.PlaceAutocompleteFragment;
import com.google.android.gms.location.places.ui.PlaceSelectionListener;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.MapFragment;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.model.CameraPosition;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.karumi.dexter.Dexter;
import com.karumi.dexter.MultiplePermissionsReport;
import com.karumi.dexter.PermissionToken;
import com.karumi.dexter.listener.PermissionRequest;
import com.karumi.dexter.listener.multi.MultiplePermissionsListener;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;

public class MapActivity2 extends AppCompatActivity
        implements OnMapReadyCallback, NavigationView.OnNavigationItemSelectedListener{

    private GoogleMap mMap;
    private FusedLocationProviderClient mFusedLocationProviderClient;

    private static final String TAG = MainActivity.class.getSimpleName();
    private static final float DEFAUlT_ZOOM = 15f;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_map2);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowTitleEnabled(false);

        FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.fab);
        fab.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Snackbar.make(view, "Scan to unlock Bike", Snackbar.LENGTH_LONG)
                        .setAction("Action", null).show();
                startActivity(new Intent(MapActivity2.this, ScannerActivity.class));
                finish();
            }
        });

        askPermissions();

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.addDrawerListener(toggle);
        toggle.syncState();

        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);

        MapFragment mapFragment = (MapFragment)
                getFragmentManager().findFragmentById(R.id.map);
        mapFragment.getMapAsync(MapActivity2.this);


        PlaceAutocompleteFragment autocompleteFragment = (PlaceAutocompleteFragment)
                getFragmentManager().findFragmentById(R.id.place_autocomplete_fragment);


        autocompleteFragment.setOnPlaceSelectedListener(new PlaceSelectionListener() {
            @Override
            public void onPlaceSelected(Place place) {
                // TODO: Get info about the selected place.
                Toast.makeText(MapActivity2.this, place.getName(), Toast.LENGTH_SHORT).show();


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
                Toast.makeText(MapActivity2.this, "Handle AutoComplete Fragment", Toast.LENGTH_SHORT).show();
                Log.i("Utshaw", "An error occurred: " + status);
            }
        });

    }

    void askPermissions(){
        Dexter.withActivity(this).withPermissions(
                Manifest.permission.ACCESS_FINE_LOCATION,
                Manifest.permission.INTERNET,
                Manifest.permission.ACCESS_COARSE_LOCATION)
                .withListener(new MultiplePermissionsListener() {
                    @Override
                    public void onPermissionsChecked(MultiplePermissionsReport report) {
                        if(report.areAllPermissionsGranted()){
                            //Intent intent = new Intent(MapActivity2.this, MapActivity2.class);
                            //startActivity(intent);
                            //finish();

                        }
                        else{
                            Toast.makeText(MapActivity2.this, "We need these permissions...", Toast.LENGTH_SHORT).show();
                            askPermissions();
                        }
                    }

                    @Override
                    public void onPermissionRationaleShouldBeShown(List<PermissionRequest> permissions, PermissionToken token) {
                        token.continuePermissionRequest();
                    }
                }).check();
    }


    @Override
    public void onBackPressed() {
        AlertDialog.Builder a_builder = new AlertDialog.Builder(MapActivity2.this);
        a_builder.setMessage("Do you want to Exit?")
                .setCancelable(false)
                .setPositiveButton("Yes",new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        Intent intent = new Intent(MapActivity2.this, MainActivity.class);
                        //intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                        intent.putExtra("Exit me", true);
                        startActivity(intent);
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

    private void getDeviceLocation() {
        mFusedLocationProviderClient = LocationServices.getFusedLocationProviderClient(this);
        try {

            Task location = mFusedLocationProviderClient.getLastLocation();
            location.addOnCompleteListener(new OnCompleteListener() {
                @Override
                public void onComplete(@NonNull Task task) {
                    if (task.isSuccessful()) {
                        Location currentLocation = (Location) task.getResult();

                        LatLng current = new LatLng(currentLocation.getLatitude(), currentLocation.getLongitude());

                        moveCamera(current, DEFAUlT_ZOOM);


                    } else {
                        Toast.makeText(MapActivity2.this, "Unable to get current location", Toast.LENGTH_SHORT).show();
                    }
                }
            });

        } catch (SecurityException e) {

        }
    }

    private void moveCamera(LatLng latLng, float zoom) {
        mMap.moveCamera(CameraUpdateFactory.newLatLngZoom(latLng, zoom));
    }


    @Override
    public void onMapReady(GoogleMap googleMap) {
        mMap = googleMap;
        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {

            return;
        }

        getDeviceLocation();
        final List<Marker> markerList = new ArrayList<>();

        final ProgressDialog mprogressDialog;
        mprogressDialog = new ProgressDialog(MapActivity2.this);
        mprogressDialog.setCancelable(false);
        mprogressDialog.setMessage("Finding Nearby Bikes");
        mprogressDialog.setProgressStyle(ProgressDialog.STYLE_SPINNER);
        //mprogressDialog.setProgress(0);
        mprogressDialog.show();

        ApiInterface apiService =
                ApiClient.getClient().create(ApiInterface.class);

        Call<Response> call = apiService.getBikeData(); //Sending Bike code to API
        call.enqueue(new Callback<Response>() {
            @Override
            public void onResponse(Call<Response> call, retrofit2.Response<Response> response) {
                List<LocationInfo> LocationObj = response.body().getResults();
                //textView.setText(textView.getText() + " ->" + LocationObj.get(0).getOverview());
                //Toast.makeText(context, "Posted to bike", Toast.LENGTH_SHORT).show();
                if(LocationObj.size() !=0){
                    List<Double> loc = LocationObj.get(0).getLocProperties();

                    LatLng Bike = new LatLng(loc.get(0), loc.get(1));

                    Marker mymarker = mMap.addMarker(new MarkerOptions().position(Bike).title("Bike 1"));
                    markerList.add(mymarker);
                    if (mprogressDialog.isShowing())
                        mprogressDialog.dismiss();
                }

            }

            @Override
            public void onFailure(Call<Response> call, Throwable t) {
                Toast.makeText(MapActivity2.this, "Could Not get Nearby Bikes", Toast.LENGTH_SHORT).show();
                if (mprogressDialog.isShowing())
                    mprogressDialog.dismiss();
            }

        });

//        LatLng home = new LatLng(23.775195, 90.353864);
//
//
//        final Marker mymarker = mMap.addMarker(new MarkerOptions().position(home)
//                .title("Bike 1"));
//
//        LatLng work = new LatLng(23.726174, 90.388636);
//
//        mMap.addMarker(new MarkerOptions().position(work)
//                .title("Bike v"));

//        final float result[] = new float[10];
//
//        Location.distanceBetween(work.latitude , work.longitude , home.latitude , home.longitude , result);

        mMap.setMyLocationEnabled(true);
        mMap.setOnMarkerClickListener(new GoogleMap.OnMarkerClickListener() {
            @Override
            public boolean onMarkerClick(Marker marker) {
                //if(marker.equals(mymarker)){
                    Toast.makeText(MapActivity2.this, "Bike is available ", Toast.LENGTH_SHORT).show();
                    return true;
                //}
                //return false;

            }


        });
    }




    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        int id = item.getItemId();

        if (id == R.id.user) {
            startActivity(new Intent(MapActivity2.this, ProfileActivity.class));
        }
        else if (id == R.id.places) {
            Toast.makeText(this, "My Places", Toast.LENGTH_SHORT).show();
            //startActivity(new Intent(MapActivity2.this, EndActivity.class));

        }
        else if (id == R.id.timeline) {
            Toast.makeText(this, "Timeline", Toast.LENGTH_SHORT).show();
        }
        else if (id == R.id.payment) {
            startActivity(new Intent(MapActivity2.this, PaymentActivity.class));
        }
        else if (id == R.id.promo) {
            startActivity(new Intent(MapActivity2.this, DiscountActivity.class));

        }
        else if (id == R.id.settings) {
            startActivity(new Intent(MapActivity2.this, SettingActivity.class));
        }
        else if (id == R.id.about) {
            // Handle the camera action
            //Toast.makeText(this, "Added user", Toast.LENGTH_SHORT).show();
            startActivity(new Intent(MapActivity2.this, InfoActivity.class));

        }
        else if (id == R.id.lang) {
            // Handle the camera action
            Toast.makeText(this, "This Feature is not available yet", Toast.LENGTH_SHORT).show();
            //startActivity(new Intent(MapActivity2.this, SplashScreen.class));

        }
        else if (id == R.id.log_out) {
            // Handle the camera action
            final SharedPreferences sharedPreferences = getSharedPreferences("signUpInfo", Context.MODE_PRIVATE);
            SharedPreferences.Editor editor = sharedPreferences.edit();
            editor.putString("loggedIn", "false");
            editor.apply();
            Toast.makeText(this, "Logging Out", Toast.LENGTH_SHORT).show();
            startActivity(new Intent(MapActivity2.this, Signup_form_one.class));

        }

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }


}
