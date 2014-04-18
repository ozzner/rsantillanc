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
import android.widget.Spinner;
import android.widget.TextView;

public class Profesor_Activity extends Activity implements OnClickListener{
	private TextView tvUser;
	private Spinner spiAlumNotas;
	private Button btnGrabar;
	private String sAlumno;
	private String[] arrNombres;
	private String[] arrCodigo;
	private TextView tvLogCat;
	
	
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
		btnGrabar.setOnClickListener(this);
		
		spiAlumNotas.setOnItemSelectedListener( new OnItemSelectedListener() {

			@Override
			public void onItemSelected(AdapterView<?> arg0, View arg1,
					int arg2, long arg3) {
				sAlumno=arrNombres[arg2];
				tvLogCat.setText(arrNombres[arg2]);		}

			@Override
			public void onNothingSelected(AdapterView<?> arg0) {
				// TODO Auto-generated method stub
			}
		});
	
	}

	
	@Override
	public void onClick(View v) {
		runBackroundInsertar();
	}
	
	
	
	
	/*----------LLENAR REGISTROS EN TEXTVIEW----------*/
	protected void runBackroundInsertar() {
		AsyncTest2 backgrounTest = new AsyncTest2();
		backgrounTest.execute();
	}

	class AsyncTest2 extends AsyncTask<String, Void, String> {

//		String[] arrNombres;
//		String[] arrCodigo;

		@Override
		protected String doInBackground(String... params) {
			Funciones oFun = new Funciones();
			JSONObject oJson = oFun.listarAlumnos();// Envia los
													// parametros.}

			try {
				JSONArray jsArrData = new JSONArray(oJson.getJSONArray("data")
						.toString());
//				
//				int tamaño = jsArrData.length();
//				arrNombres = new String[tamaño];
//				arrCodigo = new String[tamaño];

				for (int i = 0; i <= jsArrData.length(); i++) {
//					JSONObject data = jsArrData.getJSONObject(i);
//					arrNombres[i] = data.getString("nombre");
//					 arrCodigo[i] = data.getString("codigo");
//					
				}
			} catch (JSONException e) {
				Log.e("TAG", "Problemas con array: " + e.getMessage());
			}

			return null;
		}

		@Override
		protected void onPostExecute(String result) {
//
//			spiAlumNotas = (Spinner) findViewById(R.id.spinAlumNota);
//			ArrayAdapter<String> arrAdapter = new ArrayAdapter<String>(
//					Profesor_Activity.this,
//					android.R.layout.simple_spinner_dropdown_item, arrNombres);
//			spiAlumNotas.setAdapter(arrAdapter);

		}

	}//end llenar spinner
	
	
	
	
	
	
	
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
				JSONArray jsArrData = new JSONArray(oJson.getJSONArray("data")
						.toString());
				
				int tamaño = jsArrData.length();
				arrNombres = new String[tamaño];
				arrCodigo = new String[tamaño];

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
			
			ArrayAdapter<String> arrAdapter = new ArrayAdapter<String>(
					Profesor_Activity.this,
					android.R.layout.simple_spinner_dropdown_item, arrNombres);
			spiAlumNotas.setAdapter(arrAdapter);

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
