package paquete2.tallerandroid_adv_rd;

import java.util.ArrayList;
import java.util.List;
import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONObject;

import android.util.Log;
public class Funciones {

 private JSONParser jsonParser;
 private static String URL_LOGIN= "http://itlab.fis.ulima.edu.pe/Taller_Android_ServicioRest/api/login.php";
 private static String ACCIONES[]= {"login"};
 
 /* CONSTRUCTOR */
	public Funciones() {
		jsonParser = new JSONParser(); }

 /* LOGIN */  
	public JSONObject login(String codigo , String clave)
	{
		//Construyendo los parametros.  NameValuePair encapsula (Attributo/Valor).
		List<NameValuePair> parametros = new ArrayList<NameValuePair>();
		parametros.add( new BasicNameValuePair("accion", ACCIONES[0]));
		parametros.add( new BasicNameValuePair("id", codigo));
		parametros.add( new BasicNameValuePair("clave", clave));
		//Envia los parametros a la clase para obtener json.
		JSONObject json = jsonParser.obtenerJSON_URL(URL_LOGIN, parametros);
		return json;
	}
 	
}
