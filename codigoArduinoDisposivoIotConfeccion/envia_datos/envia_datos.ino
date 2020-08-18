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

const char* host = "192.168.43.243"; // host celular para 
//const char* host = "127.0.0.1"; //Conexion celular jorge cock??

const int httpPort = 80;


//Codigo

String url = "/ConfeccionIoT/api/EscribirABaseDesdeDispositivo.php";
int estadosensor1 =0;
int estadosensoranterior1=0;
int estadosensor2 =0;
int estadosensoranterior2=0;
int Input1 = 5; //puerto entrada en placa Arduino para Pulsador produccion
int Input2 = 4; //puerto entrada en placa Arduino para Paro de emergencia
int Output1 = 3; //puerto Salida en placa Arduino para Led pulsado boton
int Output2 = 2; //puerto Salida en placa Arduino para Led estado y comunicaciones

int value = 0; //valor inicial
int id=1; // NUMERO DE LA ESTACIÓN

// CONFIGURACIÓN INICIAL
void setup() {
  
  

  //Inicio de puertos
  pinMode(Input1, INPUT_PULLUP);
  pinMode(Input2, INPUT_PULLUP);
  pinMode(LED_BUILTIN, OUTPUT);
  pinMode(Output1, OUTPUT);
  pinMode(Output2, OUTPUT);
  digitalWrite(Output1, 1);
  digitalWrite(Output2, 1);
  
  //Inicializacion serial
  Serial.begin(115200);
  //while (!Serial) {
    ;//esperar inicio serial
  //}
  //delay(100);

  //Primera Lectura
  estadosensor1 = digitalRead(Input1);
  estadosensor2 = digitalRead(Input2);
  Serial.print("Estado sensor1");
  Serial.println(estadosensor1);
  Serial.print("Estado sensor2");
  Serial.println(estadosensor2);
  Serial.println("************");
  
  //Validar wifi en modulo
  if (WiFi.status() == WL_NO_MODULE) {
    Serial.println("comunicacion con WiFi fallada");
    while (true);
    //Mensaje señal de error 
    digitalWrite(Output2, 0);
    delay(20);
    digitalWrite(Output2, 1);
    delay(20);
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
    digitalWrite(Output2, 0);
    delay(200);
    digitalWrite(Output2, 1);
    delay(200);
    Serial.print(".");
  }

  //conectado
  digitalWrite(Output1, 1);
  digitalWrite(Output2, 1);
  Serial.println("WiFi Conectado");  
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
  Serial.print("Netmask: ");
  Serial.println(WiFi.subnetMask());
  Serial.print("Gateway: ");
  Serial.println(WiFi.gatewayIP());
  Serial.print("Status: ");
  Serial.println(WiFi.status());
  Serial.println("Conexión con red OK");
  Serial.println("***************************************************");
  delay(100);

}
 
void loop() {
  estadosensor1 = digitalRead(Input1);
  digitalWrite(Output1, !estadosensor1);
  estadosensor2 = digitalRead(Input2);

  if (((estadosensor1!=estadosensoranterior1) and estadosensor1==1) or ((estadosensor2!=estadosensoranterior2) and estadosensor2==1){
    Serial.print("Estado sensor1: ");
    Serial.println(estadosensor1);
    Serial.print("Estado sensor2: ");
    Serial.println(estadosensor2);
    Serial.println("************");

    //Concetarse a la base de datos
    WiFiClient client;
    delay(300);
    if (!client.connect(host, httpPort)) {
      Serial.println("Conexion fallada al servidor");
      digitalWrite(Output2, 0);
      delay(10);
      digitalWrite(Output2, 1);
      delay(10);
      digitalWrite(Output2, 0);
      delay(10);
      digitalWrite(Output2, 1);
      delay(10);
      digitalWrite(Output2, 0);
      delay(10);
      digitalWrite(Output2, 1);
      delay(10);
      return;
    }else{
      Serial.println("Conectado a:"+ String(host) +":"+String (httpPort)+" correctamente.");
      Serial.println();
    }

    //comando para la base de datos a traves de API.
    String data= "id="+String(id)+"&Boton1="+String(estadosensor1)+"&Boton2="+String(estadosensor2);
    Serial.println("Solicitando: ");
    
    //envio de comando por monitor serial para visualizar lo enviado y verificar.
    Serial.print(String("GET ") + url+ "?" + data+" HTTP/1.0\r\n"+
              "Host: " + host + "\r\n" +
              "Accept: *" + "/" +"*\r\n" +
              "Content-Length: " + data.length() + "\r\n" +
              "Content-Type: application/x-www-form-urlencoded\r\n" +
              "\r\n" + data);

    //envio de comando por wifi a servidor, mismo comando
    client.print(String("GET ") + url+ "?" + data+" HTTP/1.0\r\n"+
              "Host: " + host + "\r\n" +
              "Accept: *" + "/" +"*\r\n" +
              "Content-Length: " + data.length() + "\r\n" +
              "Content-Type: application/x-www-form-urlencoded\r\n" +
              "\r\n" + data);

    Serial.println("");
    delay(1000);
    Serial.println("************");
    Serial.println("Respuesta:");
    
    //leer respuesta serial Wifi
    while(client.available()){
      String line = client.readStringUntil('\r');
      Serial.print(line);
    }
    Serial.println("");

    /*if (!client.connected()) {
      Serial.println();
      Serial.println("Desconectado del servidor.");
      client.stop();
      // hacer nada
      while (true);
    }*/

    Serial.println("************");
    Serial.println("Cerrando conexion");
    client.stop();
    estadosensoranterior1=estadosensor1;
    estadosensoranterior2=estadosensor2;
    Serial.println("***************************************************");
    Serial.println("\r\n");
  }
  
  digitalWrite(Output2, 0);
  delay(300);
  digitalWrite(Output2, 1);
  delay(1000);
}
