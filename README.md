Documentación de la API

Para realizar las pruebas de la API por Postman, utilizaremos las siguientes rutas:

1. Autenticación
    POST   http://127.0.0.1:8000/api/login
    Descripción: Autentica a un usuario y devuelve un token.

    Solicitud:

    {
        "email": "encargado@gmail.com",
        "password": "encargado"
    }

    Respuesta: 

    {
        "token": "1|60ZjkPsLwODOMei5orp79A9UCycvC0JfMzvogO7R",
        "user": {
            "id": 1,
            "codigo_trabajador": "001",
            "name": "Usuario Uno",
            "email": "encargado@gmail.com",
            "telefono": "1234567890",
            "puesto": "-",
            "rol": "Encargado",
            "email_verified_at": "2024-09-05 06:13:01",
            "remember_token": null,
            "current_team_id": null,
            "profile_photo_path": null,
            "created_at": "2024-09-05T06:13:01.000000Z",
            "updated_at": "2024-09-05T06:13:01.000000Z"
        }
    }

    Con el token generado se podra realizar las siguientes peticiones.


2. Pedidos

    * GET http://127.0.0.1:8000/api/pedidos
        Descripción: Lista los pedidos.


    * POST http://127.0.0.1:8000/api/pedidos
        Descripción: Registra un nuevo pedido.

        Solicitud:

        {
            "numero_pedido": "P001",
            "fecha_pedido": "2024-09-01",
            "fecha_recepcion": "2024-09-02",
            "fecha_despacho": "2024-09-03",
            "fecha_entrega": "2024-09-04",
            "vendedor_id": 1,
            "repartidor_id": 2,
            "estado": "por_atender",
            "detalles": [
                {
                    "producto_id": 1,
                    "cantidad": 10,
                    "precio_unitario": 15.50
                },
                {
                    "producto_id": 2,
                    "cantidad": 5,
                    "precio_unitario": 25.00
                }
            ]
        }

    *  PUT  http://127.0.0.1:8000/api/pedidos/3/por-atender
        Descripción: Actualiza el estado del pedido a "por_atender".

        Solicitud:

        {
            "fecha_pedido": "2024-09-01"
        }

    *  PUT  http://127.0.0.1:8000/api/pedidos/3/en-proceso
        Descripción: Actualiza el estado del pedido a "en_proceso".

        Solicitud:

        {
            "fecha_recepcion": "2024-09-01"
        }

    *  PUT  http://127.0.0.1:8000/api/pedidos/3/en-delivery
        Descripción: Actualiza el estado del pedido a "en_delivery".

        Solicitud:

        {
            "fecha_despacho": "2024-09-01"
        }

    *  PUT  http://127.0.0.1:8000/api/pedidos/3/recibido
        Descripción: Actualiza el estado del pedido a "recibido".

        Solicitud:

        {
            "fecha_entrega": "2024-09-01"
        }



