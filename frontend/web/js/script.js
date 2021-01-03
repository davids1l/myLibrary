var client;
var reconnectTimeout = 2000;
var host="127.0.0.1";
var port=9001;

function onConnect() {
    console.log("connected sucessfully");
    client.subscribe("req/#");
}
function onFailure(message) {
    console.log("connection attempt to host " + host + " failed");
    setTimeout(MQTTConnect, reconnectTimeout);
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
    client = new Paho.MQTT.Client(host, port, "pahomqtt-subscriber");
    var options = {
        timeout: 3,
        onSuccess: onConnect,
        onFailure: onFailure
    };
    client.onMessageArrived = onMessageArrived;
    client.onConnectionLost = onConnectionLost;

    client.connect(options);
}

MQTTConnect();