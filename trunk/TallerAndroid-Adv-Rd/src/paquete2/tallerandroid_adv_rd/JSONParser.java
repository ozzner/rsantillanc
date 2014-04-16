package paquete2.tallerandroid_adv_rd;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.util.List;
import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONObject;

import android.util.Log;

public class JSONParser {
	static InputStream inStream = null;//Leertor de bytes
    static JSONObject oJson = null;//Objeto json
    static String json = ""; //Variable
    
    //Constructor
	public JSONParser() {
		super();
		// TODO Auto-generated constructor stub
	}
	
    /*Esto se realiza creando y ajustando una lista de NameValuePairs como la entidad HttpPost.*/
    public JSONObject obtenerJSON_URL(String url, List<NameValuePair> parametros) {
    	
    	// Creando respuesta HTTP 
    	try {
    		/*Crea los objetos HttpClient y HttpPost para ejecutar la solicitud POST*/
    		DefaultHttpClient cliente_Http = new DefaultHttpClient();
    		HttpPost httpPost = new HttpPost(url);					 
    		/* lanzada por httpPost.setEntity().*/
    		httpPost.setEntity(new UrlEncodedFormEntity(parametros));
    		
    		HttpResponse httpResponse = cliente_Http.execute(httpPost);
    		/*Entidad que puede ser enviada o recibida con mensaje http*/
    		HttpEntity httpEntity = httpResponse.getEntity();
    		inStream = httpEntity.getContent();
    		
		} catch (UnsupportedEncodingException e) {
            e.printStackTrace();
        } catch (ClientProtocolException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }
    	Log.e("TAG-INPUTSTREAM", inStream +"");
    	/* Recibe la data, la almacena y la transforma a una cadena String*/
    	try {
    		/*Permite manejar el flujo de caracteres de entrada almacenado en búfer.*/
    	    BufferedReader buffReader = new BufferedReader(new InputStreamReader(inStream,"UTF-8"),8);
    	    StringBuilder sBuider = new StringBuilder(); //Crear string, mejor manejo de memoria.
    	    String sLinea = null;
    	    while((sLinea = buffReader.readLine()) != null)
    	    {
    	    	sBuider.append(sLinea+"\n"); //Agrega los datos a stringBuider
    	    }
    	    inStream.close();//Cerramos el string
    	    json = sBuider.toString();
    	    Log.e("JSON", json);
    	    
		} catch (Exception e) {
			Log.e("Error Buffer", "Error convirtiendo el resultado " + e.toString());
		}
    	
    	/* El analizador de String tranforma a Objeto JSON */
    	try {
			oJson = new JSONObject(json);
		} catch (Exception e) {
			 Log.e("JSON Parser", "Error al analizar Data" + e.toString());
		}
    	
    	
    	return oJson; //devuelve el Objeto JSON
    	
    }



}
