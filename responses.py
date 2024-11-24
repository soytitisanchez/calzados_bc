import re

def process_message(message, response_array, response):
    #Divir el mensaje y la puntuacion dentro del array 
    list_message = re.findall(r"[\w']+|[.,!?¿¡;)]", message.lower())
                                 
    #Puntua el conjunto de palabras en el mensaje 
    score = 0
    for word in list_message:
        if word in response_array:
           score = score + 1
           
    #Retorna las respuestas y el score de la respuesta 
    print(score, response) #Esto ees solamente para debbuging
    return [score, response]
    
def get_response(message):
    #Agrega tu respuesta perzonalizada
    response_list = [
        process_message(message,['Hola','Hey','Buenas','Holis'], 'Hola! Cómo estas ?'),
        process_message(message,['bye','chau','adios','Hasta''luego'], 'chau, que la pases bien!'),
        process_message(message,['Como','Cómo','Estás','Estas','vos'], 'Yo estoy muy bien muchas gracias'),
        process_message(message,['Como','es','tu','nombre'], 'Mi nombre es Cintia Sanchez'),
        process_message(message,['Me','puedes','ayudar','Help','Ayuda'], 'Si,¿en que puedo ayudarte?'),
        #Si quieres, puedes agregar mas respuestas
        
    ]
    
    #Revisa todas las respuestas score y retorna la conexion posible 
    response_scores = []
    for response in response_list:
        response_scores.append(response[0])
        
    #Obtener el mayor valor posible para la mejor respuesta y almacenarlo dentro de una variable 
    winning_response = max(response_scores)
    matchin_response = response_list[response_scores.index(winning_response)]
    
    #Retorna el matching response al usuario 
    if winning_response == 0:
       bot_response = 'Yo no logro entender lo que escribiste'
    else:
        bot_response = matchin_response[1]
        
    print('La respuesta del Bot:', bot_response)
    return bot_response             
        