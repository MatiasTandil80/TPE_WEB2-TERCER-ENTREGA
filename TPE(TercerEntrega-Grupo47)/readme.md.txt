Se adjunta el export de las colecciones de los endpoints del Postman.

En nuestra entrega declaramos una variable en POSTMAN llamada base_url, de manera que el principio de cada ruta en este readme va a ser mostrada con el inicio de la misma, de la forma {{base_url}}/TPE(TercerEntrega-Grupo47)/api/modelos.


								TABLA MODELOS

GET
-----------------------------------------------------------------------------------------------
GET GENERAL

{{base_url}}/TPE(TercerEntrega-Grupo47)/api/modelos

Retorna todos los modelos de motos de manera identica a como se encuentran en la tabla de la base de datos
-----------------------------------------------------------------------------------------------
GET INDIVIDUAL POR ID

{{base_url}}/TPE(TercerEntrega-Grupo47)/api/modelos?id=43

Retorna el modelo de moto especificado por un id. En este caso, retorna los datos de la moto con id 43.
Si el id no existe, se muestra un mensaje de error: "La moto con el id:$id no existe".

-----------------------------------------------------------------------------------------------
GET CON ORDEN

{{base_url}}/TPE(TercerEntrega-Grupo47)/api/modelos?orderBy=nombre=ASC

Retorna todos los modelos de motos, ordenados acorde a un criterio determinado, a través del parámetro 'orderBy', donde se especifica una columna de la tabla, seguido por =ASC o =DESC. 
En este ejemplo, se mostrarían ordenados por nombre en forma ascendente.
En caso que se solicite un orden a través de una columna inexistente, se realiza una consulta general y se envía un mensaje indicando lo sucedido: "Orden no Valido. Se realiza consulta general" . 

-----------------------------------------------------------------------------------------------
GET CON FILTRO

{{base_url}}/TPE(TercerEntrega-Grupo47)/api/modelos?filterBy=tipo=deportiva

Retorna todos los modelos de motos que pertenezcan al valor de una columna determinada, a través del parámetro 'filterBy'.
En este ejemplo, se mostrarían aquellas motos que sean de tipo "deportiva".
En caso que se solicite un filtro a través de una columna inexistente, se realiza una consulta general y se envía un mensaje indicando lo sucedido: "Filtro no Valido. Se realiza consulta general" . 

-----------------------------------------------------------------------------------------------
GET CON PAGINACION

{{base_url}}/TPE(TercerEntrega-Grupo47)/api/modelos?offset=3

Retorna todos los modelos de motos a partir de un indice, a través del parámetro offset, donde el primer elemento se enumera desde el valor 1. En caso de que el offset supere el tamaño de la cantidad de elementos existentes, no será tenido en cuenta, retornando los elementos desde el inicio. 
En este caso, comienza la enumeración a partir del tercer elemento.

{{base_url}}/TPE(TercerEntrega-Grupo47)/api/modelos?pagination=5

Retorna todos los modelos de motos hasta un indice, a través del parámetro pagination. En caso de superar la cantidad de elementos existentes, no será tenido en cuenta. 
En este caso, se enumeran hasta el quinto elemento.


{{base_url}}/TPE(TercerEntrega-Grupo47)/api/modelos?offset=1&pagination=5

Retorna todos los modelos de motos hasta una cierta cantidad a través del parámetro 'pagination'. 
En este ejemplo, se mostraría los primeros 5 modelos de motos.

-----------------------------------------------------------------------------------------------
GET COMBINADOS

{{base_url}}/TPE(TercerEntrega-Grupo47)/api/modelos?filterByTipo=deportiva&orderby=nombre ASC

{{base_url}}/TPE(TercerEntrega-Grupo47)/api/modelos?orderby=tipo DESC&offset=1&pagination=3

{{base_url}}/TPE(TercerEntrega-Grupo47)/api/modelos?filterByTipo=deportiva&orderby=nombre ASC&offset=1&pagination=5

-----------------------------------------------------------------------------------------------

POST

{{base_url}}/TPE(TercerEntrega-Grupo47)/api/modelos

Este endpoint se utiliza para ingresar un modelo de moto en la base de datos, a través del siguiente formato:

{
        "id_marca": 135,
        "nombre": "YZF-R1",
        "cilindrada_cm3": 998,
        "tipo": "deportiva",
        "potencia_hp": 200,
        "peso_kg": 200
}

En este caso, se insertará una nueva moto con los datos del JSON descriptos anteriormente.
En caso de que se omita el ingreso de un dato, se mostrará un mensaje de error, solicitando el reingreso de todo el objeto.
Si el nombre de la moto ya existe, se muestra un mensaje de error informándolo.
-----------------------------------------------------------------------------------------------

PUT

{{base_url}}/TPE(TercerEntrega-Grupo47)/api/modelos/56

Este endpoint se utiliza para modificar un modelo de moto existente en la base de datos, a través del siguiente formato:

{
        "id_marca": 135,
        "nombre": "YZF-R1",
        "cilindrada_cm3": 998,
        "tipo": "deportiva",
        "potencia_hp": 200,
        "peso_kg": 200
}

En este caso, se modificará la moto con id=56, tomando los valores del JSNO anterior.
Donde debe colocarse al final del endpoint el "id" de la moto correspondiente.
Si el "id" de la moto no existe, retorna un mensaje de error.
En caso de no especificar algun/os campo/s, sólo se modificarán los descriptos en el JSON
-----------------------------------------------------------------------------------------------

DELETE

