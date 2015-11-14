package de.systemgrid.sas.unveiledapp;

/**
 * Created by Sebastian on 14.11.15.
 */
public class ServerConnection {

    private String token;

    public ServerConnection(String token) {
        this.token = token;
    }

    public String getToken() {
        return token;
    }

    public void setToken(String token) {
        this.token = token;
    }

    public boolean login(String email, String password) {

        return false;
    }
    
    public static boolean testConnection() {

        return false;
    }
}
