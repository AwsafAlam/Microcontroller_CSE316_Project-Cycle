package com.example.utshaw.cycle;

import android.content.Intent;
import android.support.annotation.NonNull;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import com.firebase.ui.auth.AuthUI;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;

import java.util.Arrays;



public class MainActivity extends AppCompatActivity {


//    public static final int RC_SIGN_IN = 1;
//
//    private String userAuthPhoneNumber;
//
//    private FirebaseAuth mFirebaseAuth;
//    private FirebaseAuth.AuthStateListener mAuthStateListener;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);


//
//        mFirebaseAuth = FirebaseAuth.getInstance();
//
//        mAuthStateListener = new FirebaseAuth.AuthStateListener() {
//            @Override
//            public void onAuthStateChanged(@NonNull FirebaseAuth firebaseAuth) {
//                FirebaseUser user = mFirebaseAuth.getCurrentUser();
//                if(user != null){
//                    // user is signed in
//                    onSignedInInitalize();
//                }else{
//                    // user is logged out
//                    startActivityForResult(
//                            AuthUI.getInstance()
//                                    .createSignInIntentBuilder()
//                                    .setAvailableProviders(
//                                            Arrays.asList(
//                                                    new AuthUI.IdpConfig.Builder(AuthUI.PHONE_VERIFICATION_PROVIDER).build()))
//                                    .build(),
//                            RC_SIGN_IN);
//                }
//
//            }
//        };
//



    }
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.menu, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle item selection
        switch (item.getItemId()) {
            case R.id.sign_out:
                AuthUI.getInstance().signOut(this);
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    @Override
    protected void onPause() {
        super.onPause();
//        if(mAuthStateListener != null) {
//            mFirebaseAuth.removeAuthStateListener(mAuthStateListener);
//        }

    }

//    @Override
//    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
//        super.onActivityResult(requestCode, resultCode, data);
//        if(requestCode == RC_SIGN_IN){
//            if(resultCode == RESULT_OK){
//                onSignedInInitalize();
//            }else{
//                Toast.makeText(this, "Cancel signing in!", Toast.LENGTH_SHORT).show();
//                finish();
//            }
//        }
//    }

    @Override
    protected void onResume() {
        super.onResume();

//        mFirebaseAuth.addAuthStateListener(mAuthStateListener);
    }

//    private void onSignedInInitalize(){
//        userAuthPhoneNumber = mFirebaseAuth.getCurrentUser().getPhoneNumber().toString();
//        Toast.makeText(this, "Hello " + userAuthPhoneNumber, Toast.LENGTH_SHORT).show();
//    }


    public void goToMap(View view) {
        startActivity(new Intent(MainActivity.this, MapActivity.class));
    }
}