{{base_url}}/TPE(TercerEntrega-Grupo47)/api/modelos/56

Este endpoint se utiliza para borrar un determinado modelo de moto, escribiendo su id correspondiente al final del mismo.

En este ejemplo se borrará la moto con id=56.

En caso afirmativo, se muestra un mensaje informando el borrado. En caso de no existir el id solicitado, se muestra un mensaje de error. 

-------------------------------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------------------------


								TABLA MARCAS

GET
-----------------------------------------------------------------------------------------------
GET GENERAL

{{base_url}}/TPE(TercerEntrega-Grupo47)/api/marcas

Retorna todos los marcas de motos de manera identica a como se encuentran en la tabla de la base de datos
-----------------------------------------------------------------------------------------------
GET INDIVIDUAL POR ID

{{base_url}}/TPE(TercerEntrega-Grupo47)/api/marcas?id=134

Retorna la marca especificada por un id. En este caso, retorna los datos de la marca con id=134.
Si el id no existe, se muestra un mensaje de error: "La marca con el id:$id no existe".

-----------------------------------------------------------------------------------------------

POST

{{base_url}}/TPE(TercerEntrega-Grupo47)/api/marcas

Este endpoint se utiliza para ingresar una marca de moto en la base de datos, a través del siguiente formato:

{
        "nombre": "Zanella",
        "origen": "Argentina",
        "año_fundacion": 1950,
        "cant_empleados": 22,
        "produccion_anual": 140000,
        "facturacion_M_USD": 6
}

En este caso, se insertará una nueva marca con los datos del JSON descriptos anteriormente.
En caso de que se omita el ingreso de un dato, se mostrará un mensaje de error, solicitando el reingreso de todo el objeto.
Si el nombre de la marca ya existe, se muestra un mensaje de error informándolo.
-----------------------------------------------------------------------------------------------

PUT

{{base_url}}/TPE(TercerEntrega-Grupo47)/api/marcas/134

Este endpoint se utiliza para modificar una marca existente en la base de datos, colocando el id al final del endpoint, y a través del siguiente formato:

{
        "nombre": "honda",
        "origen": "japon",
        "año_fundacion": 1949,
        "cant_empleados": 220,
        "produccion_anual": 14000000,
        "facturacion_M_USD": 68
}

En este caso, se modificará la marca con id=134, tomando los valores del JSON anterior.
En caso de no existir el "id" de la marca, se retornará un mensaje de error.
En caso de modificar el nombre, se verificará que no se repita con el nombre de otro id de marca.
En caso de no especificar algun/os campo/s, sólo se modificarán los descriptos en el JSON.
-----------------------------------------------------------------------------------------------

DELETE

{{base_url}}/TPE(TercerEntrega-Grupo47)/api/modelos/140

Este endpoint se utiliza para borrar una determinada marca, escribiendo su id correspondiente al final del mismo.

En este ejemplo se borrará la marca con id=140.
Si el borrado se realiza satisfactoriamente, se informa en un mensaje. 
En caso de no existir el id solicitado, se muestra un mensaje de error. 

-------------------------------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------------------------


								TABLA RESEÑAS




GET
-----------------------------------------------------------------------------------------------
GET GENERAL

{{base_url}}/TPE(TercerEntrega-Grupo47)/api/reseñas

Retorna todas las reseñas de las marcas de manera identica a como se encuentran en la tabla de la base de datos, especificando el nombre de la marca.
-----------------------------------------------------------------------------------------------
GET INDIVIDUAL POR ID

{{base_url}}/TPE(TercerEntrega-Grupo47)/api/reseñas?id=134

Retorna la reseña especificada por un id. En este caso, retorna los datos de la reseña con id=134.
Si el id no existe, se muestra un mensaje de error: "La marca con el id:$id no posee reseña".

-----------------------------------------------------------------------------------------------

POST

{{base_url}}/TPE(TercerEntrega-Grupo47)/api/reseñas

Este endpoint se utiliza para ingresar una reseña de marca en la base de datos, a través del siguiente formato:

{
        "id_marca": "140",
        "detalle": "Esta fabrica comenzó en Japón..."
 }

En este caso, se insertará una nueva reseña con los datos del JSON descriptos anteriormente.
En caso de que se omita el ingreso de un dato, se mostrará un mensaje de error, solicitando el reingreso de todo el objeto.
Si existe previamente una reseña para ese id de marca, se mostrará un mensaje de error informándolo.
-----------------------------------------------------------------------------------------------

PUT

{{base_url}}/TPE(TercerEntrega-Grupo47)/api/reseñas/140

Este endpoint se utiliza para modificar una reseña existente en la base de datos, colocando el id al final del endpoint, y a través del siguiente formato:

{
        "detalle": "Esta fabrica comenzó en Japón..."
 }


En este caso, se modificará la reseña perteneciente a la marca con id=140, tomando los valores del JSON anterior.
En caso de no existir el "id" de la marca, se retornará un mensaje de error.
En caso de no especificar el detalle, se solicitará el reingreso de los datos completos.
-----------------------------------------------------------------------------------------------

DELETE

{{base_url}}/TPE(TercerEntrega-Grupo47)/api/reseñas/140

Este endpoint se utiliza para borrar una determinada reseña, escribiendo su id correspondiente al final del mismo.

En este ejemplo se borrará la reseña perteneciente a la marca con id=140.
Si el borrado se realiza satisfactoriamente, se informa en un mensaje. 
En caso de no existir una reseña con el id solicitado, se muestra un mensaje de error. 

-------------------------------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------------------------




