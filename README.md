# Local slider
El plugin local slider para [Moodle](https://moodle.org), tiene como función principal gestionar los sliders para los cursos NCA 1-3 de primaria.
Sus funciones se describen en los apartados siguientes.
## Creación y repositorio de sliders :pencil:
Se pueden añadir sliders al repositorio de varias formas:
1. Insertando el JSON del slider creado por otros medios.
2. Creando el slider desde cero con el editor de sliders integrado.
3. Duplicando un slider para editarlo después, útil en el caso de traducciones.

Los sliders se pueden consultar si estamos dentro de la plataforma moodle con la llamada `/local/slider/getslider.php?slidername=XXXX` donde `XXXX` es el nombre del slider.
## Web service :loudspeaker:
El plugin integra un web service REST con dos posibles llamadas:
1. `local_slider_get_sliders` 
    No tiene parámetros.
    Devuelve todos los sliders de la base de datos en forma de cadena *tab+newline* comprimida.
2. `local_slider_get_new_sliders` 
    Toma como parámetro una fecha en formato timestamp.
    Devuelve todos los sliders de la base de datos posteriores a la fecha dada, en forma de cadena *tab+newline* comprimida.

Es necesario configurar el web service, creando un token y un usuario que tenga acceso.
## Actualización de sliders :arrows_clockwise:
Es posible actualizar los sliders desde un sitio moodle concreto que tenga instalado el plugin y configurado el web service.
Para activar esta funcionalidad hay que realizar los siguientes pasos:
1. Activar la sincronización en los ajustes del plugin.
2. Añadir una URL y un token del sitio con el que queremos sincronizar.
3. Activar la tarea periódica de actualización, definida ya en el código. Por defecto se actualiza cada día a la 1:30 am, pero puede cambiarse en los ajustes de Moodle.
## Pendiente :rocket:
* Hacer / restaurar copia de seguridad de los sliders.
* Generar PDF a partir de un 
* Completar manual de usuario.
