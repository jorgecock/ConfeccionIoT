//Enccabezados
#include <SPI.h>
#include <WiFiNINA.h>
#include "arduino_secrets.h"
#include "ArduinoJson.h"

// VARIABLES
char ssid[] = SECRET_SSID;  //SSID de la red
char pass[] = SECRET_PASS;  //clave de la red
int keyIndex = 0;           // your network key Index number (needed only for WEP)
int status = WL_IDLE_STATUS;//estado conexión

const char* host = "192.168.43.243"; // host celular
//const char* host = "127.0.0.1"; //Conexion celular jorge cock??

const int httpPort = 80;


//Codigo

String url;
int count = 1; //Contador para barrer las alarmas de 1 a 3 en cada loop
int sensor = 1; // Id del sensor a poner en cada pc
int D1 = 3; //puerto salida alarma
int D2 = 4; //puerto salida alarma
int D3 = 5; //puerto salida alarma
String led;
String data;

// CONFIGURACIÓN INICIAL
void setup() {
  
  //Inicializacion serial
  Serial.begin(115200);
  while (!Serial) {
    ;//esperar inicio serial
  }
  delay(100);
  
  //Inicio de puertos
  pinMode(D1, OUTPUT);
  pinMode(D2, OUTPUT);
  pinMode(D3, OUTPUT);
  pinMode(LED_BUILTIN, OUTPUT);
  digitalWrite(D1, 0);
  digitalWrite(D2, 0);
  digitalWrite(D3, 0);// Alarma apagada

  //Validar wifi en modulo
  if (WiFi.status() == WL_NO_MODULE) {
    Serial.println("comunicacion con WiFi fallada");
    while (true);
  }
  
  //Validar version firmware wifi en modulo
  String fv = WiFi.firmwareVersion();
  if (fv < "1.0.0") {
    Serial.print("Actualizar el firmware");
  }

  ///Conectar a red.
  Serial.print("conectando a SSID: ");
  Serial.println(ssid);
  WiFi.begin(ssid, pass); 
  while (WiFi.status() != WL_CONNECTED) {
    status = WiFi.begin(ssid, pass);
    delay(500);
    Serial.print(".");
  }
  Serial.println("WiFi Conectado");  
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
  Serial.print("Netmask: ");
  Serial.println(WiFi.subnetMask());
  Serial.print("Gateway: ");
  Serial.println(WiFi.gatewayIP());
  Serial.print("Status: ");
  Serial.println(WiFi.status());
  Serial.println("Conexión con red OK");
  digitalWrite(LED_BUILTIN, 1);
  delay(300);
  digitalWrite(LED_BUILTIN, 0);
  delay(300);
  Serial.println("***************************************************");
}

//Loop
void loop() {

  //conectando a base de datos
  WiFiClient client;
  delay(300);
  if (!client.connect(host, httpPort)) {
    Serial.println("Conexion fallada al servidor");
    return;
  }else{
  	Serial.print("Conectado a:"+ String(host) +":"+String (httpPort)+" correctamente.");
	  Serial.println();
  }

  //enviar instruccion Leer leds 
  if (count == 1){
    url = "/confeccionIoT/api/LeerBaseDesdeDispositivo.php?idAlarma=1";
    data= "idAlarma=1";
    Serial.println("Alarma 1");
  }
  else if (count == 2){
    url = "/confeccionIoT/api/LeerBaseDesdeDispositivo.php?idAlarma=2";
    data= "idAlarma=2";
    Serial.println("Alarma 2");
  }
  else if (count == 3){
    url = "/confeccionIoT/api/LeerBaseDesdeDispositivo.php?idAlarma=3";
    data= "idAlarma=3";
    Serial.println("Alarma 3");
  }
  Serial.print("Solicitando: ");
  Serial.println(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n");
  client.print(String("GET ") + url +" HTTP/1.0\r\n"+
              "Host: " + host + "\r\n" +
              "Accept: *" + "/" +"*\r\n" +
              "Content-Length: " + data.length() + "\r\n" +
              "Content-Type: application/x-www-form-urlencoded\r\n" +
              "\r\n" + data);
  delay(2000);


  // Lectura JSON
  String section="header";
  Serial.println("Respuesta:");
  while(client.available()){
    
    String line = client.readStringUntil('\r');
    Serial.print(line);
    // we’ll parse the HTML body here
    
    if (section=="header") { // headers..
      Serial.print(": Header");
      if (line=="\n") { // Salta un espacio en la respuesta
        section="temp1";
      } 
    }

    else if (section=="temp1") {
      Serial.print(" :Paso Tempora1");
      section="json";// Salta otro espacio en la respuesta
    } 

    else if (section=="json") {  // El comando Json
      Serial.println(" :json");

      section="ignore";
      String result = line.substring(1);
      
      // Parse JSON
      int size = result.length() + 1;
      char json[size];
      result.toCharArray(json, size);

      /*Serial.print("\r\n\r\n\r\n******\r\ncontenido json\r\n");
      int i; 
      for (i=0;i<size;i++) {
        Serial.print(json[i]);
      }
      Serial.print("\r\n\r\n\r\n");*/
      
      StaticJsonBuffer<200> jsonBuffer;
      JsonObject& json_parsed = jsonBuffer.parseObject(json);
      
      if (!json_parsed.success())
      {
        Serial.println("parseObject() fallado");
        return;
      }
      
      String estado = json_parsed["alarma"][0]["estado"]; //REVISAR json_parsed["idAlarma"][0]["estado"]
      Serial.print("Estado:");
      Serial.println(estado);
      

      //led="on"; //borrar

      //verificacion segun leido por JSON
      if(count == 1){
        if(estado == "on"){
          digitalWrite(D1, 1);
          delay(100);
          Serial.println("D1: On");
        }
        else if(estado == "off"){
          digitalWrite(D1, 0);
          delay(100);
          Serial.println("D1: Off");
        }
      }
      else if(count == 2){
        if(estado == "on"){
          digitalWrite(D2, 1);
          Serial.println("D2: On");
        }
        else if(estado == "off"){
          digitalWrite(D2, 0);
          Serial.println("D2: Off");
        }
      }
      else if(count == 3){
        if(estado == "on"){
          digitalWrite(D3, 1);
          Serial.println("D3: On");
        }
        else if(estado == "off"){
          digitalWrite(D3, 0);
          Serial.println("D3: Off");
        }
      }
    }  
  }
  
  count++;
  if (count == 4){
    count=1;
  }   
  //Cerrar conexion con host servidor
  Serial.println("Cerrando conexion");
  Serial.println("***************************************************");
  client.stop();
  //Anuncio de fin de conexiones
  digitalWrite(LED_BUILTIN, 1);
  delay(300);
  digitalWrite(LED_BUILTIN, 0);
  delay(1000);
} 
