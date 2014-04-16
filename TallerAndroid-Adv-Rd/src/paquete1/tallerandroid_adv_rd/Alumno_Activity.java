package paquete1.tallerandroid_adv_rd;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.TextView;

public class Alumno_Activity extends Activity {
	
private TextView tvUser;


	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_alumno);
		
		tvUser = (TextView)findViewById(R.id.tvWellcomeAlumno);
		Bundle oBundle = getIntent().getExtras();
		tvUser.setText("Bienvenido alumno, "+oBundle.getInt("usuario"));
	}

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
			// do something for menu 2
			break;
		case R.id.mnu2:
			Intent itLogin = new Intent(getApplicationContext(),Login_Activity.class);
			startActivity(itLogin);finish();
			break;
		}
		return super.onOptionsItemSelected(item);
	}

}
