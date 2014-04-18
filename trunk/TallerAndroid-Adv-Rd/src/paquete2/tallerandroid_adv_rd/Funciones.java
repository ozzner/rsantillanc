package paquete2.tallerandroid_adv_rd;

import java.util.ArrayList;
import java.util.List;
import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONObject;

import android.util.Log;
public class Funciones {
	//http://itlab.fis.ulima.edu.pe
	//192.168.1.37
 private JSONParser jsonParser;
 private static String URL_LOGIN= "http://itlab.fis.ulima.edu.pe/Taller_Android_ServicioRest/api/login.php";
 private static String URL_NOTA= "http://192.168.1.34/Taller_Android_ServicioRest/api/nota_rest.php";
 private static String URL_ALUMNO= "http://192.168.1.34/Taller_Android_ServicioRest/api/alumno_rest.php";
 private static String ACCIONES[]= {"login","listar"};
 
 
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
	
	
	
 /* ----------ALUMNOS---------- */ 
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
	
	
 /* ALUMNO*/
//	public JSONObject OTRO(String alumno,int nota,String profesor)
//	{
//		JSONObject json = null; 
//
//		List<NameValuePair> parametros = new ArrayList<NameValuePair>();
//		parametros.add( new BasicNameValuePair("accion", ACCIONES[0]));
//		parametros.add( new BasicNameValuePair("id", codigo));
//		parametros.add( new BasicNameValuePair("clave", clave));
//
//		try {
//			json = jsonParser.obtenerJSON_URL(URL_LOGIN, parametros);
//		} catch (Exception e) {
//			Log.e("URL", e.getMessage());
//			}
//		
//		return json;
//		
//	}
	
	
 	
}
