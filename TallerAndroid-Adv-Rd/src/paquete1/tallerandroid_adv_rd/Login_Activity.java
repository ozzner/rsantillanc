package paquete1.tallerandroid_adv_rd;

import org.json.JSONException;
import org.json.JSONObject;
import paquete2.tallerandroid_adv_rd.Funciones;
import android.os.AsyncTask;
import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

public class Login_Activity<Testing> extends Activity {

 private static String KEY_STATUS="status";
	EditText edCodigo;
	EditText edPassword;
	TextView tvMensaje;
	Button 	 bnLogin;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_login);
		
		bnLogin = (Button)findViewById(R.id.btnLogin);
		edCodigo  = (EditText)findViewById(R.id.etCodigo);
		edPassword = (EditText)findViewById(R.id.etPassword);
		
		bnLogin.setOnClickListener(new OnClickListener() {
			
			public void onClick(View v) 
			{
				Testing test =  new Testing();
				test.execute();
				
			}
			
			class Testing extends AsyncTask<String, Void,String> {
				
				String sInfo ="";
					@Override
					protected String doInBackground(String... arg0) {
						
						String sCod  = edCodigo.getText().toString();
						String sPas  = edPassword.getText().toString();
						
						String sStat = "";
				    	Funciones oFun = new Funciones();
						JSONObject oJson = oFun.login(sCod,sPas);//Envia los parametros.
						
						try{
			    		
			    		if ((oJson.get("status").toString()).equals("no login!")) {
								sInfo = oJson.getString("info");
								sStat = oJson.getString("status");
								Log.e("TAG-01", oJson.getString("status"));
						}else if((oJson.get("status").toString()).equals("no user!")) {
								sInfo = oJson.getString("info");
								sStat = oJson.getString("status");
								Log.e("TAG-02", oJson.getString("status"));
						}else if((oJson.get("status").toString()).equals("user!")) {
							sInfo = oJson.getString("info");
							sStat = oJson.getString("status");
							Log.e("TAG-03", oJson.getString("status"));
						}else if((oJson.get("status").toString()).equals("ok!")) {
								sInfo = oJson.getString("info");
								sStat = oJson.getString("status");
								Log.e("TAG-04", oJson.getString("status"));
								if((oJson.getString("usuario")).equals("alumno"))
									
								{	Intent itAlum = new Intent(getApplicationContext(), Alumno_Activity.class);
									startActivity(itAlum);}
								else
								{	Intent itPro = new Intent(getApplicationContext(), Profesor_Activity.class);
									startActivity(itPro);}
						}else{
							sInfo = oJson.getString("info");
							sStat = oJson.getString("status");
							Log.e("TAG-05", oJson.getString("status"));
							}
				    	} catch (JSONException e) {
							e.printStackTrace();
						}
						return sStat;
					}
										
					protected void onPostExecute(String result) {
										
						if(result.equals("no user!"))
							Toast.makeText(getApplicationContext(), sInfo, Toast.LENGTH_SHORT).show();
						else if(result.equals("no login!"))
							Toast.makeText(getApplicationContext(), sInfo, Toast.LENGTH_SHORT).show();
						else if(result.equals("user!"))
							Toast.makeText(getApplicationContext(), sInfo, Toast.LENGTH_SHORT).show();
						else if(result.equals("ok!"))
							Toast.makeText(getApplicationContext(), "Wellcome!", Toast.LENGTH_LONG).show();
						else
						Toast.makeText(getApplicationContext(),"Error: "+sInfo, Toast.LENGTH_SHORT).show();
			        }

			        @Override
			        protected void onPreExecute() {	
			        }

			        protected void onProgressUpdate(Void... values) {
			        }
				}
				
			

		});
		
	}
}
