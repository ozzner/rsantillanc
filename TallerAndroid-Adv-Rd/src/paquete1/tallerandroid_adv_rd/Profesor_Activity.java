package paquete1.tallerandroid_adv_rd;

import java.util.ArrayList;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import paquete2.tallerandroid_adv_rd.Funciones;
import android.app.Activity;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

public class Profesor_Activity extends Activity {
	private static String KEY_STATUS="status";
	private static String KEY_INFO  ="info";
	private TextView tvUser;
	private ListView lsvCursos;
	private Spinner spiAlumNotas;
	private Button btnGrabar;
	private EditText edtNota;
	private String sAlumno,sCurso, sNota;
	private String[] arrNombres;
	private String[] arrCursos;
	private String[] arrCodigo;
	private TextView tvLogCat;
	private int cont = 1;
	
	
	/*----------CREATE----------*/	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_profesor);

		tvUser = (TextView) findViewById(R.id.tvWellcomeProfesor);
		Bundle oBundle = getIntent().getExtras();
		tvUser.setText("Bienvenido profesor, " + oBundle.getString("usuario"));
		spiAlumNotas = (Spinner) findViewById(R.id.spinAlumNota);
		tvLogCat = (TextView)findViewById(R.id.tvPantalla);
		btnGrabar = (Button)findViewById(R.id.btnGrabar);
		lsvCursos = (ListView)findViewById(R.id.lsvCursos);
		edtNota = (EditText)findViewById(R.id.edtNota);
		
		btnGrabar.setOnClickListener( new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				String[] arrOutput = new String[cont];
				String sInput;
				sNota = edtNota.getText().toString();
				
				sInput="+----------------------------+\n";
				sInput +=" "+sAlumno+": "+sCurso+": "+sNota+"\n";
				
				for (int i = 0; i < cont; i++) {
					arrOutput[i] = sInput;	}
				
				tvLogCat.setText(arrOutput.toString());
				cont++;	}
		});//end Listener button
		
		lsvCursos.setOnItemSelectedListener(new OnItemSelectedListener() {

			@Override
			public void onItemSelected(AdapterView<?> arg0, View arg1,int arg2, long arg3) {
				sCurso = arrCursos[arg2];}
			
			@Override
			public void onNothingSelected(AdapterView<?> arg0) {}
		});//end Listener listView
		
		
		spiAlumNotas.setOnItemSelectedListener( new OnItemSelectedListener() {
			
			@Override
			public void onItemSelected(AdapterView<?> arg0, View arg1,int arg2, long arg3) {
				sAlumno=arrNombres[arg2]; }

			@Override
			public void onNothingSelected(AdapterView<?> arg0) {}	
			});	//end Listener spinner
		
	} //end OnCreate

	
	
	
	
	
	/*----------INSERTAR NOTAS----------*/
	protected void runBackroundInsertar() {
		AsyncTest2 backgrounTest = new AsyncTest2();
		backgrounTest.execute();
	}

	class AsyncTest2 extends AsyncTask<String, Void, String> {
		String sInfo="";
		@Override
		protected String doInBackground(String... params) {
			String sStatus ="";
			Bundle oBundle = getIntent().getExtras();
			String sProfesor= oBundle.getString("usuario");
			
			Funciones oFun = new Funciones();
			JSONObject oJson = oFun.insertarNota(sCurso, sNota, sAlumno, sProfesor);
		if(oJson!=null){
			try {
				
				 if(!(oJson.getString(KEY_STATUS)).equals("ok!"))				
				 { sInfo = oJson.getString(KEY_INFO);
				   sStatus = oJson.getString(KEY_STATUS);}											
				 					 
			}catch (JSONException e) {
				Log.e("TAG", "Error con el servicio: " + e.getMessage());
			}
		
		}else{
			sStatus = "error"; }
		
			return sStatus;
			}
		
			@Override
			protected void onPostExecute(String result) {
				if(result=="ok!")
					Toast.makeText(getApplicationContext(), "Successful!", Toast.LENGTH_SHORT).show();
				else
					Toast.makeText(getApplicationContext(), "Error!", Toast.LENGTH_SHORT).show();
			}

	
		}

		
	
	

	
	
	
	
	/*----------LLENAR SPINNER----------*/
	protected void  runBackroundSpinner() {
		AsyncTest backgrounTest = new AsyncTest();
		backgrounTest.execute();
	}

	class AsyncTest extends AsyncTask<String, Void, String> {

		@Override
		protected String doInBackground(String... params) {
			Funciones oFun = new Funciones();
			JSONObject oJson = oFun.listarAlumnos();// Envia los
													// parametros.}
			try {
				JSONArray jsArrData = new JSONArray(oJson.getJSONArray("data").toString());
				
				int tama�o = jsArrData.length();
				arrNombres = new String[tama�o];
				arrCodigo = new String[tama�o];

				for (int i = 0; i <= jsArrData.length(); i++) {
					JSONObject data = jsArrData.getJSONObject(i);
					arrNombres[i] = data.getString("nombre");
					 arrCodigo[i] = data.getString("codigo");
				}
			} catch (JSONException e) {
				Log.e("TAG", "Problemas con array: " + e.getMessage());
			}

			return null;
		}

		@Override
		protected void onPostExecute(String result) {
			
			ArrayAdapter<String> arrAdapter1 = new ArrayAdapter<String>(
					Profesor_Activity.this, android.R.layout.simple_list_item_1,R.array.arrCursos);
			lsvCursos.setAdapter(arrAdapter1);
					
			ArrayAdapter<String> arrAdapter2 = new ArrayAdapter<String>(
					Profesor_Activity.this, android.R.layout.simple_spinner_dropdown_item, arrNombres);
			spiAlumNotas.setAdapter(arrAdapter2);

		}

	}//end llenar spinner
	
	
	
	
	/*----------MENU----------*/
	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.menu, menu);
		return true;
	}

	@Override
	public boolean onOptionsItemSelected(MenuItem item) {

		switch (item.getItemId()) {
		case R.id.mnu1:
			runBackroundSpinner();
			break;
		case R.id.mnu2:
			Intent itLogin = new Intent(getApplicationContext(),
					Login_Activity.class);
			startActivity(itLogin);
			finish();
			break;
		}
		return super.onOptionsItemSelected(item);
	}



}