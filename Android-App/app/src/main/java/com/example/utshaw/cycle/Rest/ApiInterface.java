package com.example.utshaw.cycle.Rest;

import com.example.utshaw.cycle.Model.Response;
import retrofit2.Call;
import retrofit2.http.GET;
import retrofit2.http.Path;
import retrofit2.http.Query;


public interface ApiInterface {
    @GET("startRide")
    Call<Response> getNearbyBikes(@Query("id") String apiKey);

    @GET("endRide")
    Call<Response> endRide(@Query("id") String apiKey);

    // This will generate the URL
    //  @GET("movie/toprated")
    // http://onlinesohopathi.com/movie/top_rated?api_key=1234567891011121

    @GET("movie/{id}")
    Call<Response> getBikeDetails(@Path("id") int id, @Query("api_key") String apiKey);
    //For using dynamic paths


    //Documentation-----------------

//    Each endpoint specifies an annotation of the HTTP method (GET, POST, etc.) and the parameters of this method can also have special annotations (@Query, @Path, @Body etc.)
//
//    Take a look to other annotations:
//
//    @Path – variable substitution for the API endpoint. For example movie id will be swapped for{id} in the URL endpoint.
//
//    @Query – specifies the query key name with the value of the annotated parameter.
//
//    @Body – payload for the POST call
//
//    @Header – specifies the header with the value of the annotated parameter

}