/*var client;
var reconnectTimeout = 2000;
var host="127.0.0.1";
var port=9001;

function onConnect() {
    console.log("connected sucessfully");
    client.subscribe("req/#");
    message = new Paho.MQTT.Message("Hello");
    message.destinationName = "req/hi";
    client.send(message);
}
function onFailure(message) {
    console.log("connection attempt to host " + host + " failed");
    //setTimeout(MQTTConnect, reconnectTimeout);
}
function onConnectionLost(responseObject) {
    if (responseObject.errorCode !== 0) {
        console.log("onConnectionLost:"+responseObject.errorMessage);
    }
}
function onMessageArrived(message) {
    console.log("onMessageArrived:"+message.payloadString);
}

function MQTTConnect() {
    console.log("connecting to " + host + " " + port);
    client = new Paho.MQTT.Client(host, port, "pahomqttSubscriber");
    var options = {
        timeout: 3,
        onSuccess: onConnect,
        mqttVersion: 3
        //onFailure: onFailure
    };
    client.onMessageArrived = onMessageArrived;
    client.onConnectionLost = onConnectionLost;

    client.connect(options);
}

MQTTConnect();*/


var options = {
    clean: true, // retain session
    connectTimeout: 4000, // Timeout period
    // Authentication information
    clientId: 'publisherMQTTest'
}

var connectUrl = 'ws://127.0.0.1:9001/mqtt'
var client = mqtt.connect(connectUrl, options)

client.subscribe("req/#")

client.on('reconnect', function(error){
    console.log('reconnecting:', error)
})

client.on('error', function(error){
    console.log('Connection failed:', error)
})

client.on('message', function(topic, message){
    console.log('receive message：', topic, message.toString())
    client.end()
})

client.publish("req/test1", "hello from local!")