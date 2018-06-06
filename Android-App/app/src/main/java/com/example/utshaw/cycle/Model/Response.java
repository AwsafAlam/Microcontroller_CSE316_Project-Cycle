package com.example.utshaw.cycle.Model;


import com.google.gson.annotations.SerializedName;

import java.util.List;


public class Response {

    @SerializedName("0")
    private List<LocationInfo> results;
    @SerializedName("nearby")
    private int nearby;
    @SerializedName("total_results")
    private int totalResults;
    @SerializedName("total_bikes")
    private int totalBikes;

    public int getNearby() {
        return nearby;
    }

    public void setNearby(int nearby) {
        this.nearby = nearby;
    }

    public List<LocationInfo> getResults() {
        return results;
    }

    public void setResults(List<LocationInfo> results) {
        this.results = results;
    }

    public int getTotalResults() {
        return totalResults;
    }

    public void setTotalResults(int totalResults) {
        this.totalResults = totalResults;
    }

    public int getTotalBikes() {
        return totalBikes;
    }

    public void setTotalBikes(int totalBikes) {
        this.totalBikes = totalBikes;
    }
}