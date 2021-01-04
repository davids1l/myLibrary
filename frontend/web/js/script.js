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
    //client.end()
})

client.publish("req/test1", "hello from local!")