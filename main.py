import logging
from telegram.ext import* 
from telegram import Update
import responses 

API_TOKEN='7718857094:AAHsppjGpWIAywJSlzyFz8EBJafIZp9aRWQ'

# Configuracion del login
logging.basicConfig(format='%(asctime)s - %(levelname)s- %(message)s',level=logging.INFO)
logging.info('iniciando Bot...')

async def start_command(update:Update,contex):
    await update.message.reply_text('Hola!!! soy bot calzados  a tu servicio')
    
async def help_command(update:Update, context):
    await update.message.reply_text('¿Cual es tu calzado favorito y talla?')
      
async def custom_command(update:Update,context):
    await update.message.reply_text('Puedes consultarme lo que desees tenemos lo mejor en calzados.')
    
async def handle_message(update:Update, context):
   text = str(update.message.text).lower()     
   logging.info(f'user({update.message.chat.id})escribio: {text}')
   response = responses.get_response(text)
   
   #Respuestas del bot
   await update.message.reply_text(response)
   
async def error(update:Update, context):
    #Los eroores de los logs
    logging.error(f'update{update}causa del error{context.error}')
    
if __name__ == '__main__':
    application = Application.builder().token(API_TOKEN).build()
    
    #Comandos 
    application.add_handler(CommandHandler('start', start_command))      
    application.add_handler(CommandHandler('help', help_command))   
    application.add_handler(CommandHandler('custom', custom_command))
    
    #Mensajes
    application.add_handler(MessageHandler(filters.TEXT, handle_message))
    
    #Log de todos los errores 
    application.add_error_handler(error)
    
    #Ejecutar el Bot 
    application.run_polling(poll_interval=1.0)
    
   
   