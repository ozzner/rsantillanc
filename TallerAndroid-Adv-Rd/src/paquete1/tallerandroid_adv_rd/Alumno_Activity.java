package paquete1.tallerandroid_adv_rd;

import android.app.Activity;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.view.Gravity;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;

public class Alumno_Activity extends Activity {
	
private TextView tvUser;


	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_alumno);
		
		tvUser = (TextView)findViewById(R.id.tvWellcomeAlumno);
		Bundle oBundle = getIntent().getExtras();
		tvUser.setText("Bienvenido alumno, "+oBundle.getString("usuario"));
		init();
	}

	
	
	public void init() {
        TableLayout stk = (TableLayout) findViewById(R.id.table_main);
        TableRow tbrow0 = new TableRow(this);
        
        TextView tv0 = new TextView(this);
        tv0.setText(" Sl.No ");
        tv0.setTextColor(Color.GRAY);
        tbrow0.addView(tv0);
        
        TextView tv1 = new TextView(this);
        tv1.setText(" Product ");
        tv1.setTextColor(Color.GRAY);
        tbrow0.addView(tv1);
        
        TextView tv2 = new TextView(this);
        tv2.setText(" Unit Price ");
        tv2.setTextColor(Color.GRAY);
        tbrow0.addView(tv2);
        
        TextView tv3 = new TextView(this);
        tv3.setText(" Stock Remaining ");
        tv3.setTextColor(Color.GRAY);
        tbrow0.addView(tv3);
        
        stk.addView(tbrow0);
        
        for (int i = 0; i < 25; i++) {
            TableRow tbrow = new TableRow(this);
            TextView t1v = new TextView(this);
            TextView t2v = new TextView(this);
            TextView t3v = new TextView(this);
            TextView t4v = new TextView(this);
            
            t1v.setText("" + i);
            t1v.setTextColor(Color.GRAY);
            t1v.setGravity(Gravity.CENTER);
            tbrow.addView(t1v);

            t2v.setText("Product " + i);
            t2v.setTextColor(Color.GRAY);
            t2v.setGravity(Gravity.CENTER);
            tbrow.addView(t2v);
            
            t3v.setText("Rs." + i);
            t3v.setTextColor(Color.GRAY);
            t3v.setGravity(Gravity.CENTER);
            tbrow.addView(t3v);
            
            t4v.setText("" + i * 15 / 32 * 10);
            t4v.setTextColor(Color.GRAY);
            t4v.setGravity(Gravity.CENTER);
            tbrow.addView(t4v);
            
            stk.addView(tbrow);
        }

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
