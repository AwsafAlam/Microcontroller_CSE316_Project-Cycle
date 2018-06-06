package com.example.utshaw.cycle.Model;

import com.google.gson.annotations.SerializedName;

import java.util.ArrayList;
import java.util.List;


public class LocationInfo {

    @SerializedName("0")
    private List<Double> locProperties = new ArrayList<Double>();
    @SerializedName("occupied")
    private int occupied;
    @SerializedName("overview")
    private String overview;
    @SerializedName("release_date")
    private String releaseDate;
    @SerializedName("bike_id")
    private Integer bike_id;
    @SerializedName("rating")
    private String rating;

    public List<Double> getLocProperties() {
        return locProperties;
    }

    public void setLocProperties(List<Double> locProperties) {
        this.locProperties = locProperties;
    }

    public int isOccupied() {
        return occupied;
    }

    public void setOccupied(int occupied) {
        this.occupied = occupied;
    }

    public String getOverview() {
        return overview;
    }

    public void setOverview(String overview) {
        this.overview = overview;
    }

    public String getReleaseDate() {
        return releaseDate;
    }

    public void setReleaseDate(String releaseDate) {
        this.releaseDate = releaseDate;
    }


    public Integer getBike_id() {
        return bike_id;
    }

    public void setBike_id(Integer bike_id) {
        this.bike_id = bike_id;
    }

    public String getRating() {
        return rating;
    }

    public void setRating(String rating) {
        this.rating = rating;
    }

    public LocationInfo(List<Double> locProperties,
                        int occupied,
                        String overview,
                        String releaseDate,
                        Integer bike_id,
                        String rating) {

        this.locProperties = locProperties;
        this.occupied = occupied;
        this.overview = overview;
        this.releaseDate = releaseDate;
//        this.ridehistory = ridehistory;
        this.bike_id = bike_id;
        this.rating = rating;
    }



}