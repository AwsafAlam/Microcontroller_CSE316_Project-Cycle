package com.example.utshaw.cycle.ui.chat.view;

import android.Manifest;
import android.bluetooth.BluetoothAdapter;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Location;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.design.widget.BottomSheetBehavior;
import android.support.design.widget.NavigationView;
import android.support.v4.app.ActivityCompat;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.example.utshaw.cycle.Activity.MainActivity;
import com.example.utshaw.cycle.Activity.MapActivity;
import com.example.utshaw.cycle.Activity.MapActivity2;
import com.example.utshaw.cycle.Model.LocationInfo;
import com.example.utshaw.cycle.Model.Response;
import com.example.utshaw.cycle.MyApp;
import com.example.utshaw.cycle.R;
import com.example.utshaw.cycle.Rest.ApiClient;
import com.example.utshaw.cycle.Rest.ApiInterface;
import com.example.utshaw.cycle.ui.chat.data.ChatModule;
import com.example.utshaw.cycle.ui.chat.data.DaggerChatComponent;
import com.example.utshaw.cycle.ui.chat.presenter.ChatPresenter;
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
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;

import java.util.List;

import javax.inject.Inject;

import butterknife.BindView;
import butterknife.ButterKnife;
import retrofit2.Call;
import retrofit2.Callback;

/**
 * Created by Omar on 20/12/2017.
 */

public class ChatActivity extends AppCompatActivity implements ChatView,OnMapReadyCallback,
        NavigationView.OnNavigationItemSelectedListener {
    @BindView(R.id.activity_chat_status) TextView state;
    @BindView(R.id.activity_chat_messages) TextView messages;

        private GoogleMap mMap;
        private DrawerLayout mDrawerLayout;
        private ActionBarDrawerToggle mToggle;
        private Toolbar mToolbar;
        private BottomSheetBehavior sheetBehavior;
        private Button btn;
        private TextView textView;
        private FusedLocationProviderClient mFusedLocationProviderClient;

        private static final String TAG = MainActivity.class.getSimpleName();
        private static final float DEFAUlT_ZOOM = 15f;
        @Inject
        ChatPresenter presenter;

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_chat);

        DaggerChatComponent.builder()
            .bluetoothModule(MyApp.app().bluetoothModule())
            .chatModule(new ChatModule(this))
            .build().inject(this);

        ButterKnife.bind(this);

        presenter.onCreate(getIntent());
        String barcode = "1";

        btn = findViewById(R.id.unlock);

        btn.setOnClickListener(new View.OnClickListener() {
           @Override
           public void onClick(View v) {
               ApiInterface apiService =
                       ApiClient.getClient().create(ApiInterface.class);

               Call<Response> call = apiService.endRide("1"); //Sending Bike code to API
               call.enqueue(new Callback<Response>() {
                   @Override
                   public void onResponse(Call<Response> call, retrofit2.Response<Response> response) {
                       List<LocationInfo> LocationObj = response.body().getResults();
                       Log.d(TAG, "Returned: " + LocationObj.size());
                       //textView.setText(textView.getText() + " ->" + LocationObj.get(0).getOverview());
                       //presenter.onStop();
                       onHelloWorld0();
                       //Disable bluetooth
                       BluetoothAdapter mBluetoothAdapter = BluetoothAdapter.getDefaultAdapter();
                       if (mBluetoothAdapter.isEnabled()) {
                           mBluetoothAdapter.disable();
                       }
                       startActivity(new Intent(ChatActivity.this, MapActivity2.class));
                        finish();
                   }

                   @Override
                   public void onFailure(Call<Response> call, Throwable t) {
                       Log.e(TAG, t.toString());

                   }


                  });
               }
           });

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

        MapFragment mapFragment = (MapFragment)
                getFragmentManager().findFragmentById(R.id.map);
        mapFragment.getMapAsync(ChatActivity.this);


        PlaceAutocompleteFragment autocompleteFragment = (PlaceAutocompleteFragment)
                getFragmentManager().findFragmentById(R.id.place_autocomplete_fragment);


        autocompleteFragment.setOnPlaceSelectedListener(new PlaceSelectionListener() {
            @Override
            public void onPlaceSelected(Place place) {
                // TODO: Get info about the selected place.
                Toast.makeText(ChatActivity.this, place.getName(), Toast.LENGTH_SHORT).show();


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

//        mDrawerLayout = findViewById(R.id.drawerlayout);
//        mToggle = new ActionBarDrawerToggle(this, mDrawerLayout, R.string.Open_nav, R.string.Close_nav);

//        mDrawerLayout.addDrawerListener(mToggle);
//        mToggle.syncState();

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawerlayout);
        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);
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

                        moveCamera(new LatLng(currentLocation.getLatitude(), currentLocation.getLongitude()), DEFAUlT_ZOOM);

                    } else {
                        Toast.makeText(ChatActivity.this, "Unable to get current location", Toast.LENGTH_SHORT).show();
                    }
                }
            });

        } catch (SecurityException e) {

        }

    }

    private void moveCamera(LatLng latLng, float zoom) {
        mMap.moveCamera(CameraUpdateFactory.newLatLngZoom(latLng, zoom));
    }

    private void sendtoGSM(String barcode) {

        ApiInterface apiService =
                ApiClient.getClient().create(ApiInterface.class);

        Call<Response> call = apiService.getNearbyBikes(barcode); //Sending Bike code to API
        call.enqueue(new Callback<Response>() {
            @Override
            public void onResponse(Call<Response> call, retrofit2.Response<Response> response) {
                List<LocationInfo> LocationObj = response.body().getResults();
                Log.d(TAG, "Returned: " + LocationObj.size());
                textView.setText(textView.getText() + " ->" + LocationObj.get(0).getOverview());

            }

            @Override
            public void onFailure(Call<Response> call, Throwable t) {
                Log.e(TAG, t.toString());

            }


        });

    }

    public void onHelloWorld1(){
        presenter.onHelloWorld1();
    }

    public void onHelloWorld0(){
        presenter.onHelloWorld();
    }

    @Override
    public void onMapReady(GoogleMap googleMap) {
        mMap = googleMap;
        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {

            return;
        }
        getDeviceLocation();
        mMap.setMyLocationEnabled(true);
    }

    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawerlayout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }



    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        int id = item.getItemId();

        if (id == R.id.user) {

            Toast.makeText(this, "Camera Clicked", Toast.LENGTH_SHORT).show();

            // Handle the camera action
        }
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawerlayout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }


    @Override
    public void setStatus(String status) {
        state.setText(status);
    }

    @Override
    public void setStatus(int resId) {
        state.setText(resId);
    }

    @Override
    public void appendMessage(String message) {
        String str = messages.getText()+"\n"+message;
        messages.setText(str);
    }

    @Override
    public void enableHWButton(boolean enabled) {
        //helloWorld1.setEnabled(enabled);
        //Toast.makeText(this, "Ride Started", Toast.LENGTH_SHORT).show();
    }

    @Override
    public void showToast(String message) {
        Toast.makeText(this, message, Toast.LENGTH_SHORT).show();
    }

    @Override
    protected void onStart() {
        super.onStart();
        presenter.onStart(this);
    }

    @Override
    protected void onStop() {
        super.onStop();
        presenter.onStop();
    }
}
