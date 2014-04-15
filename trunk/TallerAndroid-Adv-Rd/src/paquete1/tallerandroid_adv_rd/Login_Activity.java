package paquete1.tallerandroid_adv_rd;

import org.json.JSONObject;

import paquete2.tallerandroid_adv_rd.Funciones;
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

public class Login_Activity extends Activity {

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
			
			public void onClick(View v) {
				
				Thread thread = new Thread(new Runnable(){
					
					String sCod = edCodigo.getText().toString();
					String sPas = edPassword.getText().toString();
					
				    @Override
				    public void run() {
				    	Funciones oFun = new Funciones();
						JSONObject oJson = oFun.login(sCod,sPas);//Envia los parametros.
						
				    	try{
							String sInfo = oJson.getString("info");//informa del evento.
							
							if (oJson.getString("status")=="no login!") {
								Toast.makeText(getApplicationContext(),sInfo, Toast.LENGTH_SHORT).show();
							}else if(oJson.getString("status") == "error!") {
								Toast.makeText(getApplicationContext(),sInfo, Toast.LENGTH_SHORT).show();
							}else if(oJson.getString("status") !="ok!") {
								Log.e("acceso denegado",oJson.getString("info") );
								Toast.makeText(getApplicationContext(),"Error en el servicio", Toast.LENGTH_SHORT).show();
							}else{
								
									if(oJson.getString("usuario")=="alumno")
									{	Intent itAlum = new Intent(getApplicationContext(), Alumno_Activity.class);
										startActivity(itAlum);}
									else
									{	Intent itPro = new Intent(getApplicationContext(), Profesor_Activity.class);
									startActivity(itPro);}
							}
						}catch (Exception e) {
							Log.e("ERROR-SERVICIO", e.getMessage());
						}
				    }
				});

				thread.start(); 
				
			}
		});
	}

	

}
