package com.example.asus.myrestagain;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import java.io.BufferedReader;
import java.io.Console;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.io.UnsupportedEncodingException;
import java.net.URL;
import java.net.URLConnection;
import java.net.URLEncoder;
import org.apache.http.client.HttpClient;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import android.os.AsyncTask;
import android.os.Bundle;
import android.app.Activity;
import android.app.ProgressDialog;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;


public class Main2Activity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main2);
        final EditText tv = (EditText) findViewById(R.id.editText1);


        final Button btn = (Button) findViewById(R.id.fetchdictionary);

        btn.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View arg0) {

                // WebServer Request URL
                //String serverURL = "http://localhost:8080/goals";
                String geturl = "http://www.just2test.in/jay/fun.php?word="+tv.getText();
                // Use AsyncTask execute Method To Prevent ANR Problem
                LongOperation lg = new LongOperation();
                lg.execute(geturl);

            }
        });




    }


    private class LongOperation  extends AsyncTask<String, Void, Void> {

        // Required initialization

        private final HttpClient Client = new DefaultHttpClient();
        private String[] Content =  new String[100];
        public  String[] abc =  new String[100];
        private String Error = null;
        private ProgressDialog Dialog = new ProgressDialog(Main2Activity.this);
        String data ="";
        //TextView uiUpdate = (TextView) findViewById(R.id.output);
        TextView jsonParsed = (TextView) findViewById(R.id.jsonParsed);
        int sizeData = 0;
        //EditText serverText = (EditText) findViewById(R.id.serverText);


        protected void onPreExecute() {
            // NOTE: You can call UI Element here.

            //Start Progress Dialog (Message)

            Dialog.setMessage("Please wait..");
            Dialog.show();

          /*  try{
                // Set Request parameter
                data +="&" + URLEncoder.encode("data", "UTF-8") + "="+serverText.getText();

            } catch (UnsupportedEncodingException e) {
                // TODO Auto-generated catch block
                e.printStackTrace();
            }
*/
        }

        // Call after onPreExecute method
        protected Void doInBackground(String... urls) {

            /************ Make Post Call To Web Server ***********/
            BufferedReader reader=null;

            // Send data
            try
            {

                // Defined URL  where to send data
                URL url = new URL(urls[0]);

                // Send POST data request

                URLConnection conn = url.openConnection();
                conn.setDoOutput(true);
                OutputStreamWriter wr = new OutputStreamWriter(conn.getOutputStream());
                wr.write( data );
                wr.flush();

                // Get the server response

                reader = new BufferedReader(new InputStreamReader(conn.getInputStream()));
                StringBuilder sb = new StringBuilder();
                String line = null;

                // Read Server Response
                while((line = reader.readLine()) != null)
                {
                    // Append server response in string
                    sb.append(line + " ");
                }

                // Append Server Response To Content String
                Content[0] = sb.toString();
                abc=Content;
            }
            catch(Exception ex)
            {
                Error = ex.getMessage();
            }
            finally
            {
                try
                {

                    reader.close();
                }

                catch(Exception ex) {}
            }

            /*****************************************************/
            return null;
        }

        protected void onPostExecute(Void unused) {
            // NOTE: You can call UI Element here.

            // Close progress dialog
            Dialog.dismiss();

            if (Error != null) {

                //uiUpdate.setText("Output : "+Error);

            } else {

                // Show Response Json On Screen (activity)
                //uiUpdate.setText(Content);

                /****************** Start Parse Response JSON Data *************/

                String OutputData = "";
                JSONObject jsonResponse;


                try {

                    /****** Creates a new JSONObject with name/value mappings from the JSON string. ********/
                    //textView11.setText(""+Content[0].length());


                        for (int i = 0; i < Content[0].length(); i++) {
                            jsonParsed.setText(Content[0].replaceAll("\\[", "").replaceAll("\\]","").replaceAll("[=+-]",""));
                        }


                    jsonResponse = new JSONObject(Content[0]);

                    /***** Returns the value mapped by name if it exists and is a JSONArray. ***/
                    /*******  Returns null otherwise.  *******/
                    JSONArray jsonMainNode = jsonResponse.optJSONArray("main");

                    /*********** Process each JSON Node ************/

                    int lengthJsonArr = jsonMainNode.length();

                    for(int i=0; i < lengthJsonArr; i++)
                    {
                        /****** Get Object for each JSON node.***********/
                        JSONObject jsonChildNode = jsonMainNode.getJSONObject(i);

                        /******* Fetch node values **********/
                        String word       =   jsonChildNode.optString("word").toString();
                        String meaning     =  jsonChildNode.optString("meaning").toString();
                        //String date_added = jsonChildNode.optString("date_added").toString();


                        OutputData +="\r\n"+"Word:\t"+ word +"\r\n";
                        OutputData+= "Meaning:\t"+ meaning + "\r\n";


                    }
                    /****************** End Parse Response JSON Data *************/

                    //Show Parsed Output on screen (activity)
                    Toast.makeText(Main2Activity.this, ""+lengthJsonArr+ "\t entries fetched", Toast.LENGTH_LONG).show();
                    //jsonParsed.setText(OutputData);



                } catch (JSONException e) {

                    e.printStackTrace();
                }


            }
        }
    }

}
