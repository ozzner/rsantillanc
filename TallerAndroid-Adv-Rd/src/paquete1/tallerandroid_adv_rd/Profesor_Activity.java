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
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.Spinner;
import android.widget.TextView;

public class Profesor_Activity<AsyncTest> extends Activity {
	private TextView tvUser;
	private Spinner spiAlumNotas;
	private Button btnEliminar;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_profesor);

		tvUser = (TextView) findViewById(R.id.tvWellcomeProfesor);
		Bundle oBundle = getIntent().getExtras();
		tvUser.setText("Bienvenido profesor, " + oBundle.getString("usuario"));

	}

	protected void runBackround() {
		AsyncTest backgrounTest = new AsyncTest();
		backgrounTest.execute();
	}

	class AsyncTest extends AsyncTask<String, Void, String> {

		String[] arrNombres;
		String[] arrCursos;

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

				for (int i = 0; i <= jsArrData.length(); i++) {
					JSONObject data = jsArrData.getJSONObject(i);
					arrNombres[i] = data.getString("nombre");
				}
			} catch (JSONException e) {
				Log.e("TAG", "Problemas con array: " + e.getMessage());
			}

			return null;
		}

		@Override
		protected void onPostExecute(String result) {

			spiAlumNotas = (Spinner) findViewById(R.id.spinAlumNota);
			ArrayAdapter<String> arrAdapter = new ArrayAdapter<String>(
					Profesor_Activity.this,
					android.R.layout.simple_spinner_dropdown_item, arrNombres);
			spiAlumNotas.setAdapter(arrAdapter);

		}

	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.menu, menu);
		return true;
	}

	/*----------MENU----------*/
	@Override
	public boolean onOptionsItemSelected(MenuItem item) {

		switch (item.getItemId()) {
		case R.id.mnu1:
			runBackround();
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
