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
 private static String KEY_INFO  ="info";
 private static String KEY_USUARIO="usuario";
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
			    		
			    		if ((oJson.get(KEY_STATUS).toString()).equals("no login!")) {
								sInfo = oJson.getString(KEY_INFO);
								sStat = oJson.getString(KEY_STATUS);
								
						}else if((oJson.get(KEY_STATUS).toString()).equals("no user!")) {
								sInfo = oJson.getString(KEY_INFO);
								sStat = oJson.getString(KEY_STATUS);
								
						}else if((oJson.get(KEY_STATUS).toString()).equals("user!")) {
								sInfo = oJson.getString(KEY_INFO);
								sStat = oJson.getString(KEY_STATUS);
							
						}else if((oJson.get(KEY_STATUS).toString()).equals("ok!")) {
								sStat = oJson.getString(KEY_STATUS);
								
								if((oJson.getString(KEY_USUARIO)).equals("alumno"))
								{	Intent itAlum = new Intent(getApplicationContext(), Alumno_Activity.class);
									itAlum.putExtra(KEY_USUARIO,(oJson.getString("nombre")));//Transfiero el usuario
									startActivity(itAlum);finish();}
								else
								{	Intent itPro = new Intent(getApplicationContext(), Profesor_Activity.class);
									itPro.putExtra(KEY_USUARIO,(oJson.getString("nombre")));
									startActivity(itPro);finish();}
						}else{
							sInfo = oJson.getString(KEY_INFO);
							sStat = oJson.getString("KEY_STATUS");
							}
				    	} catch (JSONException e) {
							e.printStackTrace();
						}
						return sStat;
					}
										
					protected void onPostExecute(String result) {
						System.out.println("REsultado onPost: "+result);
						if(result.equals("no user!"))
							Toast.makeText(getApplicationContext(), sInfo, Toast.LENGTH_SHORT).show();
						else if(result.equals("no login!"))
							Toast.makeText(getApplicationContext(), sInfo, Toast.LENGTH_SHORT).show();
						else if(result.equals("user!"))
							Toast.makeText(getApplicationContext(), sInfo, Toast.LENGTH_SHORT).show();
						else if(result.equals("ok!")){
							Toast.makeText(getApplicationContext(), "Wellcome!", Toast.LENGTH_LONG).show();
						}else
						Toast.makeText(getApplicationContext(),"Error: "+sInfo, Toast.LENGTH_SHORT).show();
			        }

				}

		});
		
	} 
}
