package paquete2.tallerandroid_adv_rd;

import java.util.ArrayList;
import java.util.List;
import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONObject;

import android.util.Log;
public class Funciones {
	//http://itlab.fis.ulima.edu.pe
	//ozzner-pc
 private JSONParser jsonParser;
 private static String URL_LOGIN= "http://ozzner-pc/Taller_Android_ServicioRest/api/login.php";
 private static String URL_NOTA= "http://ozzner-pc/Taller_Android_ServicioRest/api/nota_rest.php";
 private static String URL_ALUMNO= "http://ozzner-pc/Taller_Android_ServicioRest/api/alumno_rest.php";
 private static String ACCIONES[]= {"login","listar","insertar"};
 
 
 	/* ----------CONSTRUCTOR---------- */ 
	public Funciones() {
		jsonParser = new JSONParser(); }

	
	/* ----------LOGIN---------- */ 
	public JSONObject login(String codigo , String clave)
	{
		System.out.println(ACCIONES[0]);
		JSONObject json = null; 
		//Construyendo los parametros.  NameValuePair encapsula (Attributo/Valor).
		List<NameValuePair> parametros = new ArrayList<NameValuePair>();
		parametros.add( new BasicNameValuePair("accion", ACCIONES[0]));
		parametros.add( new BasicNameValuePair("id", codigo));
		parametros.add( new BasicNameValuePair("clave", clave));
		//Envia los parametros a la clase para obtener json.
		try {
			json = jsonParser.obtenerJSON_URL(URL_LOGIN, parametros);
		} catch (Exception e) {
			Log.e("URL", e.getMessage());
			}
		return json;
	}
	
	
	
	/* ----------LISTAR ALUMNOS---------- */ 
	public JSONObject listarAlumnos()
	{
		JSONObject json = null; 

		List<NameValuePair> parametros = new ArrayList<NameValuePair>();
		parametros.add( new BasicNameValuePair("accion", ACCIONES[1]));

		try {
			json = jsonParser.obtenerJSON_URL(URL_ALUMNO, parametros);
		} catch (Exception e) {
			Log.e("URL", e.getMessage());
			}
		Log.e("LISTADO-JSON", json+"");
		Log.e("ACCION",ACCIONES[1]);
	
		return json;
		
	}
	
	
	/* ----------INSERTAR NOTA---------- */ 
	public JSONObject insertarNota(String curso , String nota, String alumno, String profesor)
	{ 
		System.out.println(ACCIONES[0]);
		JSONObject json = null; 
		
		List<NameValuePair> parametros = new ArrayList<NameValuePair>();
		parametros.add( new BasicNameValuePair("accion", ACCIONES[2]));
		parametros.add( new BasicNameValuePair("curso", curso));
		parametros.add( new BasicNameValuePair("nota", nota));
		parametros.add( new BasicNameValuePair("alumno", alumno));
		parametros.add( new BasicNameValuePair("profesor", profesor));

		try {
			json = jsonParser.obtenerJSON_URL(URL_LOGIN, parametros);
		} catch (Exception e) {
			Log.e("URL", e.getMessage());
			}
		return json;
	}

	
 	
}
